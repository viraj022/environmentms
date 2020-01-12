<?php

namespace App\Http\Controllers;

use App\LocalAuthority;
use App\Vehicle;
use App\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'local']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aUser = Auth::user();
        // return $aUser->institute_id;
        $vehicles = LocalAuthority::find($aUser->institute_Id)->vehicles;
        $vehicleTypes = VehicleType::all();
        $pageAuth = $aUser->authentication(config('auth.privileges.vehicle'));
        $conditions = array(Vehicle::CONDITION_GOOD => 'Good', Vehicle::CONDITION_MODERATE => 'Moderate', Vehicle::CONDITION_BAD => 'Bad/Out of order');
        $categories = array(Vehicle::CATEGORY_DUMP => 'Dump Vehicle', Vehicle::CATEGORY_TRANSFER => 'Transfer Vehicle', Vehicle::CATEGORY_DUMP_TRANSFER => 'Dump/Transfer');
        $owners = array(Vehicle::OWNER_LA => 'Local Authority', Vehicle::OWNER_PRIVATE => 'Private', Vehicle::OWNER_LA_PRIVATE => 'LA and Private');
        return view('vehicle_create', ['pageAuth' => $pageAuth, 'vehicles' => $vehicles, 'vehicleTypes' => $vehicleTypes, 'conditions' => $conditions, 'categories' => $categories, 'owners' => $owners]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $aUser = Auth::user();
        request()->validate([
            'registerNo' => 'required|max:10|regex:/[a-z0-9- ]+$/u|unique:vehicles,register_no',
            'type' => 'required|integer|',
            'capacity' => 'required|numeric',
            'wide' => 'required|numeric',
            'length' => 'required|numeric',
            'height' => 'required|numeric',
            'production_year' => 'required|integer',
            'bland' => 'required|string|max:20',
            'condition' => 'required|string|max:20',
            'categoty' => 'required|string|max:20',
            'ownership' => 'nullable|string|max:20',
        ]);
        $vehicle = new Vehicle();
        $vehicle->register_no = request('registerNo');
        $vehicle->vehicle_type_id = request('type');
        $vehicle->capacity = request('capacity');
        $vehicle->wide = request('wide');
        $vehicle->length = request('length');
        $vehicle->height = request('height');
        $vehicle->production_year = request('production_year');
        $vehicle->bland = request('bland');
        $vehicle->condition = request('condition');
        $vehicle->dump_type = request('categoty');
        $vehicle->ownership = request('ownership');
        $vehicle->local_authority_id = $aUser->institute_Id;
        $msg = $vehicle->save();
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
        $aUser = Auth::user();
        $vehicle = Vehicle::findOrFail($id);
        request()->validate([
            'registerNo' => 'required|max:10|regex:/[a-z0-9- ]+$/u|unique:vehicles,register_no,' . $vehicle->id,
            'capacity' => 'required|numeric',
            'wide' => 'required|numeric',
            'length' => 'required|numeric',
            'height' => 'required|numeric',
            'production_year' => 'required|integer',
            'bland' => 'required|string|max:20',
            'condition' => 'required|string|max:20',
            'category' => 'required|string|max:20',
            'ownership' => 'nullable|string|max:20',
        ]);

        if ($vehicle->local_authority_id === $aUser->institute_Id) {

            $vehicle->register_no = request('registerNo');
            $vehicle->capacity = request('capacity');
            $vehicle->wide = request('wide');
            $vehicle->length = request('length');
            $vehicle->height = request('height');
            $vehicle->production_year = request('production_year');
            $vehicle->bland = request('bland');
            $vehicle->condition = request('condition');
            $vehicle->dump_type = request('category');
            $vehicle->ownership = request('ownership');
            $msg = $vehicle->save();
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
        } else {
            abort(404);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $aUser = Auth::user();
// return $aUser->institute_id;
        $vehicles = LocalAuthority::find($aUser->institute_Id)->vehicles;
        $vehicle = Vehicle::findOrFail($id);
        if ($vehicle->local_authority_id === $aUser->institute_Id) {
            $vehicleTypes = VehicleType::all();
            $pageAuth = $aUser->authentication(config('auth.privileges.vehicle'));
            $conditions = array(Vehicle::CONDITION_GOOD => 'Good', Vehicle::CONDITION_MODERATE => 'Moderate', Vehicle::CONDITION_BAD => 'Bad/Out of order');
            $categories = array(Vehicle::CATEGORY_DUMP => 'Dump Vehicle', Vehicle::CATEGORY_TRANSFER => 'Transfer Vehicle', Vehicle::CATEGORY_DUMP_TRANSFER => 'Dump/Transfer');
            $owners = array(Vehicle::OWNER_LA => 'Local Authority', Vehicle::OWNER_PRIVATE => 'Private', Vehicle::OWNER_LA_PRIVATE => 'LA and Private');
            return view('vehicle_update', ['pageAuth' => $pageAuth, 'vehicles' => $vehicles, 'vehicleTypes' => $vehicleTypes, 'conditions' => $conditions, 'categories' => $categories, 'owners' => $owners, 'vehicle' => $vehicle]);
        } else {
            abort(404);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aUser = Auth::user();
        $vehicle = Vehicle::findOrFail($id);
        if ($vehicle->local_authority_id === $aUser->institute_Id) {
            $vehicle->delete();
            return redirect('vehicle');

        } else {
            abort(404);
        }
    }
}
