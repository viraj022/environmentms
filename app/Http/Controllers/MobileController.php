<?php

namespace App\Http\Controllers;

use App\Client;
use App\FileView;
use App\InspectionSession;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    private $clientRepository;
    public function __construct(ClientRepository $clientRepository)
    {
        $this->middleware('auth:mob');
        $this->clientRepository = $clientRepository;
    }

    public function test()
    {
    }

    public function inspectionFiles()
    {
        return $this->clientRepository->GetInspectionList();
    }
    public function inspectionFilesById($id)
    {
        return $this->clientRepository->GetInspectionListByUser($id);
    }
    public function uploadImage(InspectionSession $inspectionSession)
    {
        return array("Ok" => "Ok");
    }
}
