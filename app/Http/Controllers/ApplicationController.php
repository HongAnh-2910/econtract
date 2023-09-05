<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationForProposal;
use App\Exports\ApplicationsForThoughtExport;
use App\Http\Actions\ApplicationAction;
use App\Http\Requests\ApplicationRequest;
use App\Imports\ApplicationsImport;
use App\Mail\Application\SendNotificationMailToClient;
use App\Models\Application;
use App\Models\DateTimeOfApplication;
use App\Models\File;
use App\Models\IpQrcode;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    protected $applicationAction;
    protected $application;

    public function __construct(
        ApplicationAction $applicationAction,
        Application $applicationModel
    )
    {
        $this->applicationAction = $applicationAction;
        $this->application = $applicationModel;
    }

    public function index(Request $request)
    {
        $applicationQuery = $this->application->GetUserApplicationOrUser(Auth::id());
        $considerApplication = User::find(Auth::id())->applicationss;
        $countRecommend = User::find(Auth::id())->applicationss->where('application_type', config('statuses.rest'))->count();
        $countRest = User::find(Auth::id())->applicationss->where('application_type', config('statuses.rest'))->count();
        $applications = $this->applicationAction->listApplications($request);
        $dateTimeOfApplication = DateTimeOfApplication::all();
        $customerStatusIsWaiting = $applicationQuery->StatusApplication(config('statuses.wait'))->count();
        $customerStatusIsApproved = $this->applicationAction->customerStatusIsApprovedCount();
        $customerStatusIsCancel = $this->applicationAction->customerStatusIsCancelCount();
        $customerApplicationType = $this->applicationAction->customerApplicationTypeCount();
        $customerApplicationTypeProposal = $this->applicationAction->customerApplicationTypeProposal();
        $countApplications = $this->applicationAction->countApplications();
        $countSoftDelete = $this->applicationAction->countSoftDelete();
        $statusApplication = $this->applicationAction->statusApplicationResponsive($request);

        return view("dashboard.application.list", compact(
            'applications',
            'dateTimeOfApplication',
            'customerStatusIsWaiting',
            'customerStatusIsApproved',
            'customerStatusIsCancel',
            'countApplications',
            'countSoftDelete',
            'customerApplicationType',
            'customerApplicationTypeProposal',
            'considerApplication',
            'countRecommend',
            'countRest',
            'statusApplication'
        ));
    }

    public function create(Request $request)
    {
        $currentUser = Auth::user();
        $id = $currentUser->parent_id ? $currentUser->parent_id : $currentUser->id;
        $users = User::with('parent')->where(
            'parent_id', $id
        )->get();

        return view("dashboard.application.add", compact('users'));
    }

    public function changeUserWord(Request $request)
    {
        $listIdSelect = $request->value_id;
        $currentUser = Auth::user();
        $id = $currentUser->parent_id ? $currentUser->parent_id : $currentUser->id;
        $users = User::with('parent')->whereNotIn('id', ["$request->value_id"])
            ->where([
                ['parent_id', $id],
                ['id', '<>', Auth::id()]
            ])->get();

        return view('dashboard.application.listConsiderWord', compact('users', 'listIdSelect'));
    }

    public function changeUserWordCheck(Request $request)
    {
        $listIdSelect = $request->value_id;
        $currentUser = Auth::user();
        $id = $currentUser->parent_id ? $currentUser->parent_id : $currentUser->id;
        $users = $this->applicationAction->userApplicationsAjax($id, $request);

        return view('dashboard.application.listCheckWord', compact('users', 'listIdSelect'));
    }

    public function createProposal()
    {
        $currentUser = Auth::user();
        $id = $currentUser->parent_id ? $currentUser->parent_id : $currentUser->id;
        $users = User::with('parent')->where(
            'parent_id', $id
        )->get();

        return view("dashboard.application.addProposal", compact('users'));
    }

    public function store(ApplicationRequest $request)
    {
        if ($request->input('information_day_1')) {
            $application = new Application();
            $randomNumber = rand(0, 99999);
            $styleNumber = str_pad($randomNumber, 5, '0', STR_PAD_LEFT);
            $applicationCodeRandom = 'ONESIGN-' . $styleNumber;
            $application->code = $applicationCodeRandom;
            $application->name = Auth::user()->name;
            $application->status = $request->input('status');
            $application->reason = $request->input('reason');
            $application->application_type = $request->input('application_type');
            $application->department_id = $request->input('department_id');
            $application->position = $request->input('position');
            $application->description = $request->input('description');
            $application->user_id = $request->input('user_id');
            $application->user_application = Auth::id();
            $application->files = '0';
            $application->save();
            foreach ($request->input('information_day_1') as $key => $value) {
                DateTimeOfApplication::create([
                    'information_day_1' => $value,
                    'information_day_2' => $request->input('information_day_2')[$key],
                    'information_day_3' => $request->input('information_day_3')[$key],
                    'information_day_4' => $request->input('information_day_4')[$key],
                    'application_id' => $application->id,
                ]);
            }
            $application->users()->sync($request->user_consider);

            if ($request->hasFile('files')) {
                $files = $request->file('files');
                $application->update([
                    'files' => '1'
                ]);
                foreach ($files as $file) {
                    $fileSize = $file->getSize();
                    $fileSizeByKb = number_format($fileSize / 1024, 2);
                    $fileName = uniqid() . '_' . $file->getClientOriginalName();
                    $file->move(base_path('storage/applications'), $fileName);
                    $newFile = File::create([
                        'name' => $fileName,
                        'path' => $fileName,
                        'type' => $file->getClientOriginalExtension(),
                        'created_at' => Carbon::now(),
                        'user_id' => Auth::id(),
                        'size' => $fileSizeByKb,
                        'upload_st' => 'upload_applications',
                    ]);
                    $application->files()->syncWithoutDetaching([$newFile->id]);
                }
            }
            event(new SendMailDecision($request->user_id , $application));
            event(new SendMailFollow($request->user_consider , $application));
//            $this->applicationAction->sendMailDecision($request->user_id, $application->id);
//            $this->applicationAction->sendMailFollow($request->user_consider, $application->id);

            Session::flash('message_application', 'Bạn đã thêm đơn từ thành công');

            return redirect()->route('web.applications.index');
        }
    }

    public function sendMailReturn(Request $request, $id)
    {
        $emailUser = User::find($id)->email;
        $applications = [
            'title' => 'Đơn từ của OneSign',
            'body' => 'Đang có phần đơn từ cần bạn xét duyệt!'
        ];

        Mail::to($emailUser)->send(new SendNotificationMailToClient($applications));
        Session::flash('message_application', 'Bạn đã gửi lại email thành công');

        return redirect()->route('web.applications.index');
    }

    public function storeProposal(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required',
            ],
            [
                'required' => ':Attribute không được để trống',
            ],
            [
                "user_id" => 'Người kiểm duyệt'
            ]
        );

        $application = new Application();

        $randomNumber = rand(0, 99999);
        $styleNumber = str_pad($randomNumber, 5, '0', STR_PAD_LEFT);
        $applicationCodeRandom = 'ONESIGN-' . $styleNumber;
        $application->code = $applicationCodeRandom;
        $application->name = Auth::user()->name;
        $application->status = $request->input('status');
        $application->application_type = $request->input('application_type');
        $application->position = $request->input('position');
        $application->reason = $request->input('reason');
        $application->proposal_name = $request->input('proposal_name');
        $application->proponent = $request->input('proponent');

        $application->code = $applicationCodeRandom;
        $application->name = Auth::user()->name;
        $application->status = $request->input('status');
        $application->application_type = $request->input('application_type');
        $application->position = $request->input('position');
        $application->reason = $request->input('reason');
        $application->proposal_name = $request->input('proposal_name');
        $application->proponent = $request->input('proponent');
        $application->code = $applicationCodeRandom;
        $application->name = Auth::user()->name;
        $application->status = $request->input('status');
        $application->application_type = $request->input('application_type');
        $application->position = $request->input('position');
        $application->reason = $request->input('reason');
        $application->proposal_name = $request->input('proposal_name');
        $application->proponent = $request->input('proponent');
        $application->account_information = $request->input('account_information');
        $application->delivery_date = $request->input('delivery_date');
        $application->delivery_time = $request->input('delivery_time');
        $application->user_id = $request->input('user_id');
        $application->user_application = Auth::id();
        $application->price_proposal = $request->input('price_proposal');
        $application->save();

        $application->users()->sync($request->user_consider);

        if ($request->hasFile('files')) {
            $files = $request->file('files');
            $application->update([
                'files' => '1'
            ]);
            foreach ($files as $file) {
                $fileSize = $file->getSize();
                $fileSizeByKb = number_format($fileSize / 1024, 2);
                $fileName = uniqid() . '_' . $file->getClientOriginalName();
                $file->move(base_path('storage/applications'), $fileName);
                $newFile = File::create([
                    'name' => $fileName,
                    'path' => $fileName,
                    'type' => $file->getClientOriginalExtension(),
                    'created_at' => Carbon::now(),
                    'user_id' => Auth::id(),
                    'size' => $fileSizeByKb,
                    'upload_st' => 'upload_applications',
                ]);
                $application->files()->syncWithoutDetaching([$newFile->id]);
            }
        }

        $this->applicationAction->sendMailDecision($request->user_id, $application->id);
        $this->applicationAction->sendMailFollow($request->user_consider, $application->id);


        Session::flash('message_application', 'Bạn đã thêm đơn từ thành công');

        return redirect()->route('web.applications.index');
    }

    public function show($id)
    {
        return Application::find($id);
    }

    public function edit(Request $request, $id)
    {
        $application = Application::find($id);
        $informationDays = $application->dateTimeOfApplications;
        $userFollow = $application->users;
        $currentUser = Auth::user();
        $id = $currentUser->parent_id ? $currentUser->parent_id : $currentUser->id;
        $users = User::where('parent_id', $id)->orWhere('id', $id)->get();

        return view('dashboard.application.edit', compact('application', 'informationDays', 'users', 'userFollow'));
    }

    public function editProposal($id)
    {
        $application = Application::find($id);
        $currentUser = Auth::user();
        $userFollow = $application->users;
        $id = $currentUser->parent_id ? $currentUser->parent_id : $currentUser->id;
        $users = User::where('parent_id', $id)->orWhere('id', $id)->get();

        return view('dashboard.application.editProposal', compact('application', 'users', 'userFollow'));
    }

    public function update(ApplicationRequest $request, $id)
    {
        $application = Application::find($id);
        $application->fill($request->all());
        $application->save();
        $application->dateTimeOfApplications()->delete();

        foreach ($request->input('information_day_1') as $key => $value) {
            DateTimeOfApplication::create([
                'information_day_1' => $value,
                'information_day_2' => $request->input('information_day_2')[$key],
                'information_day_3' => $request->input('information_day_3')[$key],
                'information_day_4' => $request->input('information_day_4')[$key],
                'application_id' => $application->id,
            ]);
        }
        $application->users()->sync($request->user_consider);
        $this->applicationAction->sendMailDecision($request->user_id, $application->id);
        $this->applicationAction->sendMailFollow($request->user_consider, $application->id);

        return redirect()->route('web.applications.index')->with('message_application', 'Bạn đã sửa đơn từ thành công');
    }

    public function updateProposal(Request $request, $id)
    {
        $application = Application::find($id);
        $application->fill($request->except('_token'));
        $application->save();
        $application->users()->sync($request->user_consider);

        $this->applicationAction->sendMailDecision($request->user_id, $application->id);
        $this->applicationAction->sendMailFollow($request->user_consider, $application->id);


        return redirect()->route('web.applications.index')->with('message_application', 'Bạn đã sửa đơn đề nghị thành công');
    }

    public function destroy(Request $request)
    {
        $ids = $request->ids;
        DateTimeOfApplication::whereIn('application_id', explode(',', $ids))->delete();
        Application::whereIn('id', explode(',', $ids))->delete();

        Session::flash('success', 'Bạn đã xóa đơn từ thành công');
    }

    public function restore(Request $request)
    {
        $ids = $request->ids;
        DateTimeOfApplication::whereIn('application_id', explode(',', $ids))->restore();
        Application::whereIn('id', explode(',', $ids))->restore();

        Session::flash('success', 'Bạn đã khôi phục đơn từ thành công');
    }

    public function forceDeleteApplication(Request $request)
    {
        $ids = $request->ids;
        DateTimeOfApplication::whereIn('application_id', explode(',', $ids))->forceDelete();
        Application::whereIn('id', explode(',', $ids))->forceDelete();

        Session::flash('success', 'Bạn đã xóa vĩnh viễn đơn từ thành công');
    }

    public function listUploadFiles(Request $request)
    {
        $names = $request->input('names');
        $size = $request->input('size');
        $type = $request->input('type');

        return view('dashboard.application.listFileUpload', compact('names', 'size', 'type'));
    }

    public function exportApplicationForThoughtExcel()
    {
        return Excel::download(new ApplicationsForThoughtExport, 'Danh sách đơn từ xin nghỉ.xlsx');
    }

    public function exportApplicationForProposalExcel()
    {
        return Excel::download(new ApplicationForProposal, 'Danh sách đơn từ đề nghị.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);

        $file = $request->file('file')->store('temp');
        $path = storage_path('app') . '/' . $file;

        $import = new ApplicationsImport;
        $import->import($path);
        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }

        Session::flash('success', 'Bạn đã nhập dữ liệu thành công');

        return redirect()->route('web.applications.index');
    }

    public function changeStatusReview($id)
    {
        $application = Application::find($id);
        $application->status = 'Đã duyệt';
        $application->save();
        $user = $application->user_application;
        $emailUser = User::find($user)->email;
        $applications = [
            'title' => 'Đơn từ của OneSign',
            'body' => 'Đơn của bạn đã được duyệt'
        ];
        Session::flash('success', 'Bạn đã xét duyệt đơn từ thành công');

        Mail::to($emailUser)->send(new SendNotificationMailToClient($applications));
    }

    public function changeStatusNotReview($id)
    {
        $application = Application::find($id);
        $application->status = 'Không duyệt';
        $application->save();

        Session::flash('success', 'Bạn đã xét duyệt đơn từ thành công');
    }

    public function liveSearch(Request $request)
    {
        $applications = $this->applicationAction->listApplications($request);
        return view('dashboard.application.searchApplication', compact('applications'));
    }

    public function testQrCodeActive(Request $request, $id)
    {
        $getQr = IpQrcode::where('user_id', $id)->first();
        $userCheck = User::where('id', Auth::id())->first();
        $hour = Carbon::now('Asia/Ho_Chi_Minh')->hour;
        $min = Carbon::now('Asia/Ho_Chi_Minh')->minute;
        $dayCover = '';
        if ($hour <= 9) {
            $dayCover = 'Sáng';
        } elseif ($hour > 9 && $hour <= 13) {
            $dayCover = 'Trưa';
        } elseif ($hour > 13 && $hour <= 18) {
            $dayCover = 'Chiều';
        } elseif ($hour > 18 && $hour <= 21) {
            $dayCover = 'Tối';
        } elseif ($hour > 21) {
            $dayCover = 'Đêm';
        }
        $success = $hour . ':' . $min;
        if ($getQr->ip_network == $request->ip()) {
            return [$userCheck->name, $success, $dayCover];
        }

        return "địa chỉ ip không trung khớp vs cty";
    }

    public function testQrCode(Request $request)
    {
        $userIdQr = IpQrcode::where('user_id', Auth::id())->first();
        $userParent = User::where('id', Auth::id())->first()->parent;

        $usersa = IpQrcode::where('user_id', $userParent->id ?? '')->first();
        $userActiveQr = User::where('id', Auth::id())->where('parent_id', null)->first();
        if ($userActiveQr) {
            $userActiveQr1 = User::where('id', Auth::id())->where('parent_id', null)->first();
        } else {
            $userActiveQr1 = User::where('id', Auth::id())->first()->parent;
        }

        return \view('dashboard.qrcode.testQr', compact('userActiveQr', 'userActiveQr1', 'userIdQr', 'usersa'));
    }

    public function createQrCode(Request $request)
    {
        $qrActive = IpQrcode::where('user_id', Auth::id())->first();
        if ($qrActive) {
            $isSuccess = IpQrcode::where('user_id', Auth::id())->update([
                'ip_network' => $request->ip(),
                'user_id' => Auth::id()
            ]);
            return $isSuccess ? redirect()->back()->with('error_message', 'qr code da duoc tao truoc do') : '';

        } else {
            $isSuccess = IpQrcode::create([
                'ip_network' => $request->ip(),
                'user_id' => Auth::id()
            ]);

            return $isSuccess ? redirect()->back()->with('message', 'Ban da tao qr code thanh cong') : '';
        }
    }

}
