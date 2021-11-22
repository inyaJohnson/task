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

class ForgotPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $token;

    /**
     * ForgotPasswordJob constructor.
     * @param $user
     * @param $token
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Reset Password';
        $heading = 'Techmozzo Password Reset ';
        $body = "You are receiving this email because we received a password reset request for your account.
                    <br/><br/><b><a href=https://techmozzo.org/reset-password?app=audit&token=$this->token>Reset Password</a></b><br />
                    If you did not request a password reset, no further action is required.<br/><br/>

                    If the button doesn't work, copy and paste the URL in your browser's address bar: <br /> <br />
                    https://techmozzo.org/reset-password?app=audit&token=$this->token";
        Mail::to($this->user->email)->send(new SendEmail($this->user->fullName(), $subject, $heading, $body));
    }
}
