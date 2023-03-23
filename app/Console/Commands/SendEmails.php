<?php

namespace App\Console\Commands;

use App\Mail\Registration;
use Illuminate\Console\Command;
use App\Models\UserInput;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email evrey 2 minute.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $emails=UserInput::where('sent',false)->pluck('email')->toArray();
        foreach($emails as $email){
            Mail::to($email)->send(new Registration($email));
            UserInput::where('email',$email)->update([
               'sent'=>true
            ]);
        }
        $this->info('Successfully sent email');
    }
}
