<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Transaction;
use App\PaymentType;
use App\Payment;
use App\Helpers\LogActivity;
use App\Invoice;
use App\TaxRate;
use App\TransactionItem;
use Auth;
use Illuminate\Http\Request;

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
        $vat = TaxRate::where('name', 'vat')->first();
        $nbt = TaxRate::where('name', 'nbt')->first();

        return view('cashier.index', compact('vat', 'nbt'));
    }

    /**
     * get payments by payment type
     *
     * @param [type] $paymentType
     * @return void
     */
    public function getPaymentsByPaymentType($paymentType)
    {
        $payments = Payment::where('payment_type_id', $paymentType)->get();
        return $payments;
    }

    /**
     * generate invoice
     *
     * @param Request $request
     * @return void
     */
    public function invoiceStore(Request $request)
    {
        $rules = [
            'invoiceDet' => 'nullable|array',
            'invoiceDet.name' => 'required',
            'invoiceDet.telephone' => 'nullable',
            'invoiceDet.nic' => 'nullable',
            'invoiceDet.ind_address' => 'nullable',
            'invoiceDet.invoice_date' => 'required',
            'invoiceDet.payment_method' => 'required',
            'invoiceDet.payment_reference_number' => 'nullable',
            'invoiceDet.cheque_issue_date' => 'nullable',
            'invoiceDet.remark' => 'nullable',
            'invoiceDet.sub_amount' => 'required',
            'invoiceDet.vat' => 'required',
            'invoiceDet.nbt' => 'required',
            'invoiceDet.tax_total' => 'nullable',
            'invoiceDet.amount' => 'required',
            'invoiceDet.transactionsId' => 'nullable|exists:transactions,id',
        ];

        // add validation rules if industry transacitons are present
        if (!empty($request->post('industryTransactions'))) {
            $rules['industryTransactions'] = 'required|array';
            $rules['industryTransactions.*'] = 'required|array';
            $rules['industryTransactions.*.id'] = 'required|exists:transactions,id';
            $rules['industryTransactions.*.name'] = 'required';
            $rules['industryTransactions.*.total'] = 'required';
        }

        // add validation rules if new application transacitons are present
        if (!empty($request->post('tranItems'))) {
            $rules['tranItems'] = 'required|array';
            $rules['tranItems.*'] = 'required|array';
            $rules['tranItems.*.payment_type'] = 'required|exists:payment_types,id';
            $rules['tranItems.*.payment_cat_name'] = 'required|exists:payments,name';
            $rules['tranItems.*.amount'] = 'required|numeric|gt:0';
            $rules['tranItems.*.category_id'] = 'required|exists:payments,id';
            $rules['tranItems.*.qty'] = 'required|integer|gt:0';
        }

        $data = $request->validate($rules, $request->all());

        $year = Carbon::now()->format('Y');
        $number = 1;

        $lastInvoiceNumber = Invoice::select('id')
            ->whereYear('created_at', $year)
            ->orderBy('created_at', 'desc')
            ->withTrashed()
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
            'address' => $data['invoiceDet']['ind_address'],
            'payment_method' => $data['invoiceDet']['payment_method'],
            'payment_reference_number' => $data['invoiceDet']['payment_reference_number'],
            'cheque_issue_date' => $data['invoiceDet']['cheque_issue_date'],
            'user_id' => Auth::user()->id,
            'amount' => $data['invoiceDet']['amount'],
            'invoice_date' => $data['invoiceDet']['invoice_date'],
            'remark' => $data['invoiceDet']['remark'],
            'invoice_number' => $invoiceNo,
            'sub_total' => $data['invoiceDet']['sub_amount'],
            'vat_amount' => $data['invoiceDet']['vat'],
            'nbt_amount' => $data['invoiceDet']['nbt'],
            'other_tax_amount' =>  $data['invoiceDet']['tax_total']
        ]);

        if (!empty($data['tranItems'])) {
            $transaction =  Transaction::create([
                'status' => 1,
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
                return array('status' => 1, 'msg' => 'Invoice added successful', 'data' => ['invoice_id' => $invoice->id]);
            } else {
                return array('status' => 0, 'msg' => 'Invoice adding unsuccessful');
            }
        }

        if (!empty($data['industryTransactions'])) {
            // dd($data['industryTransactions']);
            foreach ($data['industryTransactions'] as $industrytransaction) {
                $transactionDetails = Transaction::where('id', $industrytransaction['id'])->first();
                $transactionUpdate = $transactionDetails->update([
                    "invoice_id" =>  $invoice->id,
                    'cashier_name' => Auth::user()->user_name,
                    'status' =>  1,
                    'invoice_no' => $invoiceNo,
                ]);
            }
            if ($transactionUpdate == true) {
                return array('status' => 1, 'msg' => 'Invoice added successful', 'data' => ['invoice_id' => $invoice->id], 'type' => 'bulk');
            } else {
                return array('status' => 0, 'msg' => 'Invoice adding unsuccessful');
            }
        }

        if (!empty($data['invoiceDet']['transactionsId'])) {
            if ($invoice == true) {
                $transactionDetails = Transaction::where('id', $data['invoiceDet']['transactionsId'])->first();
                $transactionUpdate = $transactionDetails->update([
                    "invoice_id" =>  $invoice->id,
                    'cashier_name' => Auth::user()->user_name,
                    'status' =>  1,
                    'invoice_no' => $invoiceNo,
                ]);
                return array('status' => 1, 'msg' => 'Invoice added successful', 'data' => ['invoice_id' => $invoice->id], 'type' => 'single');
            } else {
                return array('status' => 0, 'msg' => 'Invoice adding unsuccessful');
            }
        }
    }

    /**
     * get all unpaid transactions
     *
     * @return void
     */
    public function loadTransactions()
    {
        $transactions = Transaction::with('transactionItems')
            ->where('status', 0)
            ->whereNull('canceled_at')
            // ->whereNull('invoice_id')
            ->orderBy('created_at', 'desc')
            ->get();

        return $transactions;
    }

    /**
     * Cancel transactions
     *
     * @param Transaction $transaction
     * @return void
     */
    public function cancelTransaction(Transaction $transaction)
    {
        $cancelTransaction = $transaction->update([
            "canceled_at" => Carbon::now(),
            "status"  =>  '3',
        ]);

        $transaction->delete();

        if ($cancelTransaction == true) {
            return array('status' => 1, 'msg' => 'Transaction canceled');
        } else {
            return array('status' => 0, 'msg' => 'Transaction cancel unsuccessful');
        }
    }

    /**
     * invoice view (Not used)
     *
     * @param Invoice $invoice
     *@return View|Factory
     */
    public function viewInvoice(Invoice $invoice)
    {
        $transaction = Transaction::where('invoice_id', $invoice->id)->first();

        $transactionItems = TransactionItem::where('transaction_id', $transaction->id)->get();

        return view('cashier.invoice-view', compact('invoice', 'transaction', 'transactionItems'));
    }

    /**
     * invoice print view
     *
     * @param Invoice $invoice
     * @return View|Factory
     */
    public function printInvoice(Invoice $invoice)
    {
        $transaction = Transaction::with('transactionItems')->where('invoice_id', $invoice->id)->first();
        return view('cashier.invoice-print', compact('invoice', 'transaction'));
    }

    /**
     * invoice print view for multiple transactions 
     *
     * @param Invoice $invoice
     * @return View|Factory
     */
    public function printBulkTransactionsInvoice(Invoice $invoice)
    {
        $transactions = Transaction::with('transactionItems')->where('invoice_id', $invoice->id)->get();
        return view('cashier.bulk-transactions-invoice-print', compact('invoice', 'transactions'));
    }

    /**
     * tax rate edit view
     *
     * @return View|Factory
     */
    public function editTaxRate()
    {
        $taxes = TaxRate::all();
        return view('cashier.tax-rate-edit', compact('taxes'));
    }

    /**
     * change tax rate post route
     *
     * @param Request $request
     * @return Redirector|RedirectResponse
     */
    public function changeTaxRate(Request $request)
    {
        $data = $request->validate([
            'tax_type' => 'required|exists:tax_rates,id',
            'tax_rate' => 'required|numeric|gte:0|lte:100',
            'changed_user' => 'required|exists:users,id'
        ]);

        $tax = TaxRate::where('id', $data['tax_type'])->first();

        $tax->update([
            'rate' => $data['tax_rate'],
            'changed_user' => $data['changed_user'],
        ]);
        $taxes = TaxRate::all();

        return redirect()->route('change-tax-rate-view', compact('taxes'))->with('taxRate', 'Tax rate changed successfully!');
    }

    /**
     * load invoice list view
     *
     * @return void
     */
    public function loadInvoices()
    {
        return view('cashier-reports.invoice-list');
    }

    /**
     * load invoices by date
     *
     * @param Request $request
     * @return void
     */
    public function loadInvoicesByDate(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ], $request->all());

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        $invoices = Invoice::where('status', 1)->whereRaw('DATE(invoice_date) BETWEEN ? AND ?', [$start_date, $end_date])->get();

        return view('cashier-reports.invoice-list', compact('invoices', 'start_date', 'end_date'));
    }

    /**
     * cancel invoice
     *
     * @param Invoice $invoice
     * @return void
     */
    public function cancelInvoice(Invoice $invoice)
    {
        $now = Carbon::now()->format('Y-m-d');

        $transactions = Transaction::where('invoice_id', $invoice->id)->get();

        foreach ($transactions as $transaction) {
            $transaction->update([
                'status' => 0,
            ]);
        };

        $cancelInvoice = $invoice->update([
            'status' => 0,
            'canceled_at' => $now,
            'canceled_by' => Auth::user()->id,
        ]);

        $invoiceDeleted = $invoice->delete();

        if ($invoiceDeleted == true) {
            return array('status' => 1, 'msg' => 'Invoice cancelled');
        } else {
            return array('status' => 0, 'msg' => 'Invoice cancel unsuccessful');
        }
    }

    /**
     * canceled invoices list
     *
     * @param Invoice $invoice
     * @return void
     */
    public function canceledInvoiceList()
    {
        return view('cashier-reports.canceled-invoices');
    }

    /**
     * canceled invoices list by date
     *
     * @param Invoice $invoice
     * @return void
     */
    public function canceledInvoicesByDate(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ], $request->all());

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        $canceledInvoices = Invoice::where('status', 0)
            ->whereRaw('DATE(canceled_at) BETWEEN ? AND ?', [$start_date, $end_date])
            ->withTrashed()
            ->get();

        return view('cashier-reports.canceled-invoices', compact('canceledInvoices', 'start_date', 'end_date'));
    }
}
