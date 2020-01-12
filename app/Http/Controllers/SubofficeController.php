<?php

namespace App\Http\Controllers;

use App\Suboffice;
use App\LocalAuthority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubofficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth', 'local']);
    }
    public function index()
    {
        $aUser = Auth::user();
        $suboffices = Suboffice::where('parent_id', $aUser->institute_Id)->get();
        $pageAuth = $aUser->authentication(config('auth.privileges.suboffice'));
        return view('suboffice_create', ['pageAuth' => $pageAuth, 'suboffices' => $suboffices]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aUser = Auth::user();
        // return $aUser->institute_Id;
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'code' => 'nullable|string|max:50',
            'address' => 'sometimes|max:100'
        ]);
        $suboffice = new Suboffice();
        $suboffice->name = \request('name');
        $suboffice->type = Suboffice::SUBOFFICE;
        $suboffice->address = \request('address');
        $suboffice->laCode = \request('code');
        $suboffice->provincial_council_id = null;
        $suboffice->parent_id = $aUser->institute_Id;
        $msg = $suboffice->save();
        if ($msg) {
            return redirect()
                ->back()
                ->with('success', 'Ok');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error');
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
        request()->validate([
            'name' => 'required|max:50|regex:/^[\pL\s\-]+$/u',
            'code' => 'nullable|string|max:50',
            'address' => 'sometimes|max:100'
        ]);
        $suboffice = Suboffice::findOrFail($id);
        $suboffice->name = \request('name');
        $suboffice->address = \request('address');
        $suboffice->laCode = \request('code');
        $msg = $suboffice->save();
        if ($msg) {
            return redirect()
                ->back()
                ->with('success', 'Ok');
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Suboffice  $suboffice
     * @return \Illuminate\Http\Response
     */
    public function show(Suboffice $suboffice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Suboffice  $suboffice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aUser = Auth::user();
        $suboffices = Suboffice::where('parent_id', $aUser->institute_Id)->get();
        $suboffice = Suboffice::where('id', $id)->where('parent_id', $aUser->institute_Id)->first();
        $pageAuth = $aUser->authentication(config('auth.privileges.suboffice'));
        return view('suboffice_update', ['pageAuth' => $pageAuth, 'suboffice' => $suboffice, 'suboffices' => $suboffices]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Suboffice  $suboffice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suboffice $suboffice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Suboffice  $suboffice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aUser = Auth::user();
        $suboffice = Suboffice::where('id', $id)->where('parent_id', $aUser->institute_Id)->first();
        $suboffice->delete();
        return redirect('suboffice');
    }
}
