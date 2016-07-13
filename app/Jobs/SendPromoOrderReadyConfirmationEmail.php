<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\PromoRequest;
use Illuminate\Contracts\Mail\Mailer;

class SendPromoOrderReadyConfirmationEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(PromoRequest $request)
    {
        $this->order = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Mailer $mailer)
    {
        $mailer->send('emails.promoorderreadyconfirmation',['order'=>$this->order,'items'=>$this->order->promoitems,'recipient'=>$this->order->client], function($message){
            $message->from('marketing@konvert.be','Konvert marketing');
            $message->to($this->order->client->email);
            $message->subject('Uw bestelling staat klaar');
        });
    }
}
