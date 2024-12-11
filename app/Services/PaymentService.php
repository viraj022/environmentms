<?php

namespace App\Services;

use App\EPL;
use App\PaymentType;
use App\Transaction;
use App\TransactionItem;
use Carbon\Carbon;

class PaymentService
{
    /**
     * Get the payment list for the given EPL instance.
     *
     * @param EPL $epl
     * @return array
     */
    public function getPaymentList(EPL $epl): array
    {
        $inspectionFee = PaymentType::getpaymentByTypeName(PaymentType::INSPECTIONFEE);
        $licenseFee = PaymentType::getpaymentByTypeName(PaymentType::LICENCE_FEE);
        $fine = PaymentType::getpaymentByTypeName(PaymentType::FINE);

        return [
            'inspection' => $this->getPaymentStatus($epl, $inspectionFee),
            'license_fee' => $this->getPaymentStatus($epl, $licenseFee),
            'fine' => $this->getPaymentStatus($epl, $fine),
        ];
    }

    /**
     * Get the payment status for a specific payment type.
     *
     * @param EPL $epl
     * @param PaymentType|null $paymentType
     * @return array
     */
    private function getPaymentStatus(EPL $epl, $paymentType): array
    {
        // if ($paymentType->id == 5) {
        //     dd($epl, $paymentType);
        // }
        if (!$paymentType) {
            return [];
        }

        $transaction = TransactionItem::with('transaction')
        ->where('transaction_type', Transaction::TRANS_TYPE_EPL)
        ->where('client_id', $epl->client_id)
        ->where('payment_type_id', $paymentType->id)
        ->where('transaction_type_id', $epl->id)
        ->first();
        // if ($paymentType->id == 5) {
        //     dd($transaction,$epl);
        // }

            if (empty($transaction)) {
                return [];
            }
            return [
            'amount' => $transaction->amount,
            'created_at' => Carbon::parse($transaction->created_at)->format('Y-m-d'),
        ];
    }
}
