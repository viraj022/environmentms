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

    public function paymentDetails()
    {

        $inspection = new Transaction();
        $inspection->transaction_id =  $this->id;
        $inspection->type =  EPL::INSPECTION;
        $inspection = $inspection->getPaymentDetails();

        $inspectionFine = new Transaction();
        $inspectionFine->transaction_id =  $this->id;
        $inspectionFine->type =  EPL::INSPECTION_FINE;
        $inspectionFine = $inspectionFine->getPaymentDetails();

        $output = array();
        $output['inspection_total'] = $inspection['amount'];
        $output['inspection_payed'] = $inspection['payed'];
        $output['inspection_balance'] = $inspection['amount']  - $inspection['payed'];

        $output['inspectionFine_total'] = $inspectionFine['amount'];
        $output['inspectionFine_payed'] = $inspectionFine['payed'];
        $output['inspectionFine_balance'] = $inspectionFine['amount']  - $inspectionFine['payed'];

        $output['total'] = $output['inspection_total'] + $output['inspectionFine_total'];
        $output['total_payed'] =  $output['inspection_payed'] +   $output['inspectionFine_payed'];
        $output['total_balance'] =  $output['inspection_balance']  + $output['inspectionFine_balance'];

        return $output;
    }
}
