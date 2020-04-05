<?php

namespace App\Http\Controllers;

use App\EPL;
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
        $pageAuth = $user->authentication(config('auth.privileges.paymentDetails'));
        if ($pageAuth['is_read']) {
            return view('epl_register', ['pageAuth' => $pageAuth, 'id' => $id]);
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
        $epl = new EPL();
        $epl->name = \request('name');
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
        $epl->remark = \request('remark');
        $epl->application_path = \request('application_path');
        $epl->code = \request('application_path');
        // $epl->name = \request('code');




        $data =  \request('file');
        $array = explode(';', $data);
        $array2 = explode(',', $array[1]);
        $array3 = explode('/', $array[0]);
        $type  =  $array3[1];
        $data = base64_decode($array2[1]);
        file_put_contents("1." . $type, $data);
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

    public function generateCode(){
        
    }
}
