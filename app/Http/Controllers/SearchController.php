<?php

namespace App\Http\Controllers;

use App\Client;
use App\EPL;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function getClientByName($name)
    {
        return Client::where('first_name', 'like', '%' . $name . '%')
            ->orWhere('last_name', 'like', '%' . $name . '%')
            ->get();
    }

    function getClientByID($id)
    {
        $client = Client::find($id);
        if ($client) {
            return $client;
        } else {
            return null;
        }
    }

    function getClientByEPL($code)
    {
        $epl = EPL::where('code', $code)->first();
        if ($epl) {
            $client = Client::find($epl->client_id);
            if ($client) {
                return $client;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    function getClientByLicence($code)
    {
        $epl = EPL::where('certificate_no', $code)->first();
        if ($epl) {
            $client = Client::find($epl->client_id);
            if ($client) {
                return $client;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    function getClientByBusinessRegistration($code)
    {
        $epl = EPL::where('registration_no', $code)->first();
        if ($epl) {
            $client = Client::find($epl->client_id);
            if ($client) {
                return $client;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    function getBusinessByName($name)
    {
        return EPL::where('registration_no', 'like', '%' . $name . '%')->get();
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
            case  'epl':
                return $this->getClientByEPL($value);
            case 'license':
                return $this->getClientByLicence($value);
            case 'business_reg':
                return $this->getClientByBusinessRegistration($value);
            case 'business_name':
                return $this->getBusinessByName($value);
            default:
                abort(422);
                return response(array('message' => 'Invalid Code', 422));
        }
    }
}
