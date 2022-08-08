<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnlineApplicationPaymentLink extends Mailable
{
    use Queueable, SerializesModels;

    public $paymentLink;
    public $requestType;
    public $businessName;
    public $personName;
    public $client;
    public $application;
    public $paymentAmount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($paymentLink, $requestType, $businessName, $personName, $client, $application, $paymentAmount)
    {
        $this->paymentLink = $paymentLink;
        $this->requestType = $requestType;
        $this->businessName = $businessName;
        $this->personName = $personName;
        $this->client = $client;
        $this->application = $this->application;
        $this->paymentAmount = $paymentAmount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('online-requests.emails.renewal');
    }
}
