<?php

namespace App\Http\Controllers;

use App\Http\Actions\ContractAction;
use App\Http\Requests\UserSubscriptionValidation;
use App\Mail\Subscription\SendMailToAdmin;
use App\Models\UserSubscription;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    const MONTH_NAME = 'abbMonthName';
    const STATUS = 'status';

    private $contractAction;

    public function __construct(ContractAction $contractAction)
    {
        $this->contractAction = $contractAction;
    }

    public function index()
    {
        /* get all contracts for chart */
        $contractsViaMonth = $this->contractAction->getContractsViaMonth(Auth::user());
        $monthContracts = $this->contractAction->convertContractsToArray($contractsViaMonth->toArray(), self::MONTH_NAME);
        /* end get all contracts for chart */

        /* get contracts via status */
        $contractsViaStatus = $this->contractAction->getContractsGroupByStatus(Auth::user());
        $statusContracts = $this->contractAction->convertContractsToArray($contractsViaStatus->toArray(), self::STATUS);
        /* end get contracts via status */

        return view('dashboard.dashboard', [
            'contracts' => $monthContracts,
            'statusContracts' => $statusContracts,
        ]);
    }

    public function dashboard()
    {
        return view('dashboard.dashboard');
    }

    public function downloadFolderAsRar(Request $request)
    {
        $zip = new \ZipArchive();
        $fileName = 'myNewFile.rar';
        if ($zip->open(public_path($fileName), \ZipArchive::CREATE) === TRUE) {
            $files = File::files(storage_path('uploads'));

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();

            return response()->download($fileName)->deleteFileAfterSend(true);
        }
    }

    public function downloadAllFilesAsRar(Request $request)
    {
        $zip = new \ZipArchive();
        $fileName = 'myNewFile.rar';
        if ($zip->open(public_path($fileName), \ZipArchive::CREATE) === TRUE) {

            $zipFile = 'uploads/60f7c759bbe94_myfile.pdf';
            $zip->addFile(storage_path($zipFile), $zipFile);

            $zip->close();

            return response()->download($fileName)->deleteFileAfterSend(true);
        }
    }

    public function subscription()
    {
        $subPackages = UserType::where('key_word', '!=', UserType::TYPE_FREE)->get();
        return view('dashboard.subscription', [
            'subPackages' => $subPackages
        ]);
    }

    public function subscriptionStore(UserSubscriptionValidation $usValidation)
    {

        $validated = $usValidation->validated();

        $subscription = UserSubscription::where($validated);

        if ($subscription->count() < 2) {
            $userSubscription = UserSubscription::create($validated);

            $userSubscription->user_id = Auth::id();
            $userSubscription->type_id = $usValidation->input('subscription_option');
            $userSubscription->save();

            Mail::to('info.onesign@gmail.com')->send(new SendMailToAdmin($userSubscription));
        } else {
            $userSubscription = $subscription->first();
        }

        return view('dashboard.subscription.completed', [
            'subType' => $userSubscription->type,
            'subscription' => $userSubscription
        ]);
    }

    public function subscriptionValidate(UserSubscriptionValidation $usValidation)
    {
        $validated = $usValidation->validated();
        return response()->json([
            'success' => true,
        ]);
    }
}
