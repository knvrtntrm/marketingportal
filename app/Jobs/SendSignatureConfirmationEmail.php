<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \Illuminate\Contracts\Mail\Mailer;

class SendSignatureConfirmationEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $recipient;
    protected $signature_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recipient,$signature_name)
    {
        $this->recipient = $recipient;
        $this->signature_name = $signature_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('emails.signatureconfirmation',['signature_name'=>$this->signature_name],function($message){

            $message->from('marketing@konvert.be','Konvert Marketing');
            $message->to($this->recipient);
            $message->subject('Emailhandtekening goedgekeurd');


        });
    }
}
