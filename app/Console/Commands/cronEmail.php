<?php

namespace App\Console\Commands;

use App\Mail\Contract\SendMailToClientSign;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class cronEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:cronEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $data = [
            'token' => 'aaaaaaaaaa',
            'contract_id' => '1234',
            'user' => '1235',
        ];
        Mail::to('zzalbert1zz@gmail.com')->send(new SendMailToClientSign ($data));
    }
}
