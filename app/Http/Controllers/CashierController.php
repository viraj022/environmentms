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
use Illuminate\Support\Facades\DB;

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
        return Transaction::with('transactionItems')->with('client')->where('client_id', $id)->whereNull('online_payment_id')->get();
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

        if (empty($data['invoiceDet']['transactionsId']) && empty($data['industryTransactions'])) {
            if ((empty($request->post('tranItems')))) {
                return array('status' => 0, 'msg' => 'Please add transaction items before continue');
            }
        }


        try {
            //begin transaction
            DB::beginTransaction();
            // $year = Carbon::now()->format('Y');
            $number = 1;

            $lastInvoiceNumber = Invoice::select('invoice_number')
                ->orderBy('created_at', 'desc')
                ->withTrashed()
                ->first();

            if ($lastInvoiceNumber) {
                $number = $lastInvoiceNumber->invoice_number + 1;
                $invoiceNo =  $number;
            }

            $invoiceNo = $number;

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

                if (!$itemsStore) {
                    //throw exception with error message
                    throw new \Exception('Invoice adding unsuccessful');
                }
                DB::commit();
                return array('status' => 1, 'msg' => 'Invoice added successful', 'data' => ['invoice_id' => $invoice->id]);
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
                if (!$transactionUpdate) {
                    //throw exception with error message
                    throw new \Exception('Invoice adding unsuccessful');
                }
                DB::commit();
                return array('status' => 1, 'msg' => 'Invoice added successful', 'data' => ['invoice_id' => $invoice->id], 'type' => 'bulk');
            }

            if (!empty($data['invoiceDet']['transactionsId'])) {
                if (!$invoice) {
                    //throw exception with error message
                    throw new \Exception('Invoice adding unsuccessful');
                }
                $transactionDetails = Transaction::where('id', $data['invoiceDet']['transactionsId'])->first();
                $transactionUpdate = $transactionDetails->update([
                    "invoice_id" =>  $invoice->id,
                    'cashier_name' => Auth::user()->user_name,
                    'status' =>  1,
                    'invoice_no' => $invoiceNo,
                ]);
                if (!$transactionUpdate) {
                    //throw exception with error message
                    throw new \Exception('Invoice adding unsuccessful');
                }
                DB::commit();
                return array('status' => 1, 'msg' => 'Invoice added successful', 'data' => ['invoice_id' => $invoice->id], 'type' => 'single');
            }
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return array('status' => 0, 'msg' => 'Invoice adding unsuccessful');
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
            ->whereNull('online_payment_id')
            ->orderBy('created_at', 'desc')
            ->select(
                'application_client_id',
                'id',
                'type',
                'type_id',
                'client_id',
            )
            ->get();

        // dd($transactions);
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
        $transactionItems = TransactionItem::where('transaction_id', $transaction->id)->get();
        //delete transaction items
        foreach ($transactionItems as $transactionItem) {
            $transactionItem->delete();
        }

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
        //check if invoice has multiple transactions
        if ($invoice->transactions->count() > 1) {
            return $this->printBulkTransactionsInvoice($invoice);
        }
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
            $transactionItems = TransactionItem::where('transaction_id', $transaction->id)->get();
            //delete transaction items
            foreach ($transactionItems as $transactionItem) {
                $transactionItem->delete();
            }

            $transaction->update([
                'status' => 3,
                "canceled_at" => Carbon::now(),
            ]);

            $transaction->delete();
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

    /**
     * income report view
     *
     * @return void
     */
    public function incomeReport()
    {
        return view('cashier-reports.income-report-by-date');
    }

    public function getPaymentTypeGroups()
    {
        $groups = [];


        $paymentTypes = Payment::select(
            'payments.id',
            'payments.payment_type_id',
            'payments.name',
            'payments.type',
            'payments.amount',
            'payment_types.name AS payment_type_name',
            'payment_types.is_grouped'
        )
            ->join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
            ->orderBy('payments.payment_type_id')
            ->get();

        foreach ($paymentTypes as $type) {
            if (!array_key_exists('type_' . $type->payment_type_id, $groups)) {
                $groups['type_' . $type->payment_type_id] = [
                    'id' => $type->payment_type_id,
                    'name' => $type->payment_type_name,
                    'is_grouped' => $type->is_grouped,
                    'payments' => [],
                    'children' => []
                ];
            }

            $groups['type_' . $type->payment_type_id]['payments']['p_' . $type->id] = [
                'id' => $type->id,
                'payment_type_id' => $type->payment_type_id,
                'name' => $type->name,
            ];
            $groups['type_' . $type->payment_type_id]['children']['c_' . $type->id] = $type->id;
        }

        return $groups;
    }

    /**
     * income report by date (Dynamic report - not used)
     *
     * @param Request $request
     * @return void
     */
    public function incomeByDate(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ], $request->all());

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        // get invoice data
        $invoices = Invoice::whereRaw('DATE(invoices.created_at) BETWEEN ? AND ?', [$start_date, $end_date])
            ->where('invoices.status', 1)
            ->join('transactions', 'invoices.id', '=', 'transactions.invoice_id')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->join('payments', 'transaction_items.payment_id', '=', 'payments.id')
            ->join('payment_types', 'transaction_items.payment_type_id', '=', 'payment_types.id')
            ->select(
                'invoices.id as invoice_id',
                'transactions.id as transaction_id',
                'invoices.invoice_date as invoice_date',
                'invoices.amount as invoice_amount',
                'invoices.sub_total as invoice_sub_amount',
                'invoices.vat_amount as vat',
                'invoices.nbt_amount as nbt',
                'invoices.other_tax_amount as tax',
                'invoices.payment_method as payment_method',
                'invoices.payment_reference_number as cheque_number',
                'payments.id as payment_id',
                'payments.name as payment_name',
                'payments.amount as payment_amount',
                'payment_types.id as payment_type_id',
                'payment_types.name as payment_type_name',
            )
            ->get();

        $paymentTypes = $this->getPaymentTypeGroups();
        // dd($paymentTypes);
        $totals = [
            'total_without_tax' => 0.0,
            'vat' => 0.0,
            'nbt' => 0.0,
            'tax_total' => 0.0,
            'total' => 0.0,
        ];
        $cols = [];
        foreach ($paymentTypes as $ptype) {
            if ($ptype['is_grouped']) {
                $cols['c_' . $ptype['id']] = 0.0;
                $totals['c_' . $ptype['id']] = 0.0;
            } else {
                foreach ($ptype['children'] as $v) {
                    $cols['c_' . $v] = 0.0;
                    $totals['c_' . $v] = 0.0;
                }
            }
        }


        $rows = [];

        foreach ($invoices as $invoice) {
            // check if there is no slot for the invoice in the rows yet,
            if (!array_key_exists('in_' . $invoice->invoice_id, $rows)) {
                // create the column cells
                $row = [
                    'date' => $invoice->invoice_date,
                    'receipt_number' => $invoice->invoice_id,
                    'total_without_tax' => $invoice->invoice_sub_amount,
                    'vat' => $invoice->vat,
                    'nbt' => $invoice->nbt,
                    'tax_total' => $invoice->tax,
                    'total' => $invoice->invoice_amount,
                ];

                $totals['total_without_tax'] += $invoice->invoice_sub_amount;
                $totals['vat'] += $invoice->vat;
                $totals['nbt'] += $invoice->nbt;
                $totals['tax_total'] += $invoice->tax;
                $totals['total'] += $invoice->invoice_amount;

                // extract columns from $cols into this arrayÄ
                $row = array_merge($row, $cols);
            }

            if ($paymentTypes['type_' . $invoice->payment_type_id]['is_grouped']) {
                $row['c_' . $invoice->payment_type_id] += doubleval($invoice->payment_amount);
                $totals['c_' . $invoice->payment_type_id] += doubleval($invoice->payment_amount);
            } else {
                $row['c_' . $invoice->payment_id] += doubleval($invoice->payment_amount);
                $totals['c_' . $invoice->payment_id] += doubleval($invoice->payment_amount);
            }

            $rows['in_' . $invoice->invoice_id] = $row;
        }

        return view('cashier-reports.income-report', compact('start_date', 'end_date', 'paymentTypes', 'rows', 'totals'));
    }


    public function incomeReportNew(Request $request)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ], $request->all());

        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        // get invoice data
        $invoices = Invoice::whereRaw('DATE(invoices.invoice_date) BETWEEN ? AND ?', [$start_date, $end_date])
            ->where('invoices.status', 1)
            ->join('transactions', 'invoices.id', '=', 'transactions.invoice_id')
            ->join('transaction_items', 'transactions.id', '=', 'transaction_items.transaction_id')
            ->join('payments', 'transaction_items.payment_id', '=', 'payments.id')
            ->join('payment_types', 'transaction_items.payment_type_id', '=', 'payment_types.id')
            ->select(
                'invoices.id as invoice_id',
                'invoices.invoice_number as invoice_number',
                'invoices.payment_method as payment_method',
                'transactions.id as transaction_id',
                'transactions.type as transaction_type',
                'transaction_items.amount as transaction_amount',
                'invoices.invoice_date as invoice_date',
                'invoices.amount as invoice_amount',
                'invoices.sub_total as invoice_sub_amount',
                'invoices.vat_amount as vat',
                'invoices.nbt_amount as nbt',
                'invoices.other_tax_amount as tax',
                'payments.id as payment_id',
                'payments.name as payment_name',
                'payment_types.id as payment_type_id',
                'payment_types.name as payment_type_name',
            )
            ->orderBy('invoices.id', 'asc')
            ->get();
        // dd($invoices->toArray());
        $paymentTypes = $this->getPaymentTypeGroups();
        // dd($paymentTypes);
        $totals = [
            'apFee_siteClearance_tot' => 0.0,
            'apFee_reneaval_tot' => 0.0,
            'apFee_eplApplication_tot' => 0.0,
            'inspectionCharges_sc_tot' => 0.0,
            'inspectionCharges_epl_tot' => 0.0,
            'licence_fee_tot' => 0.0,
            'licence_books_tot' => 0.0,
            'fine_tot' => 0.0,
            'waste_tot' => 0.0,
            'eia_iee_tot' => 0.0,
            'other_income_tot' => 0.0,
            'all_without_tax_total' => 0.0,
            'vat' => 0.0,
            'nbt' => 0.0,
            'all_tax_total' => 0.0,
            'all_total' => 0.0,
            'cash' => 0.0,
            'cheque' => 0.0,
            'online' => 0.0,
            'bank' => 0.0,
        ];
        $rows = [];
        // return $invoices;
        foreach ($invoices as $invoice) {
            // check if there is no slot for the invoice in the rows yet,
            if (!array_key_exists('in_' . $invoice->invoice_id, $rows)) {
                // create the column cells
                $row = [
                    'date' => $invoice->invoice_date,
                    'receipt_number' => $invoice->invoice_number,
                    'total_without_tax' => $invoice->invoice_sub_amount,
                    'vat' => $invoice->vat,
                    'nbt' => $invoice->nbt,
                    'tax_total' => $invoice->tax,
                    'total' => $invoice->invoice_amount,
                    'apFee_siteClearance' => 0,
                    'apFee_reneaval' => 0,
                    'apFee_eplApplication' => 0,
                    'inspectionCharges_sc' => 0,
                    'inspectionCharges_epl' => 0,
                    'licence_fee' => 0,
                    'licence_books' => 0,
                    'fine' => 0,
                    'waste' => 0,
                    'eia_iee' => 0,
                    'other_income' => 0,
                    'cheque' => ($invoice->payment_method == 'cheque') ? $invoice->invoice_amount : 0,
                    'cash' => ($invoice->payment_method == 'cash') ? $invoice->invoice_amount : 0,
                    'online' => ($invoice->payment_method == 'online') ? $invoice->invoice_amount : 0,
                    'bank' => ($invoice->payment_method == 'bank_deposit') ? $invoice->invoice_amount : 0,
                ];

                $totals['all_without_tax_total'] += $invoice->invoice_sub_amount;
                $totals['vat'] += $invoice->vat;
                $totals['nbt'] += $invoice->nbt;
                $totals['all_tax_total'] += $invoice->tax;
                $totals['all_total'] += $invoice->invoice_amount;
                $totals['cash'] += $row['cash'];
                $totals['cheque'] += $row['cheque'];
                $totals['online'] += $row['online'];
                $totals['bank'] += $row['bank'];
            }
            if ($invoice->payment_type_id == 3 && $invoice->payment_id == 2) {
                $row['apFee_siteClearance'] += $invoice->transaction_amount;
                $totals['apFee_siteClearance_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->payment_type_id == 3 && $invoice->payment_id == 5) {
                $row['apFee_reneaval'] += $invoice->transaction_amount;
                $totals['apFee_reneaval_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->payment_type_id == 3 && $invoice->payment_id == 4) {
                $row['apFee_eplApplication'] += $invoice->transaction_amount;
                $totals['apFee_eplApplication_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->transaction_type == 'Site' && $invoice->payment_type_id == 4) {
                $row['inspectionCharges_sc'] += $invoice->transaction_amount;
                $totals['inspectionCharges_sc_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->transaction_type == 'EPL' && $invoice->payment_type_id == 4) {
                $row['inspectionCharges_epl'] += $invoice->transaction_amount;
                $totals['inspectionCharges_epl_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->payment_type_id == 5) {
                $row['licence_fee'] += $invoice->transaction_amount;
                $totals['licence_fee_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->payment_type_id == 12) {
                $row['licence_books'] += $invoice->transaction_amount;
                $totals['licence_books_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->payment_type_id == 8) {
                $row['fine'] += $invoice->transaction_amount;
                $totals['fine_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->payment_type_id == 9) {
                $row['waste'] += $invoice->transaction_amount;
                $totals['waste_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->payment_type_id == 14) {
                $row['eia_iee'] += $invoice->transaction_amount;
                $totals['eia_iee_tot'] += $invoice->transaction_amount;
            }
            if ($invoice->payment_type_id == 15) {
                $row['other_income'] += $invoice->transaction_amount;
                $totals['other_income_tot'] += $invoice->transaction_amount;
            }

            $rows['in_' . $invoice->invoice_id] = $row;
        }
        // return $totals;
        return view('cashier-reports.income-report2', compact('start_date', 'end_date', 'rows', 'totals'));
    }
}
