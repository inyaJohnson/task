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

class RegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    /**
     * RegistrationJob constructor.
     * @param $user
     */
    public function __construct($user)
    {
            $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Welcome to Techmozzo Audit';
        $heading = 'We are glad to have you onboard';
        $body = "Welcome, Thank you for choosing techmozzo. Thanks for helping us serve our clients better with your tool.
                             <br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks";
        Mail::to($this->user->email)->send(new SendEmail($this->user->fullName(), $subject, $heading, $body));
    }

}
