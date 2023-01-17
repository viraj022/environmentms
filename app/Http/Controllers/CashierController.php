<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Transaction;
use App\PaymentType;
use App\Payment;
use App\Helpers\LogActivity;
use App\Invoice;
use App\TransactionItem;
use Auth;
use FontLib\Table\Type\name;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CashierController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function getDetailsByCode($id)
    {
        $transaction = Transaction::with('transactionItems.payment')
            ->where('id', $id)
            ->first();
        // LogActivity::addToLog('Request Transaction Data', $transaction);
        // dd("dasd");
        LogActivity::addToLog('Save User : UserController', $transaction);
        if (Transaction::APPLICATION_FEE == $transaction->type) {
            $transaction = Transaction::with('transactionItems.payment')->with('applicationClient')
                ->where('id', $id)
                ->first();
        } else {
            $transaction->application_Client = $transaction->client;
            $transaction->application_Client->name = $transaction->client->first_name;
        }
        if ($transaction) {
            return $transaction;
        } else {
            return array("id" => 0, "message" => 'Not Found');
        }
    }
    public function pay($id)
    {
        request()->validate([
            'cashier_name' => 'required|string',
            'invoice_no' => ['required', 'string'],
        ]);
        $transaction = Transaction::findOrFail($id);
        $transaction->status = 1;
        $transaction->cashier_name = request('cashier_name');
        $transaction->invoice_no = request('invoice_no');
        $transaction->billed_at = Carbon::now()->toDateTimeString();
        LogActivity::addToLog('Payment Completed', $transaction);
        if ($transaction->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 1, 'message' => 'false');
        }
    }
    public function cancel($id)
    {
        $transaction = Transaction::where('invoice_no', $id)->first();
        $transaction->status = 3;
        $transaction->canceled_at = Carbon::now()->toDateTimeString();
        LogActivity::addToLog('Payment Cancelled', $transaction);
        if ($transaction->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 1, 'message' => 'false');
        }
    }

    public function getPendingPaymentList()
    {
        $a =   array();
        return    $transaction = Transaction::whereNull('billed_at')->get();
    }

    public function getPendingPaymentByFileID($id)
    {
        return Transaction::with('transactionItems')->with('client')->where('client_id', $id)->get();
    }
    public function getPaymentTypes()
    {
        $paymentType = PaymentType::get();
        return $paymentType;
    }

    public function getPayments()
    {
        $payment = Payment::get();
        return $payment;
    }


    #new cashier
    public function newCashier()
    {
        return view('cashier.index');
    }

    public function getPaymentsByPaymentType($paymentType)
    {
        $payments = Payment::where('payment_type_id', $paymentType)->get();
        return $payments;
    }

    public function invoiceStore(Request $request)
    {
        $data = $request->validate([
            'tranItems' => 'required|array',
            'tranItems.*' => 'required|array',
            'tranItems.*.payment_type' => 'required|exists:payment_types,id',
            'tranItems.*.payment_cat_name' => 'required|exists:payments,name',
            'tranItems.*.amount' => 'required|numeric|gt:0',
            'tranItems.*.category_id' => 'required|exists:payments,id',
            'tranItems.*.qty' => 'required|integer|gt:0',
            'invoiceDet' => 'required|array',
            'invoiceDet.name' => 'required',
            'invoiceDet.telephone' => 'nullable',
            'invoiceDet.nic' => 'nullable',
            'invoiceDet.invoice_date' => 'required',
            'invoiceDet.payment_method' => 'required',
            'invoiceDet.remark' => 'nullable',
            'invoiceDet.amount' => 'required'
        ], $request->all());

        $year = Carbon::now()->format('Y');
        $number = 1;

        $lastInvoiceNumber = Invoice::select('id')
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->first();
        if ($lastInvoiceNumber) {
            $number = $lastInvoiceNumber->id + 1;
            $invoiceNo =  "Invoice/" . $number . "/" . $year;
        }

        $invoiceNo = "Invoice/" . $number . "/" . $year;

        $invoice = Invoice::create([
            'name' => $data['invoiceDet']['name'],
            'contact' => $data['invoiceDet']['telephone'],
            'nic' => $data['invoiceDet']['nic'],
            'payment_method' => $data['invoiceDet']['payment_method'],
            'payment_reference_number' => $data['invoiceDet']['telephone'],
            'user_id' => Auth::user()->id,
            'amount' => $data['invoiceDet']['amount'],
            'invoice_date' => $data['invoiceDet']['invoice_date'],
            'remark' => $data['invoiceDet']['remark'],
            'invoice_number' => $invoiceNo,
        ]);

        $transaction =  Transaction::create([
            'status' => '0',
            'cashier_name' => Auth::user()->user_name,
            'type' => 'application_fee',
            'invoice_id' =>  $invoice->id,
            'invoice_no' => $invoiceNo,
        ]);

        $transactionItems = [];

        foreach ($data['tranItems'] as $transactionItem) {
            $tranItems = new TransactionItem();
            $tranItems->transaction_id  = $transaction->id;
            $tranItems->payment_type_id  = $transactionItem['payment_type'];
            $tranItems->qty  = $transactionItem['qty'];
            $tranItems->amount  = $transactionItem['amount'];
            $tranItems->payment_id  = $transactionItem['category_id'];
            $tranItems->transaction_type  = 'application_fee';
            $transactionItems[] =  $tranItems;
        }

        $itemsStore =  $transaction->transactionItems()->saveMany($transactionItems);

        if ($itemsStore == true) {
            return array('status' => 1, 'msg' => 'Invoice added successful');
        } else {
            return array('status' => 0, 'msg' => 'Invoice adding unsuccessful');
        }
    }

    public function loadTransactions()
    {
        // $invoices = Invoice::whereHas('transaction', function (Builder $query) {
        //     $query->whereNull('canceled_at');
        // })->get();

        $transactions = Transaction::with('transactionItems')->where('status', 0)->whereNull('canceled_at')->get();
        dd($transactions);

        return $transactions;
    }

    public function cancelInvoice(Invoice $invoice)
    {
        $transaction = Transaction::where('invoice_id', $invoice->id)->first();
        $cancelTransaction = $transaction->update([
            "canceled_at" => Carbon::now(),
        ]);

        if ($cancelTransaction == true) {
            return array('status' => 1, 'msg' => 'Invoice canceled');
        } else {
            return array('status' => 0, 'msg' => 'Invoice cancel unsuccessful');
        }
    }

    public function viewInvoice(Invoice $invoice)
    {
        $transaction = Transaction::where('invoice_id', $invoice->id)->first();

        $transactionItems = TransactionItem::where('transaction_id', $transaction->id)->get();

        return view('cashier.invoice-view', compact('invoice', 'transaction', 'transactionItems'));
    }
}
