<?php

namespace App\Http\Controllers;

use App\Attachemnt;
use App\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ApplicationTypeController extends Controller
{
    const  EPL = 'Environment Protection Licence';


    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            return view('attachementsMap', ['pageAuth' => $pageAuth]);
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
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_create']) {
            \DB::transaction(function () {
                $applicationType = ApplicationType::find(\request('id'));
                $attachment = request('attachment');
                $applicationType->attachemnts()->detach();
                foreach ($attachment as $value) {
                    $applicationType->attachemnts()->attach($value);
                }
            });
            return array('id' => '1', 'msg' => 'true');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\ApplicationType  $applicationType
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            return ApplicationType::with('attachemnts')->get();
        } else {
            abort(401);
        }
    }

    public function find($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            return ApplicationType::with('attachemnts')->find($id);
        } else {
            abort(401);
        }
    }

    public function availableAttachements($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            $applicetion = ApplicationType::with('attachemnts')->whereHas('attachemnts', function ($q) use ($id) {
                $q->where('application_type_id', $id);
            })->first();
            if (!$applicetion) {
                $attachments =  array();
            } else {
                $attachments = $applicetion->attachemnts;
            }

            //dd($applicetion);


            $array = array();
            foreach ($attachments as $value) {
                array_push($array, $value['id']);
            }
            //            $array;
            return Attachemnt::wherenotin('id', $array)->get();
        } else {
            abort(401);
        }
    }

    public function assignedAttachements($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.attachments'));
        if ($pageAuth['is_read']) {
            $applicetion = ApplicationType::with('attachemnts')->whereHas('attachemnts', function ($q) use ($id) {
                $q->where('application_type_id', $id);
            })->first();


            if (!$applicetion) {
                return new Attachemnt();
            } else {
                return $applicetion->attachemnts;
            }
        } else {
            abort(401);
        }
    }

    public function allAttachmentsWithStatus($id)
    {
        $av = $this->availableAttachements($id)->toArray();
        $asigned = $this->assignedAttachements($id)->toArray();
        $all = array();
        foreach ($av as $a) {
            $all[] = array('id' => $a['id'], 'name' => $a['name'], 'st' => 0);
        }
        foreach ($asigned as $as) {
            $all[] = array('id' => $as['id'], 'name' => $as['name'], 'st' => 1);
        }
        //        print_r($all);
        return $all;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApplicationType  $applicationType
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationType $applicationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApplicationType  $applicationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationType $applicationType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplicationType  $applicationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationType $applicationType)
    {
        //
    }
}
