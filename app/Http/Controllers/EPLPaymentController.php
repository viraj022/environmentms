<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Payment;
use App\PaymentType;
use App\Transaction;
use App\SiteClearance;
use App\Rules\contactNo;
use App\TransactionItem;
use App\Rules\nationalID;
use App\ApplicationCliten;
use App\Client;
use App\Transactioncounter;
use App\Helpers\LogActivity;
use App\SiteClearenceSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Milon\Barcode\DNS1D;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Picqer\Barcode\BarcodeGeneratorSVG;
use Request;

class EPLPaymentController extends Controller
{
    public const REG_FEE = 'EPL Application Fee';

    public function index($id, $type)
    {
        //        abort(503);
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $return = ["id" => $id, 'type' => $type,];
        if ($pageAuth['is_read']) {
            $return['pageAuth'] = $pageAuth;
            if ($type == 'epl') {
                $epl = EPL::find($id);
                if ($epl) {
                    $return['epl_no'] = $epl->code;
                    $return['client'] = $epl->client_id;
                    $return['type_title'] = 'epl_profile';
                } else {
                    abort(404);
                }
            } else if ($type == 'site_clearance') {
                $site = SiteClearenceSession::find($id);
                if ($site) {
                    $return['epl_no'] = $site->code;
                    $return['client'] = $site->client_id;
                    $return['type_title'] = 'site_clearance';
                } else {
                    abort(404);
                }
            }
            $oldPaymentList = TransactionItem::where('transaction_type_id', $id)
                ->with(['transaction' => function ($q) {
                    return $q->withTrashed();
                }])->get();
            // dd($oldPaymentList);
            $return['oldPaymentList'] = $oldPaymentList;
            return view('epl_payment', $return);
        }
    }

