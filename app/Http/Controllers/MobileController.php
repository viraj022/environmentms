<?php

namespace App\Http\Controllers;

use App\Client;
use App\FileView;
use Carbon\Carbon;
use App\InspectionSession;
use App\Helpers\LogActivity;
use Illuminate\Http\Request;
use App\InspectionSessionAttachment;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClientRepository;

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
    public function uploadImage(Request $request, InspectionSession $inspection)
    {
        $user = Auth::user();
        request()->validate([
            'file' => 'required|mimes:jpeg,jpg,png,pdf'
        ]);
            if ($inspection) {
                $e = Client::findOrFail($inspection->client_id);
                $type = $request->file->extension();
                $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
                $fileUrl = "/uploads/" . FieUploadController::getInspectionFilePath($inspection);
                $storePath = 'public' . $fileUrl;
                $path = 'storage' . $fileUrl . "/" . $file_name;
                $request->file('file')->storeAs($storePath, $file_name);
                $inspectionSessionAttachment = new InspectionSessionAttachment();
                $inspectionSessionAttachment->inspection_session_id = $inspection->id;
                $inspectionSessionAttachment->path = $path;
                $inspectionSessionAttachment->type = $type;
                $msg = $inspectionSessionAttachment->save();
                if ($msg) {
                    LogActivity::addToLog('Add Inspection attachment', $inspectionSessionAttachment);
                    return array('id' => 1, 'message' => 'true');
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                abort(404);
            }
        } 
    }
}
