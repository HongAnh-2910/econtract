<?php

namespace App\Http\Controllers;

use App\Http\Actions\ContractAction;
use App\Http\Actions\SignatureAction;
use App\Http\Requests\ValidateContractRequest;
use App\Mail\Contract\SendMailToClientSign;
use App\Mail\Contract\SendMailToFollow;
use App\Mail\Contract\SignatureCompleted;
use App\Models\Banking;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\File;
use App\Models\Folder;
use App\Models\FollowSignature;
use App\Models\ListRecipient;
use App\Models\SampleContract;
use App\Models\Signatures;
use App\Models\SignatureTemplate;
use App\Models\User;
use App\Services\CrawlCompanyInformation;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use setasign\Fpdi\Fpdi;
use Validator;

class ContractController extends Controller
{
    const STATUS = 'status';

    protected $contractAction;
    protected $signatureAction;
    protected $folder;
    protected $crawlCompanyInformation;

    public function __construct(
        ContractAction          $contractAction,
        SignatureAction         $signatureAction,
        Folder                  $folder,
        CrawlCompanyInformation $crawlCompanyInformation
    )
    {
        $this->contractAction = $contractAction;
        $this->folder = $folder;
        $this->signatureAction = $signatureAction;
        $this->crawlCompanyInformation = $crawlCompanyInformation;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $status = $request->get('status');

        $contractsViaStatus = $this->contractAction->getContractsGroupByStatus(Auth::user(), $keyword);
        $statusContracts = $this->contractAction->convertContractsToArray($contractsViaStatus->toArray(), self::STATUS);
        $listContract = $this->contractAction->getContractsViaStatus(Auth::user(), $status, $keyword);
        $statusApplication = $this->contractAction->statusActiveContractResponsive($request);

        return view('dashboard.contract.list', [
            'listContract' => $listContract,
            'statusContracts' => $statusContracts,
            'stt' => $request->page ? ($request->page - 1) * 15 + 1 : 1,
            'type' => 'personal',
            'statusApplication' => $statusApplication
        ]);
    }

    public function indexCompany(Request $request)
    {
        $keyword = $request->get('search');
        $status = $request->get('status');

        $contractsViaStatus = $this->contractAction->getContractsGroupByStatus(Auth::user(), $keyword, 'company');
        $statusContracts = $this->contractAction->convertContractsToArray($contractsViaStatus->toArray(),
            self::STATUS);
        $listContract = $this->contractAction->getContractsViaStatus(Auth::user(), $status, $keyword, 'company');
        $statusApplication = $this->contractAction->statusActiveContractResponsive($request);

        return view('dashboard.contract.list', [
            'listContract' => $listContract,
            'statusContracts' => $statusContracts,
            'stt' => $request->page ? ($request->page - 1) * 15 + 1 : 1,
            'type' => 'company',
            'statusApplication' => $statusApplication
        ]);
    }


    public function create(Request $request)
    {
        $folderParent = $this->contractAction->create();
        $type = $request->type;

        return view('dashboard.contract.add', compact('folderParent', 'type'));
    }

