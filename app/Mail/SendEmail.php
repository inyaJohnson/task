<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $name, $subject, $heading, $body;

    /**
     * SendEmail constructor.
     * @param $name
     * @param $subject
     * @param $heading
     * @param $body
     */
    public function __construct($name, $subject, $heading, $body)
    {
        $this->name = $name;
        $this->subject = $subject;
        $this->heading = $heading;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@techmozzo.com', 'Techmozzo')->subject($this->subject)->view('email.template');
    }

}
