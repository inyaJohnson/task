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

class CreateClientJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $consultant, $client, $password;

    /**
     * PatientRegistrationJob constructor.
     * @param $consultant
     * @param $client
     * @param $password
     */
    public function __construct($consultant, $client, $password)
    {
        $this->password = $password;
        $this->client = $client;
        $this->consultant = $consultant;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Welcome to Techmozzo Task Portal';
        $heading = 'We are glad to have you onboard';
        $body = "Welcome, Thank you for choosing ". $this->consultant->fullName(). " In order to serve you better, we have created an account for you so as to enable us reach out to you easily.
                    <br/> Your password is $this->password
                    <br/><br/>Reach out to Techmozzo Support if you have any complaints or enquiries. <br/><br/> Thanks";
        Mail::to($this->client->email)->send(new SendEmail($this->client->fullName(), $subject, $heading, $body));
    }
}
