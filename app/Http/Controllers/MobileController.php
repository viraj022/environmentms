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
use App\User;

class MobileController extends Controller
{
    private $clientRepository;
    public function __construct(ClientRepository $clientRepository)
    {
        // $this->middleware('auth:mob');
        $this->clientRepository = $clientRepository;
    }

    public function inspectionFiles()
    {
        return $this->clientRepository->GetInspectionList();
    }

    public function inspectionFilesById($id)
    {
        return $this->clientRepository->GetInspectionListByUser($id);
    }

    public function inspectionListForEo($id)
    {
        return $this->clientRepository->inspectionListForEo($id);
    }

    public function usersList()
    {
        $allUsers = User::select('users.*')->wherenull('deleted_at')->get();
        return $allUsers;
    }

    public function uploadImage(Request $request, $id)
    {
        $user = Auth::user();
        request()->validate([
            'file' => 'required|mimes:jpeg,jpg,png,pdf'
        ]);
        $inspection = InspectionSession::findOrFail($id);
        if ($inspection) {
            $type = $request->file->extension();
            $storePath = "/uploads/" . FieUploadController::getInspectionFilePath($inspection);
            $path = $request->file('file')->store($storePath);
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
