<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Client;
use App\Certificate;
use App\SiteClearenceSession;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{

    public function getClientByName($name)
    {
        return Client::with('epls')->where('first_name', 'like', '%' . $name . '%')
            ->orWhere('last_name', 'like', '%' . $name . '%')
            ->get();
    }

    public function getClientByAddress($address)
    {
        return Client::with('epls')->where('address', 'like', '%' . $address . '%')
            ->orWhere('industry_address', 'like', '%' . $address . '%')
            ->get();
    }

    public function getClientByIndustryName($industry)
    {
        return Client::with('epls')->where('industry_name', 'like', '%' . $industry . '%')
            ->get();
    }

    public function getClientByID($id)
    {
        $client = Client::with('epls')->where('nic', $id)->first();
        if ($client) {
            return $client;
        } else {
            return array();
        }
    }

    public function getClientByEPL($code)
    {
        $epls = EPL::join('clients', 'e_p_l_s.client_id', 'clients.id')
            ->where('code', 'like', '%' . $code . '%')
            ->select('code', 'remark', 'status', 'first_name', 'last_name', 'address', 'industry_name', 'clients.id')
            ->get();

        return $epls;
    }

    // public function getClientByLicence($code)
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

    public function getClientByLicence($code)
    {


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

    public function getClientByBusinessRegistration($code)
    {
        $client_data = Client::where('industry_registration_no', $code)->first();
        if ($client_data) {
            $client_data = $client_data->toArray();
        } else {
            return [];
        }
        return $client_data;
    }

    public function getSearchDetails($type)
    {
        $column = 'first_name';
        //        $column_2 = 'last_name';
        switch ($type) {
            case 'name':
                $column = 'first_name';
                break;
            case 'id':
                $column = 'nic';
                break;
            case 'business_reg':
                $column = 'industry_registration_no';
                break;
            case 'by_address':
                $column = 'address';
                break;
            case 'by_industry_name':
                $column = 'industry_name';
                break;
            case 'epl':
                $column = 'code';
                break;
            case 'license':
                $column = 'cetificate_number';
                break;
            case 'site_clear_code':
                $column = 'code';
                break;
            default:
                $column = 'first_name';
                break;
        }
        if ($type == 'epl') {
            $client_data = EPL::pluck($column)->toArray();
        } else if ($type == 'license') {
            //get Certificate Number
            //            $client_data = Certificate::pluck($column)->toArray();
            $client_data = Certificate::pluck($column)->toArray();
            foreach ($client_data as $key => $value) {
                $exploded_value = explode("/", $value);
                $client_data[$key] = $exploded_value[0];
            }
        } elseif ($type == 'site_clear_code') {
            $client_data = SiteClearenceSession::pluck($column)->toArray();
            //            Client::find()
        } else {
            $client_data = Client::pluck($column)->toArray();
        }
        //        $client_data = Client::select('first_name', 'nic', 'industry_registration_no', 'address')->get()->toArray();
        return $client_data;
    }

    public function getBusinessByName($name)
    {
        return EPL::where('registration_no', 'like', '%' . $name . '%')->get();
    }

    public function getClientBySite($name)
    {
        $client_site = SiteClearenceSession::join('clients', 'site_clearence_sessions.client_id', 'clients.id')
            ->where('code', 'like', '%' . $name . '%')
            ->select('code', 'remark', 'site_clearance_type', 'first_name', 'last_name', 'address', 'industry_name', 'clients.id')
            ->get();
        return $client_site;
    }

    public function search($type)
    {
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
            case 'by_industry_name':
                return $this->getClientByIndustryName($value);
            case 'site_clear_code':
                return $this->getClientBySite($value);
            default:
                abort(422);
                return response(array('message' => 'Invalid Code', 422));
        }
    }
}
