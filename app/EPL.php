<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EPL extends Model
{
    use SoftDeletes;
    
    public const FINEDATE = '2012-01-01';
    public const EPL = 'epl';
    public const INSPECTION = 'inspection';
    public const INSPECTION_FINE = 'inspection_fine';
    protected $appends = ['epl_instantNumber', 'expire_date_only', 'issue_date_only', 'submit_date_only'];

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
        abort(404, "Method removed-hcw code");
    }

    public function certificateInfo()
    {
        $info = array();

        if ($this->status == 1) {
            $info['issue_status'] = 'issued';
            $info['issue_details'] =  array('certificate_no' => $this->certificate_no, 'issue_date' => $this->issue_date, 'expire_date' => $this->expire_date);
            $renew =   EPLRenew::where('e_p_l_id', $this->id)->get();
            $info['renewals'] = array();
            $info['last_issue_date'] = $this->issue_date;
            $info['last_expire_date'] = $this->expire_date;
            $info['last_certificate_no'] = $this->certificate_no;
            $now = time();
            $expire_date = strtotime($this->expire_date);
            $expire_days = $now - $expire_date;
            $info['expired_days'] = round($expire_days / (60 * 60 * 24));
            if (count($renew) > 0) {
                foreach ($renew as $value) {
                    $i = array();
                    $i['r_number'] = "R" . $value->count;
                    if ($value['issue_status'] == 1) {
                        $i['issue_status'] = 'issued';
                        $i['certificate_no'] = $value->certificate_no;
                        $i['issue_date'] = $value->renew_date;
                        $i['expire_date'] = $value->expire_date;

                        $info['last_issue_date'] = $value->renew_date;
                        $info['last_expire_date'] = $value->expire_date;
                        $now = time(); // or your date as well
                        $expire_date = strtotime($value->expire_date);
                        $expire_days = $now - $expire_date;
                        $info['expired_days'] = round($expire_days / (60 * 60 * 24));
                        $info['last_certificate_no'] = $value->certificate_no;
                    } else {
                        $i['issue_status'] = 'not_issued';
                    }
                    array_push($info['renewals'], $i);
                }
            } else {
            }
        } else {
            $info['issue_status'] = 'not_issued';
        }
        return $info;
    }

    public function getEplInstantNumberAttribute()
    {
        return $this->code . '/r' . $this->count;
    }
    // issue_date
    // expire_date
    //to fix date format 2020 09 12

    public function getIssueDateOnlyAttribute()
    {
        //return strtotime($this->schedule_date)->toDateString();
        return Carbon::parse($this->issue_date)->format('Y-m-d');
    }

    public function getExpireDateOnlyAttribute()
    {
        //return strtotime($this->schedule_date)->toDateString();
        return Carbon::parse($this->expire_date)->format('Y-m-d');
    }
    public function getSubmitDateOnlyAttribute()
    {
        //return strtotime($this->schedule_date)->toDateString();
        return Carbon::parse($this->submitted_date)->format('Y-m-d');
    }
    public function minutes()
    {
        return $this->hasMany(Minute::class);
    }
}
