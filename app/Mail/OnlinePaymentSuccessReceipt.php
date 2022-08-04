<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OnlinePaymentSuccessReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $requestType;
    public $businessName;
    public $personName;
    public $client;
    public $application;
    public $paymentAmount;
    public $referenceNo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($requestType, $businessName, $personName, $client, $application, $paymentAmount, $referenceNo)
    {
        $this->requestType = $requestType;
        $this->businessName = $businessName;
        $this->personName = $personName;
        $this->client = $client;
        $this->application = $this->application;
        $this->paymentAmount = $paymentAmount;
        $this->referenceNo = $referenceNo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('online-requests.emails.payment-success');
    }
}
