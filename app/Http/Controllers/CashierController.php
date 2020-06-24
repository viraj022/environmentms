<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function getDetailsByCode($code)
    {
        $transaction = Transaction::with('transactionItems')
            ->with('applicationClient')
            ->where('id', $code)
            ->first();
        if ($transaction) {
            return $transaction;
        } else {
            return array("id" => 0, "message" => 'Not Found');
        }
    }
}