    public function addRegistrationPayment() // payment optimized
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'name' => 'required|string',
                'nic' => ['sometimes', 'nullable', 'unique:users', new nationalID],
                'address' => 'nullable|max:255',
                'contact_no' => ['nullable', new contactNo],
            ]);
            return \DB::transaction(function () {
                $applicationClient = new ApplicationCliten();
                $applicationClient->name = request('name');
                $applicationClient->nic = request('nic');
                $applicationClient->address = request('address');
                $applicationClient->contact_no = request('contact_no');
                $msg = $applicationClient->save();
                $transaction = new Transaction();
                $transaction->status = 0;
                $transaction->type = Transaction::APPLICATION_FEE;
                $transaction->application_client_id = $applicationClient->id;
                $transaction->type_id = $applicationClient->id;
                $msg = $msg && $transaction->save();
                if ($msg) {
                    $data = request('items');
                    foreach ($data as $item) {
                        $payment = Payment::find($item['id']);
                        if ($payment) {
                            $transactionItem = new TransactionItem();
                            $transactionItem->transaction_id = $transaction->id;
                            $transactionItem->payment_type_id = $payment->payment_type_id;
                            $transactionItem->payment_id = $payment->id;
                            $transactionItem->transaction_type = Transaction::APPLICATION_FEE;
                            $transactionItem->amount = $item['amount'];
                            $transactionItem->qty = $item['qty'];
                            $msg = $msg && $transactionItem->save();
                        } else {
                            abort(404);
                        }
                    }
                    LogActivity::addToLog('Registration Payment', $transaction);
                    if ($msg) {

                        return array('id' => 1, 'message' => 'true', 'code' => $transaction->id);
                    } else {
                        abort(500);
                    }
                } else {

                    return array('id' => 0, 'message' => 'false');
                }
            });
        } else {
            abort(401);
        }
    }

    public function deleteApplicationPayment($id) // payment optimized
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_delete']) {
            return   DB::transaction(function () use ($id) {
                $transaction = Transaction::where('id', $id)->first();
                if ($transaction) {
                    LogActivity::addToLog('Delete Application payment', $transaction);
                    if ($transaction->transactionItems()->delete() && $transaction->delete()) {
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        return array('id' => 0, 'message' => 'false');
                    }
                } else {
                    abort(404);
                }
            });
        } else {
            abort(401);
        }
    }

    public function getPendingApplicationList()
    {
        // return Transaction::with('transactionItems')->get();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        return $transaction = Transaction::with('transactionItems')
            ->with('applicationClient')
            ->where('status', '<', 2)
            ->whereNotNull('application_client_id')
            ->where('type', Transaction::APPLICATION_FEE)
            ->where('created_at', '>=', date('Y-m-d', strtotime('-1 month')))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function markApplicationPayment($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $transaction = Transactioncounter::findOrFail($id);
        $transaction->payment_status = 1;
        $msg = $transaction->save();
        LogActivity::addToLog('Application Payment Marked ', $transaction);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function processApplication($id) // payment optimized  !not sure about the process
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $transaction = Transaction::where('type', Transaction::APPLICATION_FEE)
                ->where('id', $id)->first();
            // dd($id);
            if ($transaction) {
                if ($transaction->status == 1) {
                    $transaction->status = 2;
                    LogActivity::addToLog('Process application payment', $transaction);
                    if ($transaction->save()) {
                        return array('id' => 1, 'message' => 'true');
                    } else {
                        return array('id' => 0, 'message' => 'false');
                    }
                } else {
                    return response(array('id' => 0, 'message' => 'payment not yet completed or payment already processed or bill has been cancelled'), 403);
                }
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
    }

    public function getApplicationList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $pt = PaymentType::getpaymentByTypeName(PaymentType::APPLICATIONFEE);
        return Payment::where('payment_type_id', $pt->id)->get();
    }

    // public function makeInspectionPayment($eplId)
    // {
    //     $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
    //     if ($pageAuth['is_create']) {
    //         $epl = EPL::find($eplId);
    //         if ($epl) {
    //             $data = request('payments');
    //             foreach ($data  as $payment) {
    //                 switch($payment)
    //             }
    //         } else {
    //             abort(404);
    //         }
    //     } else {
    //         abort(401);
    //     }
    // }

    public function getInspectionPaymentList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $pt = PaymentType::getpaymentByTypeName(PaymentType::INSPECTIONFEE);
        return Payment::with('paymentRanges')->where('payment_type_id', $pt->id)->get();
    }

    public function getLicenctList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $pt = PaymentType::getpaymentByTypeName(PaymentType::LICENCE_FEE);
        if ($pt) {

            return Payment::with('paymentRanges')->where('payment_type_id', $pt->id)->get();
        } else {
            return response("Licence Fee Not Found in the db", 404);
        }
    }

    public function getFineList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $pt = PaymentType::getpaymentByTypeName(PaymentType::FINE);
        if ($pt) {

            return Payment::with('paymentRanges')->where('payment_type_id', $pt->id)->get();
        } else {
            return response("Fine Not Found in the db", 404);
        }
    }

    public function getProcessingFeeList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $eia = PaymentType::getpaymentByTypeName(PaymentType::EIA);
        $iee = PaymentType::getpaymentByTypeName(PaymentType::IEE);
        if ($eia && $iee) {

            $eiaPayment = Payment::with('paymentRanges')->where('payment_type_id', $eia->id)->get();
            $ieePayment = Payment::with('paymentRanges')->where('payment_type_id', $iee->id)->get();
        } else {
            return response("Fine Not Found in the db", 404);
        }
        return ["EIA" => $eiaPayment, "IEE" => $ieePayment];
    }

    public function payEPL($eplId)  // payment optimized
    {
        return \DB::transaction(function () use ($eplId) {
            $user = Auth::user();
            $epl = EPL::find($eplId);
            if ($epl) {
                $transaction = new Transaction();
                $transaction->type = Transaction::TRANS_TYPE_EPL;
                $transaction->status = 0;
                $transaction->type_id = $epl->id;
                $transaction->client_id = $epl->client_id;
                $msg = $transaction->save();
                if ($msg) {
                    $data = request('items');
                    foreach ($data as $item) {
                        $payment = Payment::find($item['id']);
                        if ($payment) {
                            $transactionItem = new TransactionItem();
                            $transactionItem->transaction_id = $transaction->id;
                            $transactionItem->payment_type_id = $payment->payment_type_id;
                            $transactionItem->payment_id = $payment->id;
                            $transactionItem->client_id = $epl->client_id;
                            $transactionItem->qty = 1;
                            $transactionItem->transaction_type = Transaction::TRANS_TYPE_EPL;
                            $transactionItem->transaction_type_id = $epl->id;
                            $transactionItem->amount = $item['amount'];
                            $msg = $msg && $transactionItem->save();
                        } else {
                            abort(404);
                        }
                    }
                    LogActivity::addToLog('Add EPL payment', $transaction);
                    LogActivity::fileLog($epl->client_id, 'Transaction', $user->last_name . " Add EPL payment", 1, 'epl', $epl->id);
                    if ($msg) {
                        return array('id' => 1, 'message' => 'true', 'code' => $transaction->id, 'name' => $epl->client->first_name);
                    } else {
                        return array('id' => 0, 'message' => 'false');
                    }
                }
            } else {
                abort(404);
            }
        });
    }

    public function paySiteClearance($id)
    {
        return \DB::transaction(function () use ($id) {
            $user = Auth::user();
            $site = SiteClearenceSession::find($id);
            if ($site) {
                $transaction = new Transaction();
                $transaction->type = Transaction::TRANS_SITE_CLEARANCE;
                $transaction->status = 0;
                $transaction->type_id = $site->id;
                $transaction->client_id = $site->client_id;
                $msg = $transaction->save();
                if ($msg) {
                    $data = request('items');
                    foreach ($data as $item) {
                        $payment = Payment::find($item['id']);
                        if ($payment) {
                            $transactionItem = new TransactionItem();
                            $transactionItem->transaction_id = $transaction->id;
                            $transactionItem->payment_type_id = $payment->payment_type_id;
                            $transactionItem->payment_id = $payment->id;
                            $transactionItem->client_id = $site->client_id;
                            $transactionItem->qty = 1;
                            $transactionItem->transaction_type = Transaction::TRANS_SITE_CLEARANCE;
                            $transactionItem->transaction_type_id = $site->id;
                            $transactionItem->amount = $item['amount'];
                            $msg = $msg && $transactionItem->save();
                        } else {
                            abort(404);
                        }
                    }
                    LogActivity::addToLog('Add site clearance payment', $transaction);
                    LogActivity::fileLog($site->client_id, 'Transaction', $user->last_name . "Add site clearance payment", 1, 'sc', $site->id);
                    if ($msg) {
                        return array('id' => 1, 'message' => 'true', 'code' => $transaction->id, 'name' => $site->client->first_name);
                    } else {
                        return array('id' => 0, 'message' => 'false');
                    }
                }
            } else {
                abort(404);
            }
        });
    }

    public function paymentList($id)
    {
        // $user = Auth::user();
        // $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $epl = EPL::find($id);
        // dd($epl);
        if ($epl) {
            $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);
            // dd($inspectionTypes);
            $inspection = TransactionItem::with('transaction')->where('transaction_type', Transaction::TRANS_TYPE_EPL)
                ->where('transaction_type_id', $id)
                ->where('payment_type_id', $inspectionTypes->id)
                ->first();
            $license_fee = PaymentType::getpaymentByTypeName(PaymentType::LICENCE_FEE);
            $certificate_fee = TransactionItem::with('transaction')->where('transaction_type', Transaction::TRANS_TYPE_EPL)
                ->where('transaction_type_id', $id)
                ->where('payment_type_id', $license_fee->id)
                ->first();
            $fintType = PaymentType::getpaymentByTypeName(PaymentType::FINE);
            $fine = TransactionItem::with('transaction')->where('transaction_type', Transaction::TRANS_TYPE_EPL)
                ->where('transaction_type_id', $id)
                ->where('payment_type_id', $fintType->id)
                ->first();
            $rtn = array();
            if ($inspection) {
                $rtn['inspection']['status'] = "payed";
                $rtn['inspection']['object'] = $inspection;
            } else {
                $rtn['inspection']['status'] = "not_payed";
            }
            if ($certificate_fee) {
                $rtn['license_fee']['status'] = "payed";
                $rtn['license_fee']['object'] = $certificate_fee;
            } else {
                $rtn['license_fee']['status'] = "not_payed";
            }
            // dd($fine);
            // if ($epl->client->siteClearenceSessions->count() == 0) {
            if ($fine) {
                $rtn['fine']['status'] = "payed";
                $rtn['fine']['object'] = $fine;
            } else {
                $rtn['fine']['status'] = "not_payed";
            }
            // } else {
            //     $rtn['fine']['status'] = "not_available";
            // }

            return $rtn;
        } else {
            abort(404);
        }
    }

    public function SiteClearancePaymentList($id)
    {
        $user = Auth::user();
        // $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        $site = SiteClearenceSession::find($id);

        if ($site) {
            $inspectionTypes = PaymentType::getpaymentByTypeName(EPL::INSPECTION_FEE);
            // dd($inspectionTypes);
            $inspection = TransactionItem::with('transaction')->where('transaction_type', Transaction::TRANS_SITE_CLEARANCE)
                ->where('transaction_type_id', $id)
                ->where('payment_type_id', $inspectionTypes->id)
                ->first();
            $license_fee = PaymentType::getpaymentByTypeName(PaymentType::LICENCE_FEE);
            $certificate_fee = TransactionItem::with('transaction')
                ->where('transaction_type', Transaction::TRANS_SITE_CLEARANCE)
                ->where('transaction_type_id', $id)
                ->where('payment_type_id', $license_fee->id)
                ->first();
            $rtn = array();

            if ($site->processing_status == 2) {
                // EIA payment
                $processingFee = TransactionItem::with('transaction')
                    ->where('transaction_type', SiteClearance::EIA_POSS_FEE)
                    ->where('transaction_type_id', $id)
                    ->where('payment_type_id', $license_fee->id)
                    ->first();
            } else if ($site->processing_status == 3) {
                //IEE payment
                $processingFee = TransactionItem::with('transaction')
                    ->where('transaction_type', SiteClearance::IEE_POSS_FEE)
                    ->where('transaction_type_id', $id)
                    ->where('payment_type_id', $license_fee->id)
                    ->first();
            } else {
                $processingFee = array();
            }

            // dd($inspection);
            if ($inspection) {
                $rtn['inspection']['status'] = "payed";
                $rtn['inspection']['object'] = $inspection;
            } else {
                $rtn['inspection']['status'] = "not_payed";
            }
            if ($certificate_fee) {
                $rtn['license_fee']['status'] = "payed";
                $rtn['license_fee']['object'] = $certificate_fee;
            } else {
                $rtn['license_fee']['status'] = "not_payed";
            }
            if ($site->processing_status == 2) {
                $rtn['processing_fee']['processing_fee_type'] = "EIA";
                if ($processingFee) {
                    $rtn['processing_fee']['status'] = "payed";
                    $rtn['license_fee']['object'] = $certificate_fee;
                } else {
                    $rtn['processing_fee']['status'] = "not_payed";
                }
            } else if ($site->processing_status == 3) {
                $rtn['processing_fee']['processing_fee_type'] = "IEE";
                if ($processingFee) {
                    $rtn['processing_fee']['status'] = "payed";
                    $rtn['license_fee']['object'] = $certificate_fee;
                } else {
                    $rtn['processing_fee']['status'] = "not_payed";
                }
            } else {
                $rtn['processing_fee']['processing_fee_type'] = "N/A";
            }
            return $rtn;
        } else {
            abort(404);
        }
    }

    public function getInspectionFine($eplId)
    {
        return array('id' => 1, 'message' => 'no_fine', 'amount' => '0');
        request()->validate([
            'inspection_fee' => 'required|numeric'
        ]);
        $epl = EPL::find($eplId);
        if ($epl) {
            if (is_null($epl->site_clearance_file)) {
                $transaction = array();
                if (strtotime($epl->start_date) >= strtotime(EPL::FINEDATE)) {
                    //  after
                    $amount = request('inspection_fee') * 2;
                } else {

                    $baseAmount = 0;
                    $certificateFee = 0;
                    // before

                    switch ($epl->business_scale_id) {
                        case 1:
                            $payment = Payment::where('name', '=', 'INSPECTION FINE SMALL')->first();

                            $baseAmount = $payment->amount;
                            break;
                        case 2:
                            $payment = Payment::where('name', '=', 'INSPECTION FINE MEDIUM')->first();
                            $baseAmount = $payment->amount;
                            break;
                        case 3:
                            $payment = Payment::where('name', '=', 'INSPECTION FINE SMALL')->first();
                            $baseAmount = $payment->amount;
                            break;
                        default:
                            return abort(404);
                    }

                    switch ($epl->business_scale_id) {
                        case 1:
                            $payment = Payment::where('name', '=', 'Licence fee for industries category A')->first();
                            $certificateFee = $payment->amount;
                            break;
                        case 2:
                            $payment = Payment::where('name', '=', 'Licence fee for industries category B')->first();
                            $certificateFee = $payment->amount;
                            break;
                        case 3:
                            $payment = Payment::where('name', '=', 'Licence fee for industries category C')->first();
                            $certificateFee = $payment->amount;
                            break;
                        default:
                            return abort(404);
                    }

                    $date1 = $epl->start_date;
                    $date2 = date("Y-m-d");

                    $ts1 = strtotime($date1);
                    $ts2 = strtotime($date2);

                    $year1 = date('Y', $ts1);
                    $year2 = date('Y', $ts2);

                    $month1 = date('m', $ts1);
                    $month2 = date('m', $ts2);

                    $noOFMonths = (($year2 - $year1) * 12) + ($month2 - $month1);
                    $amount = $baseAmount * ($noOFMonths - 1) + $certificateFee;
                }
                return array('id' => 1, 'message' => 'fine', 'amount' => $amount);
            } else {
                return array('id' => 1, 'message' => 'no_fine', 'amount' => '0');
            }
        } else {
            abort(404);
        }
    }
    public function generatePaymentBarCode($code, $name)
    {
        $barcode = $code;
        $generator = new BarcodeGeneratorPNG();
        $code = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($barcode, $generator::TYPE_CODE_128, 3, 50)) . '">';
        return ['BarCode' => $code, 'BarCodeVal' => $barcode, 'name' => $name, 'time' => date('Y-m-d H:i:s')];
    }
}
