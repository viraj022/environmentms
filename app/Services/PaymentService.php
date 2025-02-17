<?php

namespace App\Services;

use App\EPL;
use App\PaymentType;
use App\Transaction;
use App\TransactionItem;
use Cache;
use Carbon\Carbon;

class PaymentService
{
    /**
     * Get the payment list for the given EPL instance.
     *
     * @param EPL $epl
     * @return array
     */
    public function getPaymentList($typeId, $clientId): array
    {
        $paymentTypes = Cache::remember('p_types', 600, function () {
            $inspectionFee = PaymentType::getpaymentByTypeName(PaymentType::INSPECTIONFEE);
            $licenseFee = PaymentType::getpaymentByTypeName(PaymentType::LICENCE_FEE);
            $fine = PaymentType::getpaymentByTypeName(PaymentType::FINE);
            return [
                $inspectionFee->id => 'inspection',
                $licenseFee->id => 'license_fee',
                $fine->id => 'fine',
            ];
        });
        return $this->getPaymentStatus($typeId, $clientId, $paymentTypes);
    }

    /**
     * Get the payment status for a specific payment type.
     *
     * @param EPL $epl
     * @param PaymentType|null $paymentType
     * @return array
     */
    private function getPaymentStatus($typeId, $clientId, $paymentTypes): array
    {
        $transactions = TransactionItem::where('transaction_type', Transaction::TRANS_TYPE_EPL)
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('invoices', 'transactions.invoice_id', '=', 'invoices.id')
            ->where('transaction_items.client_id', $clientId)
            ->whereIn('payment_type_id', array_keys($paymentTypes))
            ->where('transaction_type_id', $typeId)
            ->where('transactions.status', '1')
            ->whereNull('transactions.canceled_at')
            ->select('transaction_items.amount', 'transactions.created_at', 'invoices.invoice_number', 'invoices.invoice_date', 'transaction_items.payment_type_id')
            ->get();

        if (empty($transactions)) {
            return [];
        }

        $ReturnData = [];
        $transactions->each(function ($transaction) use (&$ReturnData, $paymentTypes) {
            $paymentType = $paymentTypes[$transaction->payment_type_id];
            $ReturnData[$paymentType] = [
                'amount' => $transaction->amount,
                'created_at' => Carbon::parse($transaction->created_at)->format('Y-m-d'),
                'inv_no' => $transaction->invoice_number,
                'invoice_date' => Carbon::parse($transaction->invoice_date)->format('Y-m-d'),
            ];
        });

        return $ReturnData;
    }
}
