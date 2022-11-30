<?php

namespace App\Http\Controllers;

use App\Client;
use App\User;
use App\Minute;
use App\AssistantDirector;
use App\EnvironmentOfficer;
use App\Level;
use App\Helpers\LogActivity;
use App\Repositories\ClientRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\MinutesRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\UserNotificationsRepositary;

class AssistantDirectorController extends Controller
{

    private $userNotificationsRepositary;
    public function __construct(UserNotificationsRepositary $userNotificationsRepositary)
    {
        $this->userNotificationsRepositary = $userNotificationsRepositary;
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
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        return view('assistant_director', ['pageAuth' => $pageAuth]);
    }

    public function adPendingIndex()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        return view('ad_pending_list', ['pageAuth' => $pageAuth]);
    }

    public function directorPendingListIndex()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        return view('director_pending_list', ['pageAuth' => $pageAuth]);
    }

    public function directorApprovedListIndex()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        return view('director_approved_list', ['pageAuth' => $pageAuth]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        request()->validate([
            'user_id' => 'required',
            'zone_id' => 'required',
        ]);
        if ($pageAuth['is_create']) {
            if ($this->checkAssistantDirector(\request('user_id'))) {
                $assistantDirector = new AssistantDirector();
                $assistantDirector->user_id = \request('user_id');
                $assistantDirector->zone_id = \request('zone_id');
                $assistantDirector->active_status = '1';
                $msg = $assistantDirector->save();
                LogActivity::addToLog('Add new Assistance director', $assistantDirector);
                if ($msg) {
                    return array('id' => 1, 'message' => 'true');
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                return array('message' => 'Custom Validation processable entry', 'errors' => array('user_id' => 'user is already already assigned as an active assistant director'));
            }
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
    public function store($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        request()->validate([
            'user_id' => 'required',
            'zone_id' => 'required',
        ]);
        if ($pageAuth['is_update']) {
            $assistantdirector = AssistantDirector::findOrFail($id);
            $assistantdirector->user_id = \request('user_id');
            $assistantdirector->zone_id = \request('zone_id');
            $msg = $assistantdirector->save();
            LogActivity::addToLog('Assistant director updated', $assistantdirector);
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function UnActiveAssistantDirector($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        //  request()->validate([
        //     'user_id' => 'required',
        //     'zone_id' => 'required',
        // ]);
        if ($pageAuth['is_update']) {
            $assistantdirector = AssistantDirector::findOrFail($id);
            $assistantdirector->active_status = '0';
            $msg = $assistantdirector->save();
            LogActivity::addToLog('Inactive assistant director' . $id, $assistantdirector);
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AssistantDirector  $assistantDirector
     * @return \Illuminate\Http\Response
     */
    public function show(AssistantDirector $assistantDirector)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AssistantDirector  $assistantDirector
     * @return \Illuminate\Http\Response
     */
    public function edit(AssistantDirector $assistantDirector)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AssistantDirector  $assistantDirector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AssistantDirector $assistantDirector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AssistantDirector  $assistantDirector
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));

        if ($pageAuth['is_update']) {
            $assistantdirector = AssistantDirector::findOrFail($id);
            $assistantdirector->active_status = '0';
            $msg = $assistantdirector->save();
            if ($msg) {
                LogActivity::addToLog('Delete Assistant director', $assistantdirector);
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    //get allUser not in 
    public function getAllUsersNotInAssistantDirector()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        if ($pageAuth['is_read']) {
            $assistantDirectors = AssistantDirector::where('active_status', '1')->select('user_id')->get();
            $environmentOfficers = EnvironmentOfficer::where('active_status', '1')->select('user_id as id')->get();
            return User::whereHas('roll.level', function ($queary) {
                $queary->where('name', Level::ASSI_DIRECTOR);
            })->wherenotin('id', $assistantDirectors)->wherenotin('id', $environmentOfficers)->get();
        } else {
            abort(401);
        }
    }

    //end get allUser not in 
    //get all active_AssistantDirector
    public function getAll_active_AssistantDirector()
    {
        $user = Auth::user();
        //        dd($user->roll->level->value);
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        $query = AssistantDirector::query()->join('users', 'assistant_directors.user_id', '=', 'users.id')
            ->join('zones', 'assistant_directors.zone_id', '=', 'zones.id')
            ->join('rolls', 'users.roll_id', '=', 'rolls.id');
        $query = $query->where('assistant_directors.active_status', '=', '1');
        if ($user->roll->level->value == 2) {
            $query = $query->where('users.id', '=', $user->id);
        }
        $query = $query->select('assistant_directors.id', 'users.first_name as first_name', 'users.last_name as last_name', 'users.user_name as user_name', 'users.id as user_id', 'zones.id as zone_id', 'zones.name as zone_name')
            ->get();
        return $query;
    }

    public function assistantDirectorByZone($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        if ($pageAuth['is_read']) {

            return AssistantDirector::join('users', 'assistant_directors.user_id', '=', 'users.id')
                ->join('zones', 'assistant_directors.zone_id', '=', 'zones.id')
                ->where('assistant_directors.active_status', '=', '1')
                ->where('zones.id', '=', $id)
                ->select('users.first_name as first_name', 'users.last_name as last_name', 'users.user_name as user_name', 'users.id as user_id', 'zones.id as zone_id', 'zones.name as zone_name')
                ->get();
        } else {
            abort(401);
        }
    }

    //get a AssistantDirector
    public function get_a_AssistantDirector($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.assistantDirector'));
        if ($pageAuth['is_read']) {

            //    PaymentType::get();
            return AssistantDirector::join('users', 'assistant_directors.user_id', '=', 'users.id')
                ->join('zones', 'assistant_directors.zone_id', '=', 'zones.id')
                ->where('assistant_directors.id', '=', $id)
                ->select('assistant_directors.id', 'users.first_name as first_name', 'users.last_name as last_name', 'users.user_name as user_name', 'users.id as user_id', 'zones.id as zone_id', 'zones.name as zone_name', 'assistant_directors.active_status as active_status')
                ->first();
        } else {
            abort(401);
        }
    }

    //end get a AssistantDirector

    public function checkAssistantDirector($id)
    {
        $assistantDirector = AssistantDirector::where('user_id', '=', $id)
            ->where('active_status', '=', 1)->first();
        if ($assistantDirector === null) {
            return true;
        } else {
            return false;
        }
    }

    public function getAssistanceDirectorsByLevel()
    {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = AssistantDirector::with('user')->where('active_status', 1)->get();
            // dd($data->toArray());
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = AssistantDirector::with('user')->where('user_id', $user->id)->where('active_status', 1)->get();
            // dd($data);
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $data = AssistantDirector::with('user')->where('id', EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first()->assistant_director_id)->get();
        }
        return $data;
    }

    public function getAssistanceDirectorFile()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
    }

    public function approveFile(Request $request, MinutesRepository $minutesRepository, $adId, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $adId, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $data = array();
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $assistantDirector = AssistantDirector::with('user')->findOrFail($adId);
            $msg = setFileStatus($file_id, 'file_status', 2);
            $msg = setFileStatus($file_id, 'cer_status', 0);

            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }

            fileLog($file->id, 'Approval', 'AD (' . $assistantDirector->user->last_name . ')  and forward to certificate drafting.', 0, $fileTypeName, '');
            LogActivity::addToLog('AD approve file', $file);

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->user_id,
                'Approved for "' . $file->industry_name . '"',
                $file->id
            );

            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ASSI_APPROVE_FILE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function rejectFile(Request $request, MinutesRepository $minutesRepository, $adId, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $adId, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $data = array();
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::with('environmentOfficer')->whereId($file_id)->first();

            $assistantDirector = AssistantDirector::with('user')->findOrFail($adId);
            $msg = setFileStatus($file_id, 'file_status', -1);

            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }

            fileLog($file->id, 'Rejection', 'AD (' . $assistantDirector->user->last_name . ') Rejected the file.', 0, $fileTypeName, '');
            LogActivity::addToLog('AD reject file', $file);

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->user_id,
                'Rejected "' . $file->industry_name . '"',
                $file->id
            );

            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ASSI_REJECT_FILE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function rejectFileAll(Request $request, MinutesRepository $minutesRepository, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $data = array();
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $msg = setFileStatus($file_id, 'file_status', -1);
            $c = new ClientRepository();
            $c->rejectionWorkingFileType($file);
            fileLog($file->id, 'Rejection', 'AD (' . $user->last_name . ') Rejected the file.', 0, 'reject file', '');
            LogActivity::addToLog('AD reject file', $file);
            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ASSI_REJECT_FILE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function directorRejectCertificate(Request $request, MinutesRepository $minutesRepository, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::with('environmentOfficer.assistantDirector')->whereId($file_id)->first();
            $msg = setFileStatus($file_id, 'file_status', 2);
            $msg = setFileStatus($file_id, 'cer_status', 1);

            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }

            fileLog($file->id, 'Rejection', 'Director (' . $user->last_name . ') Rejected the certificate.', 0, $fileTypeName, '');
            LogActivity::addToLog('Director reject certificate', $file);

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->assistantDirector->user_id,
                'Rejected"' . $file->industry_name . '"',
                $file_id
            );

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->user_id,
                'Rejected"' . $file->industry_name . '"',
                $file_id
            );

            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_Dire_REJECT_CERTIFICATE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function approveCertificate(Request $request, MinutesRepository $minutesRepository, $adId, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $adId, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $assistantDirector = AssistantDirector::with('user')->findOrFail($adId);
            $msg = setFileStatus($file_id, 'file_status', 4);
            $msg = setFileStatus($file_id, 'cer_status', 4);
            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }
            fileLog($file->id, 'Approval', 'AD (' . $assistantDirector->user->last_name . ') Approve the Certificate', 0, $fileTypeName, '');
            LogActivity::addToLog('AD Approve certificate', $file);

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->user_id,
                'Approve the Certificate"' . $file->industry_name . '"',
                $file_id
            );

            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ASSI_APPROVE_CERTIFICATE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function rejectCertificate(Request $request, MinutesRepository $minutesRepository, $adId, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $adId, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $data = array();
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $assistantDirector = AssistantDirector::with('user')->findOrFail($adId);
            $msg = setFileStatus($file_id, 'file_status', 2);
            $msg = setFileStatus($file_id, 'cer_status', 1);

            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }

            fileLog($file->id, 'Rejection', 'AD (' . $assistantDirector->user->last_name . ') Rejected the Certificate', 0, $fileTypeName, '');
            LogActivity::addToLog('AD Reject certificate', $file);

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->user_id,
                'Rejected the certificate for"' . $file->industry_name . '"',
                $file_id
            );

            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_ASSI_REJECT_CERTIFICATE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function directorHoldCertificate(Request $request, MinutesRepository $minutesRepository, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);

            $msg = setFileStatus($file_id, 'file_status', -2);
            $msg = setFileStatus($file_id, 'cer_status', -1);
            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }
            fileLog($file->id, 'Hold', 'Director (' . $user->last_name . ') hold the certificate.', 3, $fileTypeName, '');
            LogActivity::addToLog('Director Hold certificate', $file);

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->user_id,
                'Hold the certificate for"' . $file->industry_name . '"',
                $file_id
            );

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->assistantDirector->user_id,
                'Hold the certificate for"' . $file->industry_name . '"',
                $file_id
            );

            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_Dire_Hold_CERTIFICATE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function directorUnHoldCertificate(Request $request, MinutesRepository $minutesRepository, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);

            $msg = setFileStatus($file_id, 'file_status', 4);
            $msg = setFileStatus($file_id, 'cer_status', 4);
            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }

            fileLog($file->id, 'Hold', 'Director (' . $user->last_name . ') un hold the certificate.', 4, $fileTypeName, '');
            LogActivity::addToLog('Director um hold certificate', $file);

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->assistantDirector->user_id,
                'Un hold the certificate for"' . $file->industry_name . '"',
                $file_id
            );

            $this->userNotificationsRepositary->makeNotification(
                $file->environmentOfficer->user_id,
                'Un hold the certificate for"' . $file->industry_name . '"',
                $file_id
            );

            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_Dire_Hold_CERTIFICATE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function derectorApproveCertificate(Request $request, MinutesRepository $minutesRepository, $file_id)
    {
        return DB::transaction(function () use ($request, $minutesRepository, $file_id) {
            request()->validate([
                'minutes' => 'sometimes|required|string',
            ]);
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $file = Client::findOrFail($file_id);
            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }
            $msg = setFileStatus($file_id, 'file_status', 5);
            $msg = setFileStatus($file_id, 'cer_status', 5);
            fileLog($file->id, 'Approval', 'Director (' . $user->last_name . ') Approve the Certificate', 0, $fileTypeName, '');
            LogActivity::addToLog('Director approve certificate', $file);
            if ($request->has('minutes')) {
                $minutesRepository->save(prepareMinutesArray($file, $request->minutes, Minute::DESCRIPTION_Dire_APPROVE_CERTIFICATE, $user->id));
            }
            if ($msg) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }
}

//end calss
