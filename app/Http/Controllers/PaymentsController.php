<?php

namespace App\Http\Controllers;

use App\Payment;
use App\PaymentRange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogActivity;
use Exception;

class PaymentsController extends Controller
{
    public const REGULAR = "regular";
    public const RANGED = "ranged";
    public const UNIT = "unit";
    public const MAX = "max";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        return view('payments', ['pageAuth' => $pageAuth]);
    }
    public function index1()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        return view('payment_range', ['pageAuth' => $pageAuth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        request()->validate([
            'payment_type_id' => 'required|numeric',
            'name' => 'required',
            'type' => 'required'
        ]);
        if ($pageAuth['is_create']) {

            $payment = new Payment();
            $payment->payment_type_id = \request('payment_type_id');
            $payment->name = \request('name');
            $payment->type = \request('type');

            if (request('type') == PaymentsController::REGULAR) {
                request()->validate(['amount' => 'required|numeric']);
                $payment->amount = \request('amount');
                $msg = $payment->save();
            } else if (request('type') == PaymentsController::UNIT) {
                request()->validate(['amount' => 'required|numeric']);
                $payment->amount = \request('amount');
                $msg = $payment->save();
            } else if (request('type') == PaymentsController::RANGED) {
                //noneed to add or vlidate amount when save with type ranged
                $msg = $payment->save();
            } else {

                $error = array('message' => "The given data was invalid.", 'errors' => array('amount' => 'The Type must be a one of  ' . PaymentsController::REGULAR . ',' . PaymentsController::UNIT . ',' . PaymentsController::RANGED));
                return response($error, 422)
                    ->header('Content-Type', 'application/JSON'); // validation

            }


            if ($msg) {
                LogActivity::addToLog('Payment Created', $payment);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        request()->validate([
            'name' => 'required'
        ]);

        if ($pageAuth['is_update']) {

            $payment = Payment::findOrFail($id);
            $payment->name = \request('name');
            if ($payment->type == PaymentsController::REGULAR) {
                request()->validate(['amount' => 'required|numeric']);

                $payment->amount = \request('amount');
                $msg = $payment->save();
            } else if ($payment->type == PaymentsController::UNIT) {
                request()->validate(['amount' => 'required|numeric']);
                $payment->amount = \request('amount');
                $msg = $payment->save();
            } else if ($payment->type == PaymentsController::RANGED) {
                //noneed to add or vlidate amount when save with type ranged
                $msg = $payment->save();
            } else {

                $error = array('message' => "The given data was invalid.", 'errors' => array('amount' => 'The Type must be a one of  ' . PaymentsController::REGULAR . ',' . PaymentsController::UNIT . ',' . PaymentsController::RANGED));
                return response($error, 422)
                    ->header('Content-Type', 'application/JSON'); // validation

            }

            if ($msg) {
                LogActivity::addToLog('Payment Updated', $payment);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        if ($pageAuth['is_read']) {
            //    PaymentType::get();
            return Payment::join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
                ->select('payments.*', 'payment_types.name as type_name')
                ->get();
        } else {
            abort(401);
        }
    }

    public function showByPaymentType($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        if ($pageAuth['is_read']) {
            //    PaymentType::get();
            return Payment::join('payment_types', 'payments.payment_type_id', '=', 'payment_types.id')
                ->where('payments.payment_type_id', '=', $id)
                ->select('payments.*', 'payment_types.name as type_name')
                ->get();
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(Payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //deletePayment 
        try {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
            if ($pageAuth['is_delete']) {
                $payment = Payment::findOrFail($id);
                $msg = $payment->delete();
                if ($msg) {
                    LogActivity::addToLog('Payment Deleted', $payment);
                    return array('id' => 1, 'message' => 'true');
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                abort(401);
            }
        } catch (Exception $e) {
            return array('id' => 0, 'message' => 'false');
        }
    }
    //end deletePayment 
    //find by idPayment 
    public function findPayment($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        if ($pageAuth['is_read']) {
            return Payment::findOrFail($id);
        } else {
            abort(401);
        }
    }
    //end find by idPayment
    //find by type
    public function findPayment_by_type()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        if ($pageAuth['is_read']) {

            return Payment::where('type', '=', 'ranged')->get();
        } else {
            abort(401);
        }
    }
    //end find bytype
    //save ranged payment

    public function createRengedPayment()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        request()->validate([
            'payment_id' => 'required'
        ]);
        if ($pageAuth['is_create']) {

            \DB::transaction(function () {
                $range = request('range');
                foreach ($range as $payment_range) {
                    $paymentRange = new PaymentRange();
                    $paymentRange->payments_id = \request('payment_id');
                    $paymentRange->from = $payment_range['from'];
                    $paymentRange->amount = $payment_range['amount'];
                    if ($payment_range['to'] == PaymentsController::MAX) {
                        $paymentRange->to = '9999999999.99';
                    } else {
                        $paymentRange->to = $payment_range['to'];
                    }
                    $paymentRange->save();
                    LogActivity::addToLog('Payment Range Created', $paymentRange);
                }
            });
            return array('id' => 1, 'message' => 'true');
        } else {
            abort(401);
        }
    }
    //end save ranged payment
    //deleteRangedPayment 
    public function destroyRangedPayment($id)
    {
        //no log added 2020 09 10 to this function 

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        if ($pageAuth['is_delete']) {
            $msg = PaymentRange::where('payments_id', '=', $id)->delete();
            LogActivity::addToLog('Payment Range deleted', null);
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }
    //end deleteRangedPayment 
    //find by ranged payment by payment_id
    public function findRangedPayment($payment_id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        if ($pageAuth['is_read']) {

            return PaymentRange::where('payments_id', '=', $payment_id)->get();
        } else {
            abort(401);
        }
    }
    public function getInspectionPayment($id)
    {
        return Payment::with('paymentTypes')->find($id);
    }
}
