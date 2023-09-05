<?php

namespace App\Console\Commands;

use App\Http\Actions\UserAction;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Console\Command;

class UpgradeUserSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:upgrade-subscription {email : User\'s email} {--plan-id=1 : Default subscription plan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Upgrade User Subscription';

    protected $userAction;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserAction $userAction)
    {
        parent::__construct();
        $this->userAction = $userAction;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->info(now() . ' - Start ' . $this->description);

        $email = $this->argument('email');
        $planId = $this->option('plan-id');

        $user = User::where('email', $email)->first();
        $plan = UserType::find($planId);
        if (!empty($user) && !empty($plan)) {
            $this->userAction->extendUserSubscription($user, $plan);

            $this->info('Đã gia hạn thành công cho ' . $email);
        } else {
            $this->error('Lỗi xác thực thông tin!');
        }

        $this->info(now() . ' - End ' . $this->description);
    }
}
