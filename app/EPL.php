<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EPL extends Model
{
    use SoftDeletes;
    public const EPL = 'epl';
    public const FINEDATE = '2012-01-01';
    public const INSPECTION = 'inspection';
    public const INSPECTION_FINE = 'inspection_fine';

    public const INSPECTION_FEE = 'Inspection Fee';


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function attachemnts()
    {
        return $this->belongsToMany(Attachemnt::class)->withPivot('path', 'type');
    }

    public function paymentList()
    {

        $epl = EPL::find($this->id);
        if ($epl) {
            $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);
            // dd($inspectionTypes);
            $inspection = TransactionItem::with('transaction')->where('transaction_type', Transaction::TRANS_TYPE_EPL)
                ->where('client_id', $this->id)
                ->where('payment_type_id', $inspectionTypes->id)
                ->first();

            $license_fee = PaymentType::getpaymentByTypeName(PaymentType::LICENCE_FEE);
            $certificate_fee = TransactionItem::with('transaction')
                ->where('transaction_type', Transaction::TRANS_TYPE_EPL)
                ->where('client_id', $this->id)
                ->where('payment_type_id', $license_fee->id)
                ->first();
            $fintType = PaymentType::getpaymentByTypeName(PaymentType::FINE);
            $fine = TransactionItem::with('transaction')
                ->where('transaction_type', Transaction::TRANS_TYPE_EPL)
                ->where('client_id', $this->id)
                ->where('payment_type_id', $fintType->id)
                ->first();
            $rtn = array();
            if ($inspection) {
                $rtn['inspection']['status'] = "payed";
                $rtn['inspection']['object'] = $inspection;
            } else {
                $rtn['inspection']['status'] = "not_payed";
            }
            if ($license_fee) {
                $rtn['license_fee']['status'] = "payed";
                $rtn['license_fee']['object'] = $certificate_fee;
            } else {
                $rtn['license_fee']['status'] = "not_payed";
            }
            if ($epl->site_clearance_file == null) {
                if ($fine) {
                    $rtn['fine']['status'] = "payed";
                    $rtn['fine']['object'] = $fine;
                } else {
                    $rtn['fine']['status'] = "not_payed";
                }
            } else {
                $rtn['fine']['status'] = "not_available";
            }

            return $rtn;
        } else {
            abort(404);
        }
    }

    public  function getNextRnumber()
    {
        $count = EPLRenew::where('e_p_l_id', $this->id)->count();
        return 'R' . ($count + 1);
    }
    public  function getRenewCount()
    {
        return EPLRenew::where('e_p_l_id', $this->id)->count();
    }
}
