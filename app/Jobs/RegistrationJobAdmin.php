<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RegistrationJobAdmin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $email;

    /**
     * RegistrationJobAdmin constructor.
     * @param $user
     * @param $email
     */
    public function __construct($user, $email)
    {
        $this->user = $user;
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'New user on Techmozzo Audit Platform';
        $heading = $this->user->fullName() . ' registered on Audit Platform';
        $body = "This is to inform you of a new registration on the Audit Platform.
                <br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks";
        Mail::to($this->email)->send(new SendEmail('Admin', $subject, $heading, $body));
    }
}
