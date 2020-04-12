<?php

namespace App\Http\Controllers;

use App\EPL;
use App\BusinessScale;
use App\Client;
use App\Pradesheeyasaba;
use App\Rules\contactNo;
use App\IndustryCategory;
use App\Payment;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EPLController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            if (Client::find($id) !== null) {
                return view('epl_register', ['pageAuth' => $pageAuth, 'id' => $id]);
            } else {
                abort(401);
            }
        } else {
            abort(401);
        }
    }
    public function profile($client, $profile)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_read']) {
            if (Client::find($client) !== null && EPL::find($profile) !== null) {
                return view('epl_profile', ['pageAuth' => $pageAuth, 'client' => $client, 'profile' => $profile]);
            } else {
                abort(401);
            }
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            $msg =  \DB::transaction(function () {
                request()->validate([
                    'name' => 'required|unique:e_p_l_s,name',
                    'client_id' => 'required|integer',
                    'industry_category_id' => 'required|integer',
                    'contact_no' => ['required', new contactNo],
                    'address' => ['required'],
                    'email' => ['sometimes', 'nullable'],
                    'coordinate_x' => ['numeric', 'nullable', 'between:-180,180'],
                    'coordinate_y' => ['numeric', 'nullable', 'between:-90,90'],
                    'pradesheeyasaba_id' => 'required|integer',
                    'is_industry' => 'required|integer',
                    'investment' => 'required|numeric',
                    'start_date' => 'required|date',
                    'registration_no' => ['sometimes', 'nullable', 'unique:e_p_l_s,registration_no'],
                    'remark' => ['sometimes', 'nullable'],
                ]);
                $epl = new EPL();
                $epl->name = \request('name');
                $epl->client_id = \request('client_id');
                $epl->industry_category_id = \request('industry_category_id');
                $epl->business_scale_id = \request('business_scale_id');
                $epl->contact_no = \request('contact_no');
                $epl->address = \request('address');
                $epl->email = \request('email');
                $epl->coordinate_x = \request('coordinate_x');
                $epl->coordinate_y = \request('coordinate_y');
                $epl->pradesheeyasaba_id = \request('pradesheeyasaba_id');
                $epl->is_industry = \request('is_industry');
                $epl->investment = \request('investment');
                $epl->start_date = \request('start_date');
                $epl->registration_no = \request('registration_no');
                $epl->remark = \request('remark');
                $epl->code = $this->generateCode($epl);
                $epl->application_path = "";
                $msg = $epl->save();

                if ($msg) {
                    $data =  \request('file');
                    $array = explode(';', $data);
                    $array2 = explode(',', $array[1]);
                    $array3 = explode('/', $array[0]);
                    $type  =  $array3[1];
                    $data = base64_decode($array2[1]);
                    file_put_contents($this->makeApplicationPath($epl->id) . "1" . $type, $data);
                    $epl->application_path = $this->makeApplicationPath($epl->id) . "1." . $type;
                    $epl->save();
                    return array('id' => 1, 'message' => 'true', 'rout' => '/epl_profile/client/' . $epl->client_id . '/profile/' . $epl->id);
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            });
            return $msg;
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
    public function store(Request $request)
    {
        //
    }

    public function find($id)
    {
        return EPL::with('client')->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function show(EPL $ePL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function edit(EPL $ePL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EPL $ePL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EPL  $ePL
     * @return \Illuminate\Http\Response
     */
    public function destroy(EPL $ePL)
    {
        //
    }

    private function generateCode($epl)
    {
        $la = Pradesheeyasaba::find($epl->pradesheeyasaba_id);
        // print_r($la);
        $lsCOde = $la->code;

        $industry = IndustryCategory::find($epl->industry_category_id);
        $industryCode = $industry->code;

        $scale = BusinessScale::find($epl->business_scale_id);
        $scaleCode = $scale->code;

        $e = EPL::orderBy('id', 'desc')->first();
        if ($e === null) {
            $serial = 1;
        } else {
            $serial = $e->id;
        }
        $serial = sprintf('%02d', $serial);
        return "PEA/" . $lsCOde . "/EPL/" . $industryCode . "/" . $scaleCode . "/" . $serial . "/" . date("Y");
    }

    private function makeApplicationPath($id)
    {
        if (!is_dir("uploads")) {
            //Create our directory if it does not exist
            mkdir("uploads");
        }
        if (!is_dir("uploads/EPL")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL");
        }
        if (!is_dir("uploads/EPL/" . $id)) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id);
        }
        if (!is_dir("uploads/EPL/" . $id . "/application")) {
            //Create our directory if it does not exist
            mkdir("uploads/EPL/" . $id . "/application");
        }
        return  "uploads/EPL/" . $id . "/application/";
    }

    public function addInspectionPayment()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.EnvironmentProtectionLicense'));
        if ($pageAuth['is_create']) {
            request()->validate([
                'payment_id' => 'required|integer',
                'id' => 'required|integer',
                'amount' => 'required|numeric',
            ]);
            $transaction = array();
            $transaction['payment_type_id'] = Payment::find(\request('payment_id'))->payment_type_id;
            $transaction['payment_id'] = \request('payment_id');
            $transaction['transaction_type'] = EPL::EPL;
            $transaction['transaction_id'] = \request('id');
            $transaction['amount'] = \request('amount');
            $transaction['status'] = 0;
            $transaction['type'] = EPL::INSPECTION;
            $msg  =  TransactionController::create($transaction);
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }
    public function addInspectionFine()
    {
        $baseAmount = 0;
        $epl = EPL::find(\request('id'));
        if ($epl->site_clearance_file !== null) {
            $transaction = array();
            if (strtotime($epl->start_date) >= strtotime(EPL::FINEDATE)) {
                //  after
                switch ($epl->business_scale_id) {
                    case 1:
                        $payment = Payment::where('name','=','INSPECTION FINE LARGE');
                        $transaction['payment_type_id'] = $payment->payment_type_id;
                        $transaction['payment_id'] = $payment->id;
                        $baseAmount->$payment->amount;
                    case 2:
                        $payment = Payment::where('name','=','INSPECTION FINE LARGE');
                        $transaction['payment_type_id'] = $payment->payment_type_id;
                        $transaction['payment_id'] = $payment->id;
                        $baseAmount->$payment->amount;
                    case 3:
                        $payment = Payment::where('name','=','INSPECTION FINE LARGE');
                        $transaction['payment_type_id'] = $payment->payment_type_id;
                        $transaction['payment_id'] = $payment->id;
                        $baseAmount->$payment->amount;
                        default:
                        return abort(404);
                }               
               
                $transaction['transaction_type'] = EPL::EPL;
                $transaction['transaction_id'] = \request('id');
                $transaction['amount'] = \request('amount');
                $transaction['status'] = 0;
                $transaction['type'] = EPL::INSPECTION_FINE;
                $msg  =  TransactionController::create($transaction);
            } else {
                // before
            }


            return array('id' => 0, 'message' => 'no_added', 'amount' => '505');
        } else {
            return array('id' => 0, 'message' => 'no_fine');
        }
    }
    public function getInspectionPaymentDetails($epl)
    {
        $epl = EPL::find($epl);
        if ($ep !== null) {
            $inspection = new Transaction();
            $inspection->transaction_id =  \request('epl');
            $inspection->type =  EPL::INSPECTION;
            $inspection = $inspection->getPaymentDetails();

            $inspectionFine = new Transaction();
            $inspectionFine->transaction_id =  \request('epl');
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
        } else {
            return abort(401);
        }
    }
}