    public function store(ValidateContractRequest $request)
    {
        $isUpdate = 0;
        $ownSignatureURL = '';
        $email = 'abcxyz@gmail.com';
        $value_banking = Banking::where('vn_name', $request->input('search'))->first();
        $id_banking = $value_banking ? $value_banking->id : null;
        $randomNumber = rand(0, 999);
        $styleNumber = str_pad($randomNumber, 3, '0', STR_PAD_LEFT);
        $customerCodeRandom = '01GTKT0-' . $styleNumber;
        $newContract = new Contract();
        $newContract->code = $customerCodeRandom;
        $newContract->sample_contract_id = $request->input('sample_contract');
        $newContract->created_contract = Carbon::now('Asia/Ho_Chi_Minh');
        $newContract->code_fax = $request->input('code_contract_stt');
        $newContract->name_customer = $request->input('name_manager');
        $newContract->email = $request->input('name_email');
        $newContract->name_cty = $request->input('name_cty');
        $newContract->address = $request->input('addres_cty');
        $newContract->name_account = $request->input('stk_contract');
        $newContract->type = $request->input('type');
        $newContract->banking_id = $id_banking;
        $newContract->payments = $request->input('payments');
        $newContract->status = "canceled";
        $newContract->user_id = Auth::id();
        $newContract->created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $newContract->save();

        $signatures = [];

        $listIdFile = $request->input('id_contract');
        $newContract->files()->attach($listIdFile);

        $fileDownload = [];
        $fileIdArray = [];
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $fileSize = $file->getSize();
                $fileSizeByKb = number_format($fileSize / 1024, 2);
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(base_path('storage/uploads'), $fileName);
                $newFile = File::create([
                    'name' => $fileName,
                    'path' => $fileName,
                    'type' => $file->getClientOriginalExtension(),
                    'created_at' => Carbon::now(),
                    'user_id' => Auth::id(),
                    'size' => $fileSizeByKb,
                    'upload_st' => 'upload_contract',
                    'contract_id' => $newContract->id
                ]);
                $url = storage_path('uploads/' . $fileName);
                $fileDownload[] = [
                    'fileContent' => base64_encode(file_get_contents($url)),
                    'fileName' => $file->getClientOriginalName(),
                    'fileId' => $newFile->id
                ];
                $fileIdArray[] = $newFile->id;
            }
        } else if ($request->name_contracts) {
            foreach ($request->name_contracts as $key => $nameContractItem) {
                if (strpos($nameContractItem, '.pdf')) {
                    $url = storage_path('uploads/' . $nameContractItem);
                    $fileSample = File::where('name', $nameContractItem)->first();
                    $fileDownload[] = [
                        'fileContent' => base64_encode(file_get_contents($url)),
                        'fileName' => $nameContractItem,
                        'fileId' => $fileSample->id
                    ];
                } else {
                    Session::flash('error_message', 'File tải lên phải là định dạng pdf !');

                    return redirect()->back()->withInput();
                }
            }
        } else {
            Session::flash('error_message', 'Bạn chưa lựa chọn file hợp đồng !');

            return redirect()->back()->withInput();
        }
        foreach ($request->input('business_name') as $key => $value) {
            ListRecipient::create([
                'name' => $value,
                'signing_sequence' => $request->input('status_signing')[$key],
                'phone' => $request->input('phone_contract')[$key],
                'email' => $request->input('email_contract')[$key],
                'contract_id' => $newContract->id
            ]);
            $checkUser = User::where('email', $request->input('email_contract')[$key])->first();
            if (!$checkUser) {
                $newUser = User::create([
                    'name' => $value,
                    'email' => $request->input('email_contract')[$key],
                    'password' => 'google'
                ]);
            }
            $newSignature = Signatures::create([
                'created_at' => Carbon::now(),
                'contract_id' => $newContract->id,
                'sign_sequence' => $request->input('status_signing')[$key],
                'email' => $request->input('email_contract')[$key],
                'name' => $value,
                'file_id' => $request->hasFile('files') ? $fileIdArray[0] : $listIdFile[0],
            ]);
            $ownSignatureURL = SignatureTemplate::where('user_id', '=', Auth::user()->id)->first();
            $signatures[] = $newSignature;
        }
        if ($request->email_contract_follow) {
            foreach ($request->business_name_follow as $key => $value) {
                $isCreate = FollowSignature::create([
                    'contract_id' => $newContract->id,
                    'business_name_follow' => $request->business_name_follow[$key],
                    'phone_follow' => $request->phone_contract_follow[$key],
                    'email_follow' => $request->email_contract_follow[$key],
                    'token' => Str::random(25)
                ]);
                if ($isCreate) {
                    $followNew = FollowSignature::where('contract_id', $newContract->id)->get();
                    $contentMail = [
                        'title' => 'Admin Onesign đã gửi cho bạn tài liệu theo dõi',
                        'body' => 'Đang có phần tài liệu cần theo dõi',
                        'id_contract' => $newContract->id,
                        'emailFollow' => $followNew[$key]['token']
                    ];
                    Mail::to($request->email_contract_follow[$key] ?? $email)->send(new SendMailToFollow($contentMail));
                }
            }
        }
        return view('dashboard.contract.signature')
            ->with('email', $email)
            ->with('contract_id', $newContract->id)
            ->with('file', $fileDownload)
            ->with('signatures', $signatures)
            ->with('ownSignature', $ownSignatureURL)
            ->with('isUpdate', $isUpdate);
    }

    public function getData(Request $request)
    {
        return response()->json($this->crawlCompanyInformation->run($request->get('tax_code')));
    }

    function contractFile(Request $request, $id)
    {
        $id_files = $request->input('id_files');
        $files = File::where('id', $id_files)->get();
        if (isset($id)) {
            $folders = $this->folder::find($id);
        } else {
            $id_folder = $request->input('id_folder');
            $folders = $this->folder::find($id_folder);
        }


        return view('dashboard.contract.contract_file', compact('folders', 'files'));
    }

    function searchAjax(Request $request)
    {
        $idFolder = $request->input('id_folder') ? $request->input('id_folder') : '';
        $folderParent = $this->contractAction->searchAjax($request);
        return view('dashboard.contract.folder_search', compact('folderParent', 'idFolder'));

    }

    public function searchBanking(Request $request)
    {
        $searchBanking = $this->contractAction->searchBanking($request->input('keywork'));

        return view('dashboard.contract.search_banking_ajax', compact('searchBanking'));
    }

    public function searchCustomer(Request $request)
    {
        if ($request->type == 'company') {
            $searchCustomer = Customer::where('name', 'like', '%' . $request->input('key') . '%')->where('customer_type', 'Doanh nghiệp')->get();
        } elseif ($request->type == 'personal') {
            $searchCustomer = Customer::where('name', 'like', '%' . $request->input('key') . '%')->where('customer_type', 'Cá nhân')->get();
        }
        return view('dashboard.contract.search_customer_ajax', compact('searchCustomer'));
    }

    public function getCustomer(Request $request)
    {
        if ($request->type == 'company') {
            $searchCustomer = Customer::where('customer_type', 'Doanh nghiệp')->get();
        } elseif ($request->type == 'personal') {
            $searchCustomer = Customer::where('customer_type', 'Cá nhân')->get();
        }
        return view('dashboard.contract.search_customer_ajax', compact('searchCustomer'));
    }

    public function getBanking(Request $request)
    {
        $searchBanking = Banking::paginate(5);

        return view('dashboard.contract.search_banking_ajax', compact('searchBanking'));
    }

    public function show(Request $request)
    {
        $value = $request->input('val');
        $fileIds = [];
        if ($request->fileIds) {
            $fileIds = $request->fileIds;
        }

        if (count($fileIds)) {
            $listContract = File::whereIn('id', $value)->whereNotIn('id', $fileIds)->get();
        } else {
            $listContract = File::whereIn('id', $value)->get();
        }

        return view('dashboard.contract.show_contract_ajax', compact('listContract'));
    }

    public function listReceivers(Request $request)
    {
        $listStatusReceiver = [1, 2, 3, 4, 5];
        $businessName = $request->input('business_name');
        $statusSigning = $request->input('status_signing');
        $phoneContract = $request->input('phone_contract');
        $emailContract = $request->input('email_contract');

        return view('dashboard.contract.receivers_ajax',
            compact('businessName', 'statusSigning', 'phoneContract', 'emailContract', 'listStatusReceiver'));
    }

    public function listUploadFiles(Request $request)
    {
        $names = $request->input('names');
        $size = $request->input('size');
        $type = $request->input('type');

        return view('dashboard.contract.list_upload_ajax', compact('names', 'size', 'type'));
    }

    public function contractDetail(Request $request)
    {
        $id = $request->input('id');
        $listFollow = FollowSignature::where('contract_id', $id)->get();
        $itemContract = Contract::with('banking', 'files', 'signatures')->find($id);
        $listFilesContract = File::where('contract_id', $id)->get();

        $listRecipients = ListRecipient::where('contract_id', $id)->get();

        return view('dashboard.contract.modal_detail_contract',
            compact('itemContract', 'listFilesContract', 'listRecipients', 'listFollow'));
    }

    public function contractEdit($slug)
    {
        $listFollowId = Contract::where('slug', $slug)->first()->followSignature;
        $listSample = SampleContract::all();
        $itemContract = Contract::where('slug', $slug)->first();
        $valueBanking = Contract::where('banking_id', $itemContract->banking_id)->first()->banking;
        $listFilesContract = File::where('contract_id', $itemContract->id)->get();
        $listRecipients = ListRecipient::where('contract_id', $itemContract->id)->get();
        $listStatusReceiver = [1, 2, 3, 4, 5];
        $folderParent = $this->contractAction->create();

        return view('dashboard.contract.edit',
            compact('listSample', 'itemContract', 'valueBanking', 'listFilesContract', 'listRecipients',
                'listStatusReceiver', 'folderParent', 'listFollowId'))->with('id', $itemContract->id);
    }

    public function contractUpdate(ValidateContractRequest $request, $id)
    {
        $contractFiles = Contract::where('id', $id)->first()->file;
        $fileDownload = [];
        $fileIdArray = [];
        $value_banking = Banking::where('vn_name', $request->input('search'))->first();
        $fileUpdate = Signatures::where('contract_id', $id)->first()->file;
        $id_banking = $value_banking->id ?? null;
        $signatures = Signatures::where('contract_id', $id)->get();
        $signatureName = Signatures::where('contract_id', $id)->get()->groupBy('email');
        $contract_value = Contract::where('id', $id)->update([
            'code' => $request->input('code_contract'),
            'sample_contract_id' => $request->input('sample_contract'),
            'created_contract' => $request->input('date_contract'),
            'code_fax' => $request->input('code_contract_stt'),
            'name_customer' => $request->input('name_manager'),
            'email' => $request->input('name_email'),
            'name_cty' => $request->input('name_cty'),
            'address' => $request->input('addres_cty'),
            'name_account' => $request->input('stk_contract'),
            'banking_id' => $id_banking,
            'payments' => $request->input('payments'),
        ]);

        if ($request->business_name) {
            foreach ($request->business_name as $key => $value) {
                $isIdRecipient = ListRecipient::where('contract_id', $id)->get()[$key];
                ListRecipient::where('id', $isIdRecipient->id)->update([
                    'name' => $request->business_name[$key],
                    //                    'signing_sequence' => $request->input('status_signing')[$key],
                    'phone' => $request->input('phone_contract')[$key],
                    'email' => $request->input('email_contract')[$key],
                    //                    'contract_id'      => $newContract->id
                ]);
                $idSign = Signatures::where('contract_id', $id)->where('token', '<>', null)->first();
                if ($idSign != null) {
                    $isIdSign = Signatures::where('contract_id', $id)->where('token', '<>', null)->get()[$key];
                    Signatures::where('id', $isIdSign->id)->update([
                        'name' => $request->business_name[$key],
                        'email' => $request->input('email_contract')[$key],
                    ]);
                }
            }
        }


        /** @var Contract $currentContract */
        $currentContract = Contract::where('id', $id)->first();
        if ($request->hasFile('files')) {
            $fileUpload = $request->file('files');
            foreach ($fileUpload as $item) {
                $fileSize = $item->getSize();
                $fileSizeByKb = number_format($fileSize / 1024, 2);
                $fileName = uniqid() . '_' . $item->getClientOriginalName();
                $item->move(base_path('storage/uploads'), $fileName);
                $newFile = File::create([
                    'name' => $fileName,
                    'path' => $fileName,
                    'type' => $item->getClientOriginalExtension(),
                    'created_at' => Carbon::now(),
                    'user_id' => Auth::id(),
                    'size' => $fileSizeByKb,
                    'upload_st' => 'upload_contract',
                    'contract_id' => $currentContract->id
                ]);
                $url = storage_path('uploads/' . $fileName);
                $fileDownload[] = [
                    'fileContent' => base64_encode(file_get_contents($url)),
                    'fileName' => $item->getClientOriginalName(),
                    'fileId' => $newFile->id
                ];
                $fileIdArray[] = $newFile->id;
            }
        }

        if (isset($request->files_exist) && count($request->files_exist)) {
            $fileExists = File::where('contract_id', $id)->whereIn('id', $request->files_exist)->get();
            foreach ($fileExists as $itemExist) {
                $nameCompact = substr($itemExist->name, strpos($itemExist->name, '_') + 1, strlen($itemExist->name));
                $url = storage_path('uploads/' . $itemExist->name);
                $fileDownload[] = [
                    'fileContent' => base64_encode(file_get_contents($url)),
                    'fileName' => $nameCompact,
                    'fileId' => $itemExist->id
                ];
                $fileIdArray[] = $itemExist->id;
            }
        }

        if ($request->name_contracts) {
            foreach ($request->name_contracts as $key => $nameContractItem) {
                if (strpos($nameContractItem, '.pdf')) {
                    $url = storage_path('uploads/' . $nameContractItem);
                    $fileSample = File::where('name', $nameContractItem)->first();
                    $fileDownload[] = [
                        'fileContent' => base64_encode(file_get_contents($url)),
                        'fileName' => $nameContractItem,
                        'fileId' => $fileSample->id,
                    ];
                } else {
                    Session::flash('error_message', 'File tải lên phải là định dạng pdf !');

                    return redirect()->back()->withInput();
                }
            }
        }

        if (!count($fileDownload)) {
            Session::flash('error_message', 'Bạn chưa tải lên file hợp đồng nào!');
            return redirect()->back()->withInput();
        }

        $fileRemoved = $currentContract->file()->whereNotIn('id', $fileIdArray)->get();
        foreach ($fileRemoved as $remove) {
            $remove->update(['contract_id' => null]);
        }

        if ($request->id_contract) {
            $currentContract->files()->sync($request->id_contract);
        } else {
            $currentContract->files()->sync([]);
        }
        $signatureName = Signatures::where('contract_id', $id)->get()->groupBy('email');
        $isUpdate = 1;
        $ownSignatureURL = SignatureTemplate::where('user_id', '=', Auth::user()->id)->first();
        if ($contract_value == true) {
            return view('dashboard.contract.signature')
                ->with('contract_id', $id)
                ->with('file', $fileDownload)
                ->with('signatures', $signatures)
                ->with('ownSignature', $ownSignatureURL)
                ->with('isUpdate', $isUpdate)
                ->with('signatureName', $signatureName);
        }
    }

    public function sendMail(Request $request)
    {
        $contractId = $request->contract_id;
        $contract = Contract::find($contractId);
        $contract->update(['status' => 'wait_approval']);
        if ($request->coordinates) {
            foreach ($request->coordinates as $key => $coorItem) {
                $signatureId = $key;
                if ($key != 'NaN') {
                    $signature = Signatures::find($signatureId);
                    $sampletoken = Signatures::where('contract_id', $contractId)->where('email', $signature->email)->where('token', '!=', null)->first();
                    if ($signature) {
                        generateToken:
                        $token = Str::random(40);
                        $isIssetToken = Signatures::where('token', $token)->count();
                        if ($isIssetToken == 0) {
                            foreach ($coorItem as $item) {
                                $newSignature = $signature->replicate();
                                if ($newSignature) {
                                    $newSignature->dataX = $item[0];
                                    $newSignature->dataY = $item[1];
                                    $newSignature->dataPage = $item[2];
                                    $newSignature->type = $item[3];
                                    $newSignature->file_id = $item[4];
                                    $newSignature->width = $item[5];
                                    $newSignature->height = $item[6];
                                    $newSignature->contract_id = $contractId;
                                    if ($request->isUpdate == 0) {
                                        $newSignature->token = $token;
                                    } else {
                                        if ($sampletoken) {
                                            $newSignature->token = $sampletoken->token;
                                        } else {
                                            $newSignature->token = $token;
                                        }
                                    }
                                    $newSignature->save();
                                }
                            }
                        } else {
                            goto generateToken;
                        }
                    } else {
                        Session::flash('error_message', 'Không thể tạo hợp đồng, vui lòng tạo lại hợp đồng mới');
                        return redirect()->back();
                    }
                }
            }
        }
        if ($request->oldSignature) {
            foreach ($request->oldSignature as $key => $oldItem) {
                if ($oldItem == 1) {
                    $oldSignature = Signatures::find($key);
                    $oldSignature->forceDelete();
                }
            }
        }

        if ($request->isUpdate == 1) {
            Session::flash('message', 'Sửa hợp đồng thành công!');
            return redirect($contract->type === 'personal' ? route('web.contracts.index') : route('web.contracts.indexCompany'));
        }
        if ($request->isUpdate == 2) {
            Session::flash('message', 'Kí hợp đồng thành công!');
            return redirect($contract->type === 'personal' ? route('web.contracts.index') : route('web.contracts.indexCompany'));
        }
        Session::flash('message', 'Tạo hợp đồng thành công!');
        return redirect($contract->type === 'personal' ? route('web.contracts.index') : route('web.contracts.indexCompany'));

    }

    public function publishContract(Request $request)
    {
        $data = [];
        $contractId = $request->contract_id;
        $contract = Contract::find($contractId);
        $signatureWithSequence = $contract->signatures->where('mailed_at', null)->where('token', '!=', null)->keyBy('sign_sequence')->pluck(['sign_sequence'])->sort()->values();
        // gui mail cho sequence dau tien
        if (count($signatureWithSequence) > 0) {
            $firstSequence = $signatureWithSequence[0];
            $signatureFirst = Signatures::where('contract_id', $contractId)->mailedAtNull()->where('sign_sequence', $firstSequence)->where('token', '!=', null)->get();
            foreach ($signatureFirst as $signatureFirstItem) {
                $signatureFirstItem->update(['mailed_at' => Carbon::now()]);
            }
            $clientEmail = $signatureFirst[0];
            $signature = Signatures::where('contract_id', $contractId)->where('token', '!=', null)->get();
            foreach ($signature as $sign) {
                $receive = User::where('email', $sign->email)->first();
                $sign->update(['client_id' => $receive->id]);
            }
            $data = [
                'emails' => $clientEmail->email,
                'token' => $clientEmail->token,
                'contract_id' => $contractId,
                'contract' => $contract,
                'user' => $contract->user
            ];
            Mail::to($clientEmail->email)->send(new SendMailToClientSign ($data));
            Session::flash('message', 'Gửi email thành công!');
            return redirect()->back();
        } else {
            Session::flash('error_message', 'Gửi email không thành thành công. Vui lòng kiểm tra lại!');
            return redirect()->back();
        }


    }

    public function clientSendMail(Request $request)
    {
        $signatureId = $request->signature_id;
        foreach ($signatureId as $sigItem) {
            $signature = Signatures::where('id', $sigItem)->where('signatured_at', null)->first();
            if ($signature) {
                $signature->signatured_at = Carbon::now();
                $signature->save();
                $fileNameBySignature = Signatures::find($sigItem)->file->name;
                // send email

                Session::flash('message', 'Ký hợp đồng thành công!');

                // kiem tra cac signature cung sequence da ky chua
                $contract = $signature->contract;
                $signatureSameSequence = $contract->signatures()->where('sign_sequence', $signature->sign_sequence)->isSignatureUsed();
                $countSignatureWithSequence = $signatureSameSequence->count();
                $countSignatureAt = $signatureSameSequence->where('signatured_at', '!=', null)->count();
                if ($countSignatureWithSequence == $countSignatureAt) {
                    // gui mail tiep cho sequence tiep theo
                    $signatureWithSequence = $contract->signatures->where('mailed_at', null)->where('dataX', '!=', null)->keyBy('sign_sequence')->pluck(['sign_sequence'])->sort()->values();
                    if (count($signatureWithSequence)) {
                        $signatureWithSequenceFirst = $signatureWithSequence[0];

                        $signatureArray = $contract->signatures()->where('sign_sequence', $signatureWithSequenceFirst)->isSignatureUsed()->mailedAtNull()->get();
                        foreach ($signatureArray as $signatureArrayItem) {
                            $signatureArrayItem->update(['mailed_at' => Carbon::now()]);
                        }
                        $clientSignature = $signatureArray[0];
                        $data = [
                            'emails' => $clientSignature->email,
                            'token' => $clientSignature->token,
                            'contract_id' => $contract->id,
                            'contract' => $contract,
                            'user' => $contract->user
                        ];
                        Mail::to($signatureArrayItem->email)->send(new SendMailToClientSign ($data));
                    } else {
                        // neu gui het sequence roi thi gui mail thong bao ket qua den tat ca cac mail trong contract
                        $mailOfContract = $contract->signatures->where('mailed_at', '!=', null)->where('dataX', '!=', null)->keyBy('email')->pluck(['email']);
                        $contract->update(['status' => 'success']);
                        Mail::to($mailOfContract)->send(new SignatureCompleted ([
                            'url' => route('web.files.pdfPreview', ['filename' => $fileNameBySignature])
                        ]));

                    }
                }

            } else {
                return response()->json(false, 202);
            }
        }
        return response()->json(true);
    }

    function clientSignature($token)
    {
        $signatureArea = Signatures::with('file')->where('token', $token)->where('signatured_at', null)->get();
        $contract = Signatures::where('token', $token)->first()->contract->id;
        $files = File::where('contract_id', $contract)->get();
        $fileContracts = File_contract::where('contract_id', $contract)->get();
        if (count($signatureArea)) {
            $ownSignatureURL = '';
            $email = $signatureArea[0]->email;
            $client = User::where('email', $email)->first();
            if ($client) {
                $ownSignatureURL = SignatureTemplate::where('user_id', '=', $client->id)->where('deleted_at', '=', null)->first();
            }
            $fileDownload = [];
            if (count($files)) {
                foreach ($files as $key => $file) {
                    $fileName = substr($file->name, strpos($file->name, '_') + 1, strlen($file->name));
                    $url = storage_path('uploads/' . $file->name);
                    $fileDownload[] = [
                        'fileContent' => base64_encode(file_get_contents($url)),
                        'fileName' => $fileName,
                        'fileId' => $file->id
                    ];
                }
            } elseif (count($fileContracts)) {
                foreach ($fileContracts as $key => $fileContract) {
                    $files = File::find($fileContract->file_id);
                    $fileName = substr($files->name, strpos($files->name, '_') + 1, strlen($files->name));
                    $url = storage_path('uploads/' . $files->name);
                    $fileDownload[] = [
                        'fileContent' => base64_encode(file_get_contents($url)),
                        'fileName' => $fileName,
                        'fileId' => $files->id
                    ];
                }
            }
            return view('dashboard.contract.clientSignature')
                ->with('area', $signatureArea)
                ->with('file', $fileDownload)
                ->with('sampleSignature', $ownSignatureURL)
                ->with('contractId', $contract)
                ->with('email', $email);
        } else {
            abort(404);
        }

    }

    public function clientSignatureFollow($token)
    {
        $followSig = FollowSignature::where('token', $token)->first();
        $idContract = $followSig->contract_id;
        $files = Contract::find($idContract)->file;
        $contract = Contract::find($idContract);
        foreach ($files as $file) {
            $url = storage_path('uploads/' . $file->name);
            $fileDownload[] = [
                'fileContent' => base64_encode(file_get_contents($url)),
                'fileName' => $file->name,
                'fileId' => $file->id
            ];
        }
        return view('dashboard.contract.signtureFollow')
            ->with('file', $fileDownload)
            ->with('token', $token)
            ->with('followSig', $followSig)
            ->with('contract', $contract);


    }

    public function clientActiveFollow($token)
    {
        $isActive = FollowSignature::where('token', $token)->update([
            'active_screen' => 1
        ]);
        if ($isActive) {
            return redirect()->back();
        }
    }

    public function storeFileSignature(Request $request)
    {

        $data = $request->data;
        $fileId = $request->fileId;
        $fileNameBySignature = File::find($fileId)->name;
        $data->move(base_path('storage/uploads'), $fileNameBySignature);
        return response()->json(true);
    }

    public function resendEmail(Request $request): JsonResponse
    {

        return $this->signatureAction->resendEmail($request);

    }

    public function fastSignature($id)
    {
        $files = File::where('contract_id', $id)->get();
        $signatures = Signatures::where('contract_id', $id)->get();
        $signatureName = Signatures::where('contract_id', $id)->get()->groupBy('email');
        $fileContracts = File_contract::where('contract_id', $id)->get();
        if (count($files)) {
            foreach ($files as $file) {
                $url = storage_path('uploads/' . $file->name);
                $fileDownload[] = [
                    'fileContent' => base64_encode(file_get_contents($url)),
                    'fileName' => $file->name,
                    'fileId' => $file->id
                ];
            }
        } elseif (count($fileContracts)) {
            foreach ($fileContracts as $key => $fileContract) {
                $files = File::find($fileContract->file_id);
                $fileName = substr($files->name, strpos($files->name, '_') + 1, strlen($files->name));
                $url = storage_path('uploads/' . $files->name);
                $fileDownload[] = [
                    'fileContent' => base64_encode(file_get_contents($url)),
                    'fileName' => $fileName,
                    'fileId' => $files->id
                ];
            }
        }
        $isUpdate = 2;
        $ownSignatureURL = SignatureTemplate::where('user_id', '=', Auth::user()->id)->first();
        return view('dashboard.contract.signature')
            ->with('contract_id', $id)
            ->with('file', $fileDownload)
            ->with('signatures', $signatures)
            ->with('ownSignature', $ownSignatureURL)
            ->with('isUpdate', $isUpdate)
            ->with('signatureName', $signatureName);

    }

    public function getRemoteAccessToken(Request $request)
    {

    }

    public function remoteSignature(Request $request)
    {
        foreach ($request->Signature as $sign) {

            $clientSignature = Signatures::find($sign);
            $page = $clientSignature->dataPage;
            $left = (int)($clientSignature->dataX * $request->width / 100);
            $bot = (int)((100 - $clientSignature->dataY) * $request->height / 100 - $clientSignature->height * $request->height / 100);
            $width = (int)($left + $clientSignature->width * $request->width / 100);
            $height = (int)($bot + $clientSignature->height * $request->height / 100);
            $signature[] = [
                'page' => $page,
                'rectangle' => "$left,$bot,$width,$height"
            ];
            $comment[] = [
                "fontColor" => "black",
                "fontName" => "Time", // 3 option : Time/Roboto/Arial
                "fontSize" => 13,
                "fontStyle" => 0, //0:Normal,1:Bold,2:Italic,3:Bold&Italic,4:Underline
                "page" => $page,
                'rectangle' => "$left,$bot,$width,$height",
                "text" => "",
                "type" => 2 // type commnet bằng text
            ];
        }
        $isComplete = 0;
        $contract = Signatures::find($request->Signature[0])->contract;
        $signatureSameSequence = Signatures::where('contract_id', $contract->id)->where('token', '!=', null)->get();
        $signatureNotSigned = Signatures::where('contract_id', $contract->id)->where('token', '!=', null)->where('signatured_at', '=', null)->count();
        if ($signatureNotSigned == 0) {
            $isComplete = 1;
        }
        $file = File::find($request->fileIdBase64);
        $fileUrl = storage_path('uploads/' . $file->name);
        $fileName = substr($file->name, strpos($file->name, '_') + 1, strlen($file->name));
        $unsignDataBase64 = base64_encode(file_get_contents($fileUrl));
        $clientId = config('vnpt_connect.client_id');
        $clientSecret = config('vnpt_connect.client_secret');
        $authorizeUrl = config('vnpt_connect.authorize_url');
        $tokenUrl = config('vnpt_connect.token_url');
        $credentialUrl = config('vnpt_connect.credential_url');
        $certBase64Url = config('vnpt_connect.certBase64_url');
        $signUrl = config('vnpt_connect.sign_url');
        $fileDataUrl = config('vnpt_connect.file_data_url');
        if ($request->email && $request->password) {
            $tokenApi = Http::asForm()->post($tokenUrl, [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'username' => $request->email,
                'password' => $request->password,
                'grant_type' => 'password',
            ]);
        }
        if ($tokenApi->getStatusCode() != 200) {
            return response()->json(['message' => "Sai thông tin đăng nhập.Đăng nhập sai quá 5 lần sẽ bị khóa tài khoản."]);
        } else {
            $token = json_decode($tokenApi)->access_token;
        }
        $credentialApi = Http::withToken($token)->post($credentialUrl, [
            'header' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]
        ]);
        if (!json_decode($credentialApi)->content[0]) {
            return response()->json(['message' => "Tài khoản chưa khởi tạo chứng chỉ"]);
        }
        $credential = json_decode($credentialApi)->content[0];
        $credentialApi = Http::withToken($token)->post($certBase64Url, [
            'header' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'credentialId' => $credential,
            'certificates' => 'chain',
            'certInfo' => true,
            'authInfo' => true
        ]);
        $certBase64 = str_replace("\r\n", "", json_decode($credentialApi)->cert->certificates[0]);


        $options = [
            "fontColor" => "000000",
            "fontName" => "Roboto", // 3 option : Time/Roboto/Arial
            "fontSize" => 10,
            "fontStyle" => 0, //0:Normal,1:Bold,2:Italic,3:Bold&Italic,4:Underline
            "imageSrc" => "iVBORw0KGgoAAAANSUhEUgAAASoAAAB2CAYAAAB/Ad4XAAAAAXNSR0IArs4c6QAAIABJREFUeF7tnQdYVMcWx/93C11Ail2j0WiiMdaIWIK9946JFVGi2FHBXhIbYq+gRkVFBGMv2KIm+jTlmZinKQoxdqyIYoHde983s7vUXVhkwV05k+8LKnfnnpl7z2/POXPmjABqfAZEUZQEQaDZoBkwqxkQ6KXkz4M0U/taSpIkmdUbSsLQDDAFJVARqNJrAoGKuGCOM0Cg0jwVsqjIojJH/SSZtDNAoCJQZVAGsqiIDeY4AwQqAhWByhw1k2TKMAMEKgIVgYqgYPYzQKAiUBGozF5NSUACFYGKQEUcMPsZIFARqAhUZq+mJCCBikBFoCIOmP0MEKgIVAQqs1dTEpBARaAiUBEHzH4GCFQEKgKV2aspCUigIlARqIgDZj8DBCoCFYHK7NWUBCRQEagIVMQBs58BAhWBikBl9mpKAhKoCFQEKuKA2c8AgYpARaAyezUlAQlUBCoCFXHA7GeAQEWgIlCZvZqSgAQqAhWBijhg9jNAoCJQEajMXk1JQAIVgYpARRww+xkgUBGoCFRmr6YkIIGKQEWgIg6Y/QwQqAhUBCqzV1MSkEBFoCJQEQfMfgYIVAQqApXZq2n2AkqSlOECQXj3Dv4mUBGoCFTvAKgYnBiw2E9RAmTvGKsIVAQqApUFg4rZUtLLlxB/+gXSqdNQV6kE6x49AJmMQ+tdaQQqAhWByoK0WePlaS0nUY3kfYchmzUbin//hdi/H+QhC945SLERE6gIVAQqSwKVKEF1+TKkQzGQfbsb0p9/QWZlBfXAgVBMD4LgYM9H8y5ZUwSqtBf03bGR86h0UubIbB77o4+bYgYkMEtKffMm1BOmQH7qFJCcDPbSygCoxo2BYnIg/4sgsGsFApUppt0M+yBQaR8Kgcp83k72nSGpVFCf+QFSdDSE/Ucge54ECMz/EyDZWEH0Hw7F+DGQ2Vjzf3tXG7l+5PqZv+un0ctC1UQAKZcuQfIfC8Uff0GmUkOCqJ0GAaIMEGfMgNJ/GDOj+NywaZK9QwH09A+cQEWgMmtQPU5IwLHTp9CrU+dcuzPJKSk49+OPaNKwYZ4h9+LlSyxeuQqJzKIx0ES1CmOGf4kypUq94f0kiCo11N9/D2nrdsgOxgCvX3P3TtMkQJBBtHeAesI4KL/0hUypfMN7Zf1Y0ssX2HPgIPr26JHtXCe9eIG9hw7j199/hyhKsLWxxmcNG6CFl1eun5GxwhOoCFRmCypRFDFv6RKE74hGzK6deK9sWWPfa37dyvUbsGn7dvx04jj/e14CzE8SnqJR23a4dz/eoAwpySqcObQfNT7+OFf34i6eAKjibkAaOQbyX36B8OoVj0BJgpQOVIAkE6BesgjKL/pySyovY8o8kMPHj8Nn5Gjs3bYVn9auZXCcsxYsxO27d9G2ZQso5ApYKZVYuWEj2jZviuE+Prl6RsZeTKAiUJktqG7cuoVOfb/AnXt3MHrYMEwZP97Y9xp//PUXmnTqApUqBT4D+mH+1GmQydJsE6M70rpUTzmo2uLeg/uGQZWSgjMHD3JQGd0kCeorf0K1NQLyrdsgPHsGiQEotQPdn0SILi7ArOlQePdOTUHQJXkafT8DF75OTuZz/cuvF9HcywvfrFwBO1vbLFefOnsWm7ZF4P0K5WFtZYVPqlXFf3/9DRXeK4e9R2Lw9ZQpqPR+hbyKk+XzBCoClVmCiing2MlTsG3nTm5tWFtZ4/zxoyhbqnRqBrYhbWCW2NgpU7FtZzQP36gh4kjkTtSrU/uNFShBZ1E9yMaiSlHhzMEDBkGlW1DVWUFqVQpUK9ZAvnwVhCdPAUENPlhu/mUUVVRaQ1q/DsqObTWW1BuPRP8HQ9aswdxFIXy+FAoFor7ZhMae9bNcPHTUKPTt2Rs/XbyIah9VQeP69XHkxHeQRDVkcjlsrG3QoU0rE0tHeVS6CTX1czf5gyqoDs1l1Y99c/foP4gvt4sswRECGnrUQ0RYGGxtbbN1eS7/8Sfa9+mD50nPUzW+S7v2CF26+I2tKg2o2uPeg3vZWFTZg4p9UGL/qdVQnz4LaUEwZOcvQJDJwfMPeNP85FtitP+iLlECWPA1FB3bpwLKlC7f37GxaNe7DxISElLHxiykmOhouBQtmmG8fX18MM7fH6fOnsPVuFjY2tjizp27CF22BOd//gXPk5LQvWMHk7qk2vkgHS18a0qGsWcOoEpKSkJf36E8EK5RVs2yn1KpxPplS9G+leFv7JSUFDRs2w5x1/9JG6Qkg1wu4FDUTtSpUeONmG8yUL1+DdX0ORC2bIbw6jUHMMt7Atg6H/upxRNXSwGijQ2kiHAovRrniyXF7jL167lYt+kbbqnqzDn25zFf+mHKuHEZ4L549RokJ6fw1cW6tWvCq0EDLFq5Ek0bNcLBY8fRrkULbrmaEqQEqrRXlmit+z43g4TP/YdjMGz8WK4Q6a0M9ue6NWth7/btsLZKW+3SxWnYz/DInRgzebJWudIUj322dIkSOLl/H7cScvvATQEq6dUrpAQEQrY9EoKozhaY3KJiK3yrlkLh3YsDLT/aH3//jdbdu4OtamYAJYAypUpjz9ZwlC9XLvXWTxMT4TcuAKVLlsAXvXuhRrVquBb3DwJnz4GDnS1WBi9EEQcHk4tKMSrdV4jJp9YyO3zbFtXTxGeo26wZniQ80bg/2r1t6b9TpgYEYIzfsCwT/DL5NVp37YYrf/2V7nc6K0VTXWDahACM9vPLtdqbAlQp0d9C5vullr0ZS7Poe1uk9ytC8fNZHjjPj/by1Wu07tEdV/78M9WSSrXo+L8IPFVh+fx5qbdnc/jPv/9izOQpSHqehA8/qIRLV66gds2amB0UCCdHxxxjiG8yFgIVgSrDe/M2QaVWqzFr4UKsWr9Rm8OYWZk1VoWTYxEcjo5G5fff1zqFmhBPyMpVPJ3BUM4jS+guV+49HPt2F1yKOudKX0wBKlXYRggTJkIQ5OncPf1i8HItZcpA9vN/IFhbaZ1CTazOVC167z6MDJyElBRVmsuZoXOBT+yu8HB4NfDM8Bv2rC5dvoKHjx6iXJky+KBixTeO/xkzHgIVgcosQMW+qf+9eRPte/dBvIEUgLS4hwC/QQMxOygoNRby2//+hxZdukOCWmuJGbJYBPTo3AlrQ0KM0Y/Ua0wBKvWTJxAbNYfs9q0sblZGPvAcc74AqB48CMq5cyAoFdwzyyuodJ49+9mkQ0dc+ftv7a31zZcGig09PLAtdB3s7exMHnsy9iEQqAhUZgEqllLgHxiInbu+1W4JMQwaJrCdrR2OfRuNKh98ABZA958UiF379mb73jOLiuUoMWtg/44INPLwMFZPkFdQaTxYCeK1q1AHTYfs1BkIKgbVdAt+XBpdMF0LKxZmb/IZBP/hkHt6QGZnZ7TMhi4UJQmLVqzE/KVLIcu2wp4GVFZWSoQuWYIOrVvn+d5v2gGBikBlFqCKOXECX/j5pVt5yv6VZq5etQ8/5G7c37FxaNOjJ14ns2zu7JvOKmvTtBm+Wb2K5wwZ0/IKqrR7SBCfJ0H13SlgQhDk8Q80bh1f2BTTQkSpoTWNDSXa2kFdszqEubOhqFEztYJnbhM+2fWX//oTHXp7a9M3jBk9UMy9GC4cPYoiRUwfKDdGAgIVgeqtg4qtJPUaPJhnOKelI+QAHEmAXCHHvOnTELolHFdjY7UfyClIzbadAHKZnOdkNf2ssTF6kmeLSncT7nppEzZVd+9BXLQEwr79kD14aNgdZAJrSw0zkoldOkPwHQJ5rU8AG5tcbURm9w+YNg1bdkTynC5jGxN7+BAfzJg4EQq53NiPmew6AhWB6q2Date+/Rg+YQJENasQYKzyaEwOe3t7JCW9SM21yrhqpV9PdKuJzo6OuHD8OFxdMiY16vuUqSyqzBYQK+OiunoV4oyvoDjK9iRmPaiBzYnAYlYas4vnXIkO9hAbN4Q8JBiKUiW5yNkVmdDd9/Kff6FF125QpSTnYq41M1LMzR0HInegQrlyBR6rIlARqN4aqJjy3H/4EE06dMCDR49M9u1rXEca0AX4+2Pi6NE5WiWmApUh2aSUZCRHREK2eh1kV2MBkZV0YZuVZRBElpuvv4nW1hADJ0A5qD9kztmvZCY+e4b2vXvjj7+vGljlMySdtoyMKMK7R3csmzcP8gK2qghUBKq3Biq1KCJg+gyE74gwgi3psraNuDrnSzT9lShWHGcOHYRLDkqe36DiFpEkQox/ANXW7RAWLoY8JTnNndWTqcGsLGZgiTIZxEoVIdsYCvlHH+q1dtiXwraoaIybOhVs4cIYy1M3hzx7XmuzCYIM4WvXoE3z5jlPsQmvIFARqN4aqNievO4DBuLhY2ZN6cuZ0hxi4FjECQmJT1PVxbj3X5PgaWdnh5cvmWuovzFvqmeXLli5YAEUCsOxl4IAlU5C5uqJsf9APWI05Od/zAEqmpgbG6u6ygeQ7d0NRYliWQbLMs/bdO+JK3/rkjvTX6JNehAAF2dX/jw0uWjpM/u1exAhoFaNTxD1zTdwLFKkwFxAAhWB6q2AiinWgOEjcOjYMb2KqNkDJ6HWJ5/A33coho4ZDXUO204yaqeAok5O8Pf1xezgYINJoJrPyLA9bB1aNW1qEGgFCSqdEKqr14BPGxid4slTLzq1h9UmXcJs2nCC5sxB2KbNBiulsvkuW6YMls2biz6DffE65bX+5yIBcoWSb5Xp0amjcd8ZJriKQEWgeiugOnDkKPoP94OMVQ7QG4ERYKW0wrolIWjauDE+HzoMZy9c0FybXdRYOxqFQsmTFOvXqYumnTtn3KScSXGYkrIKldtCQ2FjzWqPZ21vBVTx8RCr1oJczTLHs2nc/NFMijhiGBRzZmWwdC5e+h1te/aEKpt+mGU5gcfrRmH63HlYt2kzL32cpfGDI1i6ghtOHTgAd1dXE2Ao5y4IVASqAgUVs5IeP3mC7oMG4fLlK9msPAmoXaMGdodv4RnRR06chPcQX8jlstTtJPpeb108pV3Llti8ehVX2L+vxaFpp454ncysBP2NBYfDli1Hpzat9e5VKzhQaVwsMUUF1dQZkK1bn7NFxdMXALFGDcgO7IZgZ5e6OMDme8SEidi5Z082LqSAUsWL4/tDh+Dk5MhTPdr39sbjhMfpCotkdM0Z2Ab26YOFs2cVSGCdQEWgKjBQ6bZvbN0ZhYCp0yBKutWsrGtaNta2OBwViepVq2oUl7mKfn44fOJkOnn1r4Ux6ERu3MhLkOiOOvefNAmR336rx0JgZcg1m5+dHB1w9kgMShTLGuMpOFAB6mfPoArbAPm8hTx7XWNwZgKFbjsNjyXJoP6wCmShqyCvppkv3bFZ/710Ce179YFaVOnZ4K2ZDqXSClvXrkUzr8945imbswXLliF4xYpst/q4ubgiatMmVK/6Uc4mUR6vIFARqAoMVOxG9+Lvo1H79khIeGLg1dUshX/pMxhzgoIyXMN27bNv+vsPHxi0DhhwOndoj9CQkNSscwbI369cQdNOnQwEfzWuE/vsiCFDMHPSxCwbbAsKVOrERKhHj4ew7yBkalWWfYuazHptugCXWQ31EB8oJgZA5u6Wej0DVULicz7mmzdvpSaZZs1TE9D8s8+49WljY8Pnm83Xq9ev+b7LS5cvZ2uJdWjdCptWrcojhnL+OIGKQFVgoGJ78kYFBSFqD9uTp98aYq6bu7sb9oRvReVKFTPIplaLmDaXFXnbzC0Gfc3d1Q3njx3jFRbSN6Z8MxYswOr1G7J1HdlWkUORkShfLuNBEvkNKpbsKv7GjscaA9mVP/RvrGZWlCSDyMbOqit89BGEoAmQt2ujt3JB2JYtmDznK572oK+xuWbgi960icfoMrf9MTEYNmYsklPTJDJfodk3ydIVWDFDUxfLS383AhWBqsBAxY5X6j5gAFjNKUOgUosSpo4bi7HDh/MXP/PLf+fePdRv2Qov9KQcsGsnjhyFCaNG6lXMl69eoVW37mDF4gzmEUkCWjb14oH19IdB5CeoWGni5DWhkC1fAdl9bWqAxHKX0gCjKU2s2aisKlkKssDxENq0hNzdXXMYBN+ak1ZdITk5GQ3atsX1f28Ytj5FoH+fPgj5arZe0D1/8QI9BwzCTxd/ycb6lVD9o6qI2rwJrqwgYT6dK0igIlAVCKhUKhUGjvAHO5LJ4LssAR9VqYLv9u3NdrPw1sidmsRFbimkJYI6Oznj1P592Z6rt2l7BAKmT9eOWX9pE7VKha2hoWjXqmVqINu0oNKs0DErT/znOlQzZkO+7wBfAc3immnLA0syGaSyZSB2ag/5mFGQu7gYTOxkZ+0xSypsy+ZsqiMIKFWiBE7s2QN3N1eDxe5YUby2PXqCnZGocY+zzhmTe/HXX+GLnj1z9uHe8AoCFYEq30HFXu7I3XswctJEjUJoNodkeWXZSTNrQhahU9u22b7O7ACBHgMG4udfL3KF57vfJAmhS5ege8fsc3sSnyWiRdfuiLt+PdvYi2fduojYsB4O9vZcFlOBisnJI0wqFVK2bAOWr4D8hqY+lc4q0mVf6AoqpFSvBvgNhcKrEWRlS2sD3oarfp778Sd069cPKrVaj5ublsowbsQITBo1iq+kZtemfPU1d7c1VmjW58aegIuLKz+Bp7i72xuiKPuPEagIVPkOqvsPHqJjX2/E/XPdcHUEidVDr4mo8M1wsM25QFvk7t0YMWFCquyNPD2xJzw89Rs/OxeEBYjb9uwFdpadpqVXPp0iy7BucQi6a5Ma2QGkjY04heb0wQOomc25fpIoQnXjBsR5wVBE7Qa4VcjKu7C0C+a+sf19AkRnJ0hVqgLDBkPRrjUEpVVaQFwSwbay6GtsJENGjcL+Q4e1jqOeTc6iBDcXF5w7GpPllJn0feqsJ3ZKTdd+/cCeY9b50p6YIwF9unTBkvnzoDSydE5uiEagIlDlO6i2RUVh7uKlEEVWHUF/kwkybF8fhhrVqhoV53j9+jW8fXxx+vw5KOUKvvLUpoVx+8+YAgbNnp0p1SGrXCwgv2vzZp7UyDb0+owahYePDK1WAqIqBaHLl6NKpkUATWkXCVKKGimhGyBbGwYZX4njS2ypsSW2B0+qUB7SoAGQsWJ5lT+AXM8hoNkp+F+xsRg+bjySU1g6gp7Z1qRcYfbkIH5yjDGNybUyLAyRe/bpzenS5ZuyeulL589FxQrl81yJNLNcBCoCVb6CKr2y6LVytPWZdNfp8p6MCcqy0sVNOnXCxx9Vxe4tm40qgmdMobn0ie+aFCZNblFOzVDCPC9fc+UPqIOmQfjhHC96xzcUszwypQIiy+6u9iGkYb6Qt2iuiStxfmlcZGPunVk2vZDSXZTLA0wzPxtD85BeTmPmOaf5TP97AhWBKl9Bpevc1C8u65ctjX8dEoJBn3+OsqVLG/Xe50aO3Fyr1w2TJEgJT5ESHAJ59G7IHjzghzqwo7JEZ0eIbdpA1rEthGpVIXvvPVbNL60SsRFgNGrAei7K67iyu29+9U2gIlDlO6hYBU/mqpm66RK281GncyUyMw7Z6Ta8vDE7aPQ/5yGNnQgZC9zb2QJOzhCrfgj06gGhYwfI7Wyg2RCUsSU8fQqWXmCJjbl/1gb2S+ZlPAQqAlW+gypw9mwcO/mdxoUxFKTK5VusWzXU9ampgpmze5bL2xh5uUYaltbA4myVnidBClkC/H4FsmpVITX0hKxGdQgVK0IoVZLnLOmzPHi6gigiaNZsnPz+e5PNlZGDyPNlbCvSivkL4PFpnTdyV7MTgEBFoMp3UF2N+wePH7MVI9MfpJkGqPSL+mxIpoSWjq5pS/v6SjiIkponP9rcuAnB3h6y0qUgKBTarXqaWFNOrhH7/bW4ODx+kpBLcOiTMZddaDKlNHUYdEmkuZlHQeAHkjKrytSNQEWgyndQmfqlTd9fquJrg/LsdznBIC/yGAqYZ9sni1VplT8v9zb2s3kZf/rAubH3K4jrCFQEKosGFRP+3v37vKRxUSdHzJ85A/a2eT/7LgMMAZw8fQYLly1Ff29v9OnWzajSJgxOrIrpxJkzeGKlV8OG+aLTLAY4bPx4uDg6YsGs2SjioElSfZPGQLUpIgL7Dh/mKR/5YR29iVwEKgJVvoOKlcFlAeL0pW1ZwiLLU2KHOpQsVgx379/ndadYIqJKpcbd+Hh+OoytjU1qvIMpEdsnyPpiNoq7iwvsHexx9OR3uHX7Lu7G30PXDu05qJydnVKV7FnSc55ZzlYGMy/1P3z8WJP4qUln4v9j2ehJL5NgY2WDos7OfHWRlaZhQeKrcbEY3LcvXIq68CoOjo6OvJIo64NVhihezA021poqBGwTdvTevajyQWXU+qQ67/vR4ydgmfV887WbK548fQp7O1s4OzrxGNfNO3d5UTq7TPlTbOxs3C9evWIpWTwvi3XIsspv3b7DY1ps/mrVrAHPOnV5rOvGrdtwdnLkfbP5unnnDoq7ucPa2orLx/qMf/CQV07VdsfngR1DdujoMZQrXZqXfrlx6xafE1cXF/6Z23fv8nlhsTZ2OAe7js3ro4QEqFQp/B6mbgQqAlW+goq92HsOHMLIyYFQpajw+lUyihSxh52dPZZ+PQdDx47FkehdaNm1C94rUxaHo6P48Vctu3RB8Nyv0K55Cy7f8+dJCJg2HQePH4MgCVBLIhbOmonPe3THw0ePUL9lSzg6OOBcTAx8xo5DYsJT7N66BcnJKfDq2BFVPqiE8DVrsoCq56DBuPDzT0hKegm5Us6rio709cWJM2fQtEFDjBs5AotXr8LaDZt4prcoqjBswCA0qv8pevkMQcN6HnyrzbXYOLTv1QsR69ejYX0Pfh8Wm/No0RwHIyNQ6f1KGB4wHv/58Rde+UGpVGLj8uWYNm8eOrRqzStr3rx9BzUaNeL9ZT48gcFyTFAQ9h4+DLa5mv2dHRX2XunSOBC5E5Xr1EX58uVw7kgMh9eLFy9Q9uPqKF+2HM7GxMDGxgqV69RBeFgY6tepw+dUrVKjUbt2uH3nLhJfPIdCpoCtrS06tm6Fi7/+hooVKyBs+TKU+7g63Iq64qeTx+Hg4IBajRpjxpQgODkUgfdgH/z7v985xKfNm4+4a7HYtiHM1Jxi82nKoKPJ5SuoDmkStDMtZZsp+GaPI/H5M8Tff4Djp05h/tJlOL7nW7BMdKbIIwICcDByB9r07AV3F1eM8x+BJo0a8o2wC2bNROtmzfi3ePCKlVi+LhSrghegBt+iIsHVxRVFHBwwb8lSXqb4/M8/I3LjetStWQudP/8cbZu34ECcuyQE3+3bzzPGM7/vt+7cxctXLzFk1GjU/7QuhnzRD0WLOqPfl8PRxNMTtWvWQD+/LzF36lQ0buDJIeDk6MTrNH0xzI9v7GWHoLKfHb29Eb5mLRp41OMTFXv9Ohq0aoO927fi+KnTvMom24/ICvMxOdzd3NCudx90aNECAaNG4sbt26jTtCkvYsfGndn9ZBbb02eJ+Cp4Ea8AsWPDer5d5YcLFzBj7nyUKF6MH/3VuW1rvHjxEh96eMLBzgbj/EfCp98XqFa/AT8d2qN2rdQA//WbN3nqSO/BPqherSqmB0yAvb0dvH2GoEKFClgXsgiV63lwC8+7WzdMDRgPz1atMTUggFvErER07H9/4VbazIXBiIuNw5Z1a9/sRcnmUwQqsqjy1aJK3/nuAwcxduoU/HPxIlfUmOMnMXxCAD/UslW3Hlg6dy4WrVyOiPUb0fWLz3m8iSksc6EGjhiJq7HXcC7mCI8P6YDDFLe6Z0MsX7AA67eEo/IHlRAyZzb2HjoEnzFjYG9jg9WLFqFDa02JYVbFgXt4MlmGE39bde+B5l5emKQtEdOud294eTaEja0N5gQHY/LYMbCysk49cILJ1MfHB19Pm4Zvtm7D6pBgdBswAOGr12QCVVsOqkkzZ6JenToInjUzw3w36dwFrs7OaOxZH4mJz7B64wZsXr0GrZs15bLqvjdYbhYbMztizH/CRLCSOf85egSsRtfnQ/1Qv25dDtzwyEhcPH2Kf7Zag4ZYv3QpZi9ahEM7I1G/ZWtsWLmCgyp9Y652/VYt4VGrNlYEL+S/atqhIyqUL4+1ixfjQ4/6mD99OuYuXYzd4eHo5zsUgePGcte6zxBfjPcfzrcxHTt9Bq5OTti8dg2ByuQzQKB666A6uDMSLbt2x9Fd0fxgATc3N+6OzZsxnYOKuW/9vxyB23du8TP40ltF32yPQODMmRg6cADuxcfj9Lnz+O+pk7C2suJWGovRsP16TOH/d+UKvgoOgaCQoXWz5hjo3UeTeyUAmUHVtndv7voxQHy9eAn8Bg6AQqngc+X5aT1uQXgP8sGpgwfgNz4A1apUxrFT32HTqtV6QBWOsVOmoIVXE8yZnLFqadPOXWBnY4O6tWqBxdIioqKxafUqXkb5q5DFPFWBHfm1ccVyTVkYSUoDVUwMjx81bt8eQ/sPwJ34u4jY9S22h4Vx8FWt74k/L5yH37gAfFK9GsIjIrFu2dJcg6pKPQ9eFnrzjh0Q1SIu/PwztwDZcVl9fXzh078fj1f958cfebyRQJVPlDJx0k3+SVkAPeeH66cTO7NFdfj4SfhrLaqWXXvg+0MHcPfBfXTu480/sjV0XarrN3HmLOw9eAgxu6JQ3F0TrGXhZHbkFnOxXJxYwBiIu/4vxgwbhjHD/eDt68tdlg3Ll/Prb8ffw4lTpyGDjFten9aqmQo9ZtFxi2q0pugeA1UTzwaoXKkSfMaMxv6t21Cj+sf8eoVSibPnz3P36OKZM7gWF4teg32RkvIa+yK2o2G9NNfPs3Vb7NsWzg//vH7zBratW6exCCFw2DXv2i3V9bt5+zZqNWnCr2En77CVxoePHkNppUTvrl24XMyiGjFxIn679DvOxhzBqEmBOH76DEqWKM6z3Nk92jRvgQUzpuEjBqofL+CXX3+F95ChUKtV2Lc9AvXq6Leo6tWujZULF/J90s3+mB3gAAAE2ElEQVQ6dkL5CuWxLiQEVT6th0M7d/JzD7v26883aK9etJAvJPTzHYZrF5nrZ40ZCxcg7to/CA8l1y+/VJViVNqZzU9Q7dq/H2MnT8G/l37jCn/4+An4jR+PmKidaNapC84cPIj3K7yHyXPmYNX6DYja9E1qUJltQA6YMQM3btyAo4MjWHG4Lh3aYdnatdyqKV2yJFgJFXaGH7Oyfjp+DCMDg2Bva4uNK9khBdm3Fl26oUVTLwSOHs0vbNOzJ3f9hg0aiNkLF+C7H87CtSgrVqc5sJSVSe41cCAufv89ypQsiZGTArE5YjuOREejoYcHt34YND1atsSBHRFgByGMCgwEKxfDVucUcjnmTAnC+GnT0aFVK0xgwfRbt1HL6zNsDw1FawMnEbMaU/4BE3Dx0iUedPdo2Yofse7dvRuX+8Tp7+EXMA4/HDiIml5e+OunH7lFxuSLiIrC0d27Ua92rQxWaUqKisvJQLV6UTCX3atdB7xfoTzCli1Fxdp1cChqJ6pVqcLjgQuXr8CWtavh7OiIz4cMRdxvv3ILdsaC+YiNTQOVKePfFKMi16/AXD9W2vbJkwSUKVWSKwpLW2DL9WxJn+VClSxWnK+GsWqSd+/Ho5iLK1+F0jWmQM+fP8fjhATurikVSm5XsWPZHz15DKXCGlZKOe4/foISbq54+uwZd0mMOXuO3Y8dblDU0Ynf7p7272xpnzWWUsAsJ7bqxZbpba1tEP/oAUoXL8ndQ7YSx5bqS7i7w8pKs/zPVuZu34vn/6ZLCUhITERiYiKXny0esL8zq4/Fe1hc6Xb8Xbi7ZE1PSP+QWEpFcvJrfoI0m4sS7m58XiQBHKY3bt/ifd9/9BhltVt2WN+37t1ByWIlOFQyNyYn+3fXos78V3cfxEMhV8LdxRk379zjY2CWHfuCYOkQLLWCPcMHDx+iTJnS3Jp7/DQBqmQVT68wdSNQEagKDFSmfnl1/TGwjZo4CRXKv4dJWovIlPdigGSrbENGjsKSeXPhoV3eN+U98tpX4Cx26KiMr0C+i41ARaCyeFCxAeT31g/dtpS8bE/Jb4C80fae/BbKRP0TqAhU7wSoTKQPRndjzsAyehAWdCGBikBFoLIghS2sohKoCFQEqsKq/RY0bgIVgYpAZUEKW1hFJVARqAhUhVX7LWjcBCoCFYHKghS2sIpKoCJQEagKq/Zb0LgJVAQqApUFKWxhFZVARaAiUBVW7begcROoCFQEKgtS2MIqKoGKQEWgKqzab0HjJlARqAhUFqSwhVVUAhWBikBVWLXfgsZNoCJQEagsSGELq6gEKgIVgaqwar8FjZtARaAiUFmQwhZWUQlUBCoCVWHVfgsaN4GKQEWgsiCFLayiEqgIVASqwqr9FjRuAhWBikBlQQpbWEUlUBGoCFSFVfstaNwEKgIVgcqCFLawikqgIlARqAqr9lvQuAlUBCoClQUpbGEVlUBFoCJQFVbtt6BxE6gIVAQqC1LYwioqgYpARaAqrNpvQeMmUBGoCFQWpLCFVVQCFYGKQFVYtd+Cxk2gIlARqCxIYQurqAQqAhWBqrBqvwWNm0BFoCJQWZDCFlZRCVQEKgJVYdV+Cxo3gYpARaCyIIUtrKISqAhUBKrCqv0WNG4CFYGKQGVBCltYRSVQaZ78/wF5YwVniYgIwwAAAABJRU5ErkJggg==",
            "visibleType" => 5, //1:TextOnly, 2:TEXT_WITH_LOGO_LEFT, 3:LOGO_ONLY, 4:TEXT_WITH_LOGO_TOP, 5:TEXT_WITH_BACKGROUND
            //                "signatureText" => "Ngô Quang Đạt \n Chức vụ: Lập trình viên \n email: ngoquangdat@vnpt.vn",
            "signatureText" => "CÔNG TY TNHH GIẢI PHÁP CÔNG NGHỆ MIGROUP",
            "comment" => $comment,
            "signatures" => $signature,
        ];

        $signApi = Http::withToken($token)->post($signUrl, [
            'header' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'credentialId' => $credential,
            'refTranId' => $this->getGUID(),
            'description' => 'Test php signer',
            'datas' => [
                [
                    "name" => $fileName,
                    "dataBase64" => $unsignDataBase64,
                    "options" => json_encode($options),
                ]
            ]
        ]);

        $sign = json_decode($signApi);
        $tranId = isset($sign->content->tranId) ? $sign->content->tranId : '';

        if ($tranId != '') {
            if ($isComplete == 0) {
                // gui mail tiep cho sequence tiep theo
                $signatureWithSequence = $contract->signatures->where('mailed_at', null)->where('dataX', '!=', null)->keyBy('sign_sequence')->pluck(['sign_sequence'])->sort()->values();
                if (count($signatureWithSequence)) {
                    $signatureWithSequenceFirst = $signatureWithSequence[0];

                    $signatureArray = $contract->signatures()->where('sign_sequence', $signatureWithSequenceFirst)->isSignatureUsed()->mailedAtNull()->get();
                    foreach ($signatureArray as $signatureArrayItem) {
                        $signatureArrayItem->update(['mailed_at' => Carbon::now()]);
                    }
                    $clientSignature = $signatureArray[0];
                    $data = [
                        'emails' => $clientSignature->email,
                        'token' => $clientSignature->token,
                        'contract_id' => $contract->id,
                        'contract' => $contract,
                        'user' => $contract->user
                    ];
                    Mail::to($signatureArrayItem->email)->send(new SendMailToClientSign ($data));
                } else {
                    // neu gui het sequence roi thi gui mail thong bao ket qua den tat ca cac mail trong contract
                    $fileNameBySignature = $contract->signatures[0]->file->name;
                    $mailOfContract = $contract->signatures->where('mailed_at', '!=', null)->where('dataX', '!=', null)->keyBy('email')->pluck(['email']);
                    $contract->update(['status' => 'success']);
                    Mail::to($mailOfContract)->send(new SignatureCompleted ([
                        'url' => route('web.files.previewPdf', ['filename' => $fileNameBySignature])
                    ]));

                }
                $view = view('common.remote_signature_complete')->with('tranId', $tranId)->with('token', $token)->with('fileName', $file->name)->render();
                return \response()->json([
                    'view' => $view,
                ]);
            }
        }
    }

    public function reviewFilePdf(Request $request)
    {
        $fileDataUrl = 'https://rmgateway.vnptit.vn/csc/credentials/gettraninfo';
        $fileDataApi = Http::withToken($request->token)->post($fileDataUrl, [
            'header' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'tranId' => $request->tranId
        ]);

        $fileData = json_decode($fileDataApi);
        $fileStatus = $fileData->content->tranStatus;
        $fileContent = $fileData->content->documents[0];

        $dataSigned = $fileContent->dataSigned;
        if ($dataSigned) {
            $base64data = base64_decode($dataSigned, true);
            $path = storage_path('uploads/' . $request->fileName);
            file_put_contents($path, $base64data);
            $name = substr($request->fileName, strpos($request->fileName, '_') + 1, strlen($request->fileName));
            return response()->download($path, $name);
        } else {
            Session::flash('message_signature', 'Vui lòng vào app mobile để xác nhận kí số');
            return view('common.remote_signature_complete')->with('tranId', $request->tranId)->with('token', $request->token)->with('fileName', $request->fileName);
        }
    }

    public function getGUID()
    {
        mt_srand((double)microtime() * 10000);//optional for php 4.2.0 and up.
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8) . $hyphen
            . substr($charid, 8, 4) . $hyphen
            . substr($charid, 12, 4) . $hyphen
            . substr($charid, 16, 4) . $hyphen
            . substr($charid, 20, 12);
        return $uuid;
    }

    public function deleteContract(Request $request)
    {
        $idContract = $request->ids;
        $isDelete = Contract::withTrashed()->whereIn('id', $idContract)->forceDelete();
        if ($isDelete) {
            return \GuzzleHttp\json_encode(redirect()->back()->with('message', 'Bạn xóa hợp đồng thành công'));
        } else {
            return redirect()->back()->with('error_message', 'Bạn xóa hợp đồng thất bại');
        }
    }

    public function testFPDI(Request $request)
    {
        $width = $request->width;
        $height = $request->height;
        $fileName = Contract::find($request->contractId)->file[0]->name;
        $file = storage_path('uploads/' . $fileName);
        if ($height > $width) {
            $pdf = new Fpdi('p', 'pt', [$width, $height]);
        } else {
            $pdf = new Fpdi('l', 'pt', [$width, $height]);
        }
        $pdf->setSourceFile($file);
        for ($i = 1; $i <= $request->totalPage; $i++) {
            $tplId = $pdf->importPage($i);
            $pdf->AddPage();
            $pdf->useTemplate($tplId, 0, 0, $width, $height);
            foreach ($request->signatureInf as $signature) {
                if ($signature[4] == $i) {
                    $top = $signature[0];
                    $left = $signature[1];
                    $signatureWidth = $signature[2];
                    $signatureHeight = $signature[3];
                    $image = $signature[5];
                    $pos = strpos($image, ';');
                    $type = explode(':', substr($image, 0, $pos))[1];
                    $type = str_replace('image/', '', $type);
                    $image = str_replace('data:image/' . $type . ';base64,', '', $image);
                    $image = str_replace(' ', '+', $image);
                    $image = base64_decode($image);
                    $imageName = uniqid() . '.' . $type;
                    $url = storage_path('imageSignature/' . $imageName);
                    $success = file_put_contents($url, $image);
                    $pdf->Image($url, $top, $left, $signatureWidth, $signatureHeight);
                    unlink($url);
                }
            }
        }
        $pdf->output(storage_path('uploads/' . $fileName), "F");
        if ($request->signature_id) {
            $this->clientSendMail($request);
        }
        return response()->json(true);
    }

    public function clientUpload(Request $request)
    {
        $file = File::where('contract_id', $request->contractId)->first();
        $user = User::where('email', $request->email)->first();
        if ($request->file) {
            $fileUpload = $request->file;
            $fileSize = $fileUpload->getSize();
            $fileSizeByKb = number_format($fileSize / 1024, 2);
            $fileUpload->move(base_path('storage/uploads'), $file->name);
            $file->update([
                'type' => $fileUpload->getClientOriginalExtension(),
                'created_at' => Carbon::now(),
                'size' => $fileSizeByKb,
            ]);
        }
        return response()->json(true);

    }
}
