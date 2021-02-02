<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller {

    function getClientByName($name) {
        return Client::with('epls')->where('first_name', 'like', '%' . $name . '%')
                        ->orWhere('last_name', 'like', '%' . $name . '%')
                        ->get();
    }

    function getClientByAddress($address) {
        return Client::with('epls')->where('address', 'like', '%' . $address . '%')
                        ->orWhere('industry_address', 'like', '%' . $address . '%')
                        ->get();
    }

    function getClientByID($id) {
        $client = Client::with('epls')->where('nic', $id)->first();
        if ($client) {
            return $client;
        } else {
            return array();
        }
    }

    function getClientByEPL($code) {
        DB::enableQueryLog();
        $epl = EPL::where('code', $code)->first();

        if ($epl) {
//            $client = Client::with('epls')->find($epl->client_id);
            $client = Client::withTrashed()->find($epl->client_id);
//            $client = Client::withTrashed('epls')->get($epl->client_id);
//            dd($client);
//      dd(DB::getQueryLog()); 
            if ($client) {
                return $client;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    // function getClientByLicence($code)
    // {
    //     $epl = EPL::where('certificate_no', 'like', $code . "%")->first();
    //     $serial = Str::substr($epl->certificate_no, 0, strpos($epl->certificate_no, '/'));
    //     if ($serial != $code) {
    //         return array();
    //     }
    //     if ($epl) {
    //         $client = Client::with('epls')->find($epl->client_id);
    //         if ($client) {
    //             return $client;
    //         } else {
    //             return array();
    //         }
    //     } else {
    //         return array();
    //     }
    // }

    function getClientByLicence($code) {


        $epl = EPL::where('certificate_no', 'like', $code . "%")->first();
//        $client = Client::where('file_no', 'like', $code . "%")->first();

        $serial = Str::substr($epl->certificate_no, 0, strpos($epl->certificate_no, '/'));
//        dd($serial);
        if ($serial != $code) {
            return array();
        }
        if ($epl) {
            $client = Client::with('epls')->find($epl->client_id);

            if ($client) {
                return $client;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    function getClientByBusinessRegistration($code) {

        $client_data = Client::where('industry_registration_no', $code)->first()->toArray();
        return $client_data;
//        $epl = EPL::where('registration_no', $code)->first();
//        if ($epl) {
//            $client = Client::with('epls')->find($epl->client_id);
//            if ($client) {
//                return $client;
//            } else {
//                return array();
//            }
//        } else {
//            return array();
//        }
    }

    function getBusinessByName($name) {
        return EPL::where('registration_no', 'like', '%' . $name . '%')->get();
    }

    public function search($type) {
        request()->validate([
            'value' => ['required', 'string'],
        ]);
        $value = request('value');
        switch ($type) {
            case 'name':
                return $this->getClientByName($value);
            case 'id':
                return $this->getClientByID($value);
            case 'epl':
                return $this->getClientByEPL($value);
            case 'license':
                return $this->getClientByLicence($value);
            case 'business_reg':
                return $this->getClientByBusinessRegistration($value);
            case 'business_name':
                return $this->getBusinessByName($value);
            case 'by_address':
                return $this->getClientByAddress($value);
            default:
                abort(422);
                return response(array('message' => 'Invalid Code', 422));
        }
    }

}
