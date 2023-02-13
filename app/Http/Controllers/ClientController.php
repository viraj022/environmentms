<?php

namespace App\Http\Controllers;

use App\EPL;
use App\Level;
use App\Client;
use App\Setting;
use Carbon\Carbon;
use App\Certificate;
use App\OldFiles;
use App\BusinessScale;
use App\ChangeOwner;
use App\Pradesheeyasaba;
use App\Rules\contactNo;
use App\IndustryCategory;
use App\Rules\nationalID;
use App\EnvironmentOfficer;
use App\Helpers\ClientApplicationHelper;
use Illuminate\Support\Str;
use App\Helpers\LogActivity;
use App\Http\Resources\ClientResource;
use App\Invoice;
use App\OnlineNewApplicationRequest;
use App\Repositories\UserNotificationsRepositary;
use App\SiteClearance;
use Illuminate\Http\Request;
use App\SiteClearenceSession;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Endroid\QrCode\Writer\PngWriter;

use Exception;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Label;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{

    private $userNotificationsRepositary;
    public function __construct(UserNotificationsRepositary $userNotificationsRepositary)
    {
        $this->userNotificationsRepositary = $userNotificationsRepositary;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('client_space', [
            'pageAuth' => $pageAuth,
            'newApplicationRequest' => null,
            'salutations' => $this->getSalutations(),
        ]);
    }

    public function getSalutations()
    {
        return ['-' => 'N/A', 'Mr' => 'Mr.', 'Mrs' => 'Mrs.', 'Ms' => 'Ms.', 'Miss' => 'Miss', 'Rev' => 'Rev'];
    }

    public function fromOnlineNewApplicationRequest(Request $request)
    {
        $newApplicationRequest = null;
        if ($request->has('new_application_request')) {
            $req = OnlineNewApplicationRequest::find($request->post('new_application_request'));
            if ($req) {
                $newApplicationRequest = $req;
            }
        }

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('client_space', [
            'pageAuth' => $pageAuth,
            'newApplicationRequest' => $newApplicationRequest,
            'salutations' => $this->getSalutations(),
        ]);
    }

    public function search_files()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('search_files', ['pageAuth' => $pageAuth]);
    }

    public function eo_locations()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('eo_locations', ['pageAuth' => $pageAuth]);
    }

    public function indexOldFileList()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('old_file_list', ['pageAuth' => $pageAuth]);
    }

    public function indexOldDataReg($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('old_data_registation', ['pageAuth' => $pageAuth, 'id' => $id]);
    }

    public function allClientsindex()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.industryFile'));
        if ($pageAuth['is_read']) {
            return view('industry_files', ['pageAuth' => $pageAuth]);
        } else {
            abort(401);
        }
    }

    public function index1($id)
    {
        if (!Auth::check()) {
            abort(401);
        }
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $client = Client::find($id);
        $oldOwnerDetails = ChangeOwner::where('client_id', $client->id)->orderBy('created_at', 'desc')->first();
        $onlineTransactions = Transaction::with('transactionItems')->whereNotNull('online_payment_id')->where('client_id', $id)->withTrashed()->get();
        $scCertificates = Certificate::where('certificate_type', 1)->where('client_id', $id)->where('issue_status', 1)->select('signed_certificate_path', 'issue_date', 'expire_date', 'cetificate_number')->get();

        $qrCode = $this->fileQr($client->file_no);
        if ($pageAuth['is_read']) {
            return view('industry_profile', [
                'pageAuth' => $pageAuth, 'id' => $id, 'client' => $client, 'qrCode' => $qrCode, 'oldOwnerDetails' => $oldOwnerDetails, 'onlineTransactions' => $onlineTransactions,
                'scCertificates' => $scCertificates
            ]);
        } else {
            abort(401);
        }
    }

    public function fileQr($fileCode)
    {
        $writer = new PngWriter();

        // Create QR code
        $qrCode = QRcode::create($fileCode)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(200)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        // Create generic label
        $label = Label::create($fileCode);

        // $result = $writer->write($qrCode, null, $label);
        $result = $writer->write($qrCode, null, null);

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        $dataUri = $result->getDataUri();
        return '<img src="' . $dataUri . '" />';
    }

    public function generateFileQrCode($id)
    {
        $client = Client::find($id);
        $qrCode = $this->fileQr($client->file_no);
        return $qrCode;
    }

    public function updateClient($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $CLIENT = Client::find($id);
        $FileCrateYear = carbon::parse($CLIENT->created_at)->format('Y');
        return view('update_industry_file', ['pageAuth' => $pageAuth, 'id' => $id, 'file_year' => $FileCrateYear]);
    }

    public function certificatesUi()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('pending_certificates', ['pageAuth' => $pageAuth]);
    }

    public function expireCertificatesUi()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('expired_certificates', ['pageAuth' => $pageAuth]);
    }

    public function confirmedFiles()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('confirmed_files', ['pageAuth' => $pageAuth]);
    }

    public function certificatePrefer($id)
    {
        $user = Auth::user();
        $cli = Client::where('id', $id)->first();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('certificate_perforation', ['pageAuth' => $pageAuth, 'id' => $id, 'cli' => $cli]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
            request()->validate([
                'first_name' => 'required|string',
                'last_name' => 'nullable|string',
                'address' => 'nullable',
                'contact_no' => ['nullable', new contactNo],
                'email' => 'nullable|sometimes',
                'nic' => ['sometimes', 'nullable', 'unique:clients', new nationalID],
                'industry_name' => 'required|string',
                'industry_category_id' => 'required|integer',
                'business_scale_id' => 'required|integer',
                'industry_contact_no' => ['nullable', new contactNo],
                'industry_address' => 'required|string',
                'industry_email' => 'nullable|email',
                'industry_coordinate_x' => ['numeric', 'required', 'between:-180,180'],
                'industry_coordinate_y' => ['numeric', 'required', 'between:-90,90'],
                'pradesheeyasaba_id' => 'required|integer',
                'industry_is_industry' => 'required|integer',
                'industry_investment' => 'required|numeric',
                'industry_start_date' => 'required|date',
                'industry_registration_no' =>  ['sometimes', 'nullable', 'string', 'unique:clients'],
                'is_old' => 'required|integer',
                'name_title' => 'required|string',
                'industry_sub_category' => 'nullable|string',
                // 'password' => 'required',
            ]);
            if ($pageAuth['is_create']) {
                $client = new Client();
                $client->name_title = \request('name_title');
                $client->first_name = \request('first_name');
                $client->last_name = \request('last_name');
                $client->address = \request('address');
                $client->contact_no = \request('contact_no');
                $client->email = \request('email');
                $client->nic = \request('nic');
                $client->password = Hash::make(request('nic'));
                $client->api_token = Str::random(80);

                $client->industry_name = \request('industry_name');
                $client->industry_category_id = \request('industry_category_id');
                $client->business_scale_id = \request('business_scale_id');
                $client->industry_contact_no = \request('industry_contact_no');
                $client->industry_address = \request('industry_address');
                $client->industry_email = \request('industry_email');
                $client->industry_coordinate_x = \request('industry_coordinate_x');
                $client->industry_coordinate_y = \request('industry_coordinate_y');
                $client->pradesheeyasaba_id = \request('pradesheeyasaba_id');
                $client->industry_is_industry = \request('industry_is_industry');
                $client->industry_investment = \request('industry_investment');
                $client->industry_start_date = \request('industry_start_date');
                $client->industry_registration_no = \request('industry_registration_no');
                $client->industry_sub_category = \request('industry_sub_category');
                $client->created_user = $user->id;
                $client->is_old = \request('is_old');
                if ($client->is_old == 0) {
                    $client->need_inspection = 'Inspection Not Needed';
                }
                $code = $this->generateCode($client);
                if (!$code || $code == null) {
                    return array('id' => 0, 'message' => 'Error Generating file code!');
                }
                $client->file_no = $code;
                $client->save();
                // dd($client->id);
                if ($client) {
                    // bind client id to new application request if this is a new application request entry
                    if ($request->new_application_request_id) {
                        // set client id to new application request
                        $newApplicationRequest = OnlineNewApplicationRequest::find($request->new_application_request_id);
                        $newApplicationRequest->client_id = $client->id;
                        $newApplicationRequest->status = 'complete'; // mark this as complete
                        $newApplicationRequest->save();

                        // import files from new application request to client profile
                        if (!empty($newApplicationRequest->road_map)) {
                            // import file 1/road map
                            $file1Filepath = $newApplicationRequest->road_map;
                            $file1FileName = basename($file1Filepath);
                            $file1FileUrl = config('online-request.url') . '/storage/new-attachments/route-map/' . str_replace('public/', '', $file1Filepath);
                            $targetDir = 'public/uploads/industry_files/' . $client->id . '/application/file1';

                            if (!Storage::exists($targetDir)) {
                                try {
                                    Storage::makeDirectory($targetDir);
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                            }
                            $targetFileName = $targetDir . '/' . $file1FileName;
                            $file1Path = ClientApplicationHelper::downloadFile($file1FileUrl);
                            try {
                                Storage::copy($file1Path, $targetFileName);
                                Storage::delete($file1Path);
                            } catch (\Throwable $th) {
                                throw $th;
                            }
                            $client->file_01 = 'storage/uploads/industry_files/' . $client->id . '/application/file1/' . $file1FileName;
                        }

                        if (!empty($newApplicationRequest->deed_of_land)) {
                            // import file 2/deed
                            $file2Filepath = $newApplicationRequest->deed_of_land;
                            $file2FileName = basename($file2Filepath);
                            $file2FileUrl = config('online-request.url') . '/storage/new-attachments/deed-of-lands/' . str_replace('public/', '', $file2Filepath);
                            $targetDir = 'public/uploads/industry_files/' . $client->id . '/application/file2';

                            if (!Storage::exists($targetDir)) {
                                try {
                                    Storage::makeDirectory($targetDir);
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                            }
                            $targetFileName = $targetDir . '/' . $file2FileName;
                            $file2Path = ClientApplicationHelper::downloadFile($file2FileUrl);
                            try {
                                Storage::copy($file2Path, $targetFileName);
                                Storage::delete($file2Path);
                            } catch (\Throwable $th) {
                                throw $th;
                            }
                            $client->file_02 = 'storage/uploads/industry_files/' . $client->id . '/application/file2/' . $file2FileName;
                        }

                        if (!empty($newApplicationRequest->survey_plan)) {
                            // import file 3/survey plan
                            $file3Filepath = $newApplicationRequest->survey_plan;
                            $file3FileName = basename($file3Filepath);
                            $file3FileUrl = config('online-request.url') . '/storage/new-attachments/survey-plans/' . str_replace('public/', '', $file3Filepath);
                            $targetDir = 'public/uploads/industry_files/' . $client->id . '/application/file3';

                            if (!Storage::exists($targetDir)) {
                                try {
                                    Storage::makeDirectory($targetDir);
                                } catch (\Throwable $th) {
                                    throw $th;
                                }
                            }
                            $targetFileName = $targetDir . '/' . $file3FileName;
                            $file3Path = ClientApplicationHelper::downloadFile($file3FileUrl);
                            try {
                                Storage::copy($file3Path, $targetFileName);
                                Storage::delete($file3Path);
                            } catch (\Throwable $th) {
                                throw $th;
                            }

                            $client->file_03 = 'storage/uploads/industry_files/' . $client->id . '/application/file3/' . $file3FileName;
                        }

                        $client->save();

                        // set online request for the new application request as complete
                        $onlineRequest = $newApplicationRequest->onlineRequest;
                        $onlineRequest->status = 'complete'; // mark this as complete
                        $onlineRequest->save();
                    }

                    LogActivity::fileLog($client->id, 'File', "Create New File", 1, 'new file', '');
                    LogActivity::addToLog('Create new file', $client);
                    return array('id' => 1, 'message' => 'true', 'id' => $client->id);
                } else {
                    return array('id' => 0, 'message' => 'false');
                }
            } else {
                abort(401);
            }
        } catch (Exception $ex) {
            if (isset($ex->validator)) {
                return array('id' => 0, 'message' => $ex->validator->errors());
            } else {
                return array('id' => 0, 'message' => $ex->getMessage());
            }
        }
    }

    private function generateCode($client)
    {
        $la = Pradesheeyasaba::find($client->pradesheeyasaba_id);
        // print_r($la);
        $lsCOde = $la->code;

        $industry = IndustryCategory::find($client->industry_category_id);
        $industryCode = $industry->code;
        $scale = BusinessScale::find($client->business_scale_id);
        $scaleCode = $scale->code;

        $e = Client::orderBy('id', 'desc')->first();
        if ($e === null) {
            $serial = 1;
        } else {
            $serial = $e->id;
        }
        $serial = sprintf('%02d', $serial);
        return "PEA/" . $lsCOde . "/" . $industryCode . "/" . $scaleCode . "/" . $serial . "/" . date("Y");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'name_title' => 'sometimes|required|string',
            'first_name' => 'sometimes|required|string',
            'last_name' => 'nullable|string',
            'address' => 'nullable',
            'contact_no' => ['nullable', new contactNo],
            'email' => 'nullable|sometimes',
            'nic' => ['nullable', 'unique:users,nic,' . $id, new nationalID],
            'industry_name' => 'sometimes|required|string',
            'industry_category_id' => 'sometimes|required|integer',
            'business_scale_id' => 'sometimes|required|integer',
            'industry_contact_no' => ['nullable', new contactNo],
            'industry_address' => 'sometimes|required|string',
            'industry_email' => 'nullable|email',
            'industry_coordinate_x' => ['sometimes', 'numeric', 'required', 'between:-180,180'],
            'industry_coordinate_y' => ['sometimes', 'numeric', 'required', 'between:-90,90'],
            'pradesheeyasaba_id' => 'sometimes|required|integer',
            'industry_is_industry' => 'sometimes|required|integer',
            'industry_investment' => 'sometimes|required|numeric',
            'industry_start_date' => 'sometimes|required|date',
            'industry_registration_no' => 'nullable|string',
            'is_old' => 'sometimes|required|integer',
            'industry_sub_category' => 'nullable|string',
            'file_no' => 'nullable|string'
            // 'password' => 'required',
        ]);
        if ($pageAuth['is_update']) {

            try {
                DB::beginTransaction();

                $msg = Client::where('id', $id)->update($request->all());
                $epl = Epl::where('client_id', $id)->orderBy('created_at', 'desc')->first();
                $site_clearsess = SiteClearenceSession::where('client_id', $id)->first();

                //load and split new file no to generate new epl code
                $splited_file_no = explode("/", $request->file_no);

                if (count($splited_file_no) != 6) {
                    return array('id' => 0, 'message' => 'Previous file number format is not correct');
                }

                if ($epl != null) {
                    //load and split previous epl no to generate new epl no for epl code
                    $splited_epl_no_prev = explode("/", $epl->code);
                    if (count($splited_epl_no_prev) != 7) {
                        return array('id' => 0, 'message' => 'Previous EPL number is not correct');
                    }

                    $new_epl_no = $splited_epl_no_prev[5] . '/' . $splited_epl_no_prev[6];
                    $epl->code = 'PEA/' . $splited_file_no[1] . '/EPL/' . $splited_file_no[2] . '/' . $splited_file_no[3] . '/' . $new_epl_no;
                    $epl->save();
                }

                if ($site_clearsess != null) {
                    //update the site clearence code
                    $splited_site_no_prev = explode("/", $site_clearsess->code);
                    if (count($splited_site_no_prev) != 7) {
                        return array('id' => 0, 'message' => 'Previous site clearence number is not correct');
                    }
                    $new_site_no = $splited_site_no_prev[5] . '/' . $splited_site_no_prev[6];
                    $site_clearsess->code = 'PEA/' . $splited_file_no[1] . '/SC/' . $splited_file_no[2] . '/' . $splited_file_no[3] . '/' . $new_site_no;
                    $site_clearsess->save();
                }

                DB::commit();
                LogActivity::fileLog($id, 'File', "Update file", 1, 'update file', '');
                LogActivity::addToLog('Update file', $msg);
                return array('id' => 1, 'message' => 'File Number, EPL Number, Site clearence Number has updated successful');
            } catch (\Exception $ex) {
                DB::rollBack();
                return array('id' => 0, 'message' => 'File Number, EPL Number, Site clearence Number update is unsuccessful');
            }
        } else {
            abort(401);
        }
    }

    public function getClientById($id)
    {
        return Client::findOrFail($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            return Client::get();
        } else {
            abort(401);
        }
    }

    public function oldFilesCountByDate()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_read']) {
            $oldFilesList = Client::selectRaw("COUNT(*) count, DATE_FORMAT(created_at, '%Y %m %e') date")
                ->where('is_old', '0')
                ->Orwhere('is_old', '2')
                ->groupBy('date')
                ->orderBy('created_at', 'ASC')
                //                    ->toSql();
                ->get();

            return $oldFilesList;
        } else {
            abort(401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        if ($pageAuth['is_delete']) {
            $client = Client::findOrFail($id);
            $msg = $client->delete();
            if ($msg) {
                $msg1 = EPL::where('client_id', $id)->delete();
            }
            LogActivity::addToLog("Delete fIle", $client);
            LogActivity::fileLog($client->id, 'File', "Delete file", 1, 'delete file', '');
            if ($msg1) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } else {
            abort(401);
        }
    }

    public function findClient_by_nic($nic)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        //    PaymentType::get();
        return Client::with('epls')->with('oldFiles')->where('nic', '=', $nic)
            ->get();
    }

    public function findClient_by_id($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        //    PaymentType::get();
        $file = Client::with('epls')->with('siteClearenceSessions.siteClearances')
            ->with('environmentOfficer.user')
            ->with('oldFiles')
            ->with('industryCategory')
            ->with('businessScale')
            ->with('certificates')
            ->with('pradesheeyasaba')->find($id)->toArray();
        $file['created_at'] = date('Y-m-d', strtotime($file['created_at']));
        $file['industry_start_date'] = date('Y-m-d', strtotime($file['industry_start_date']));
        // dd($ref);
        return $file;
    }

    public function getAllFiles($id)
    {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $data = Client::with(['epls' => function ($query) {
            $query->orderBy('submitted_date', 'desc');
        }, 'siteClearenceSessions', 'siteClearenceSessions.siteClearances' => function ($query) {
            $query->orderBy('submit_date', 'desc');
        }]);
        // ->leftJoin('e_p_l_s', 'clients.id', '=', 'e_p_l_s.client_id')
        // ->leftJoin('site_clearence_sessions', 'clients.id', '=', 'site_clearence_sessions.client_id')
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data->where('environment_officer_id', $id);
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data->where('environment_officer_id', $id);
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data->where('environment_officer_id', $envOfficer->id);
            } else {
                abort(404);
            }
        } else {
            abort(401);
        }
        // $data->where('id', 592);
        // $data->groupBy('clients.id');
        $data = $data->get();
        // return $data;
        // dd($data->toArray());
        return clientResource::collection($data);
    }

    public function certificatePath($id)
    {
        $client = Client::findOrFail($id);
        return Certificate::where('client_id', $client->id)->orderBy('id', 'desc')->first();
    }

    public function workingFiles($id)
    {
        return array('id' => 'API removed contact hansana');
        // $data = array();
        // $user = Auth::user();
        // $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        // if ($user->roll->level->name == Level::DIRECTOR) {
        //     $data = Client::where('environment_officer_id', $id)->where('is_working', 1)->get();
        // } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
        //     $data = Client::where('environment_officer_id', $id)->where('is_working', 1)->get();
        // } else if ($user->roll->level->name == Level::ENV_OFFICER) {
        //     $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
        //     if ($envOfficer) {
        //         $data = Client::where('environment_officer_id', $user->id)->where('is_working', 1)->get();
        //     } else {
        //         abort(404);
        //     }
        // } else {
        //     abort(401);
        // }
        // //    Client::where()
        // return $data;
    }

    public function newlyAssigned($id)
    {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)->get();
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)->get();
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data = Client::where('environment_officer_id', $envOfficer->id)->get();
            }
        } else {
            abort(401);
        }

        return $data;
    }

    public function inspection_needed_files($id)
    {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)
                ->where('need_inspection', Client::STATUS_INSPECTION_NEEDED)
                ->get();
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = Client::where('environment_officer_id', $id)
                ->where('need_inspection', Client::STATUS_INSPECTION_NEEDED)
                ->get();
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data = Client::where('environment_officer_id', $envOfficer->id)
                    ->where('need_inspection', Client::STATUS_INSPECTION_NEEDED)
                    ->get();
            }
        } else {
            abort(401);
        }
        return $data;
    }

    public function inspection_pending_needed_files($id)
    {
        $data = array();
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($user->roll->level->name == Level::DIRECTOR) {
            $data = Client::with('inspectionSessions')->whereHas('inspectionSessions', function ($sql) {
                return $sql->where('inspection_sessions.status', '=', 0);
            })->where('environment_officer_id', $id)
                ->where('need_inspection', Client::STATUS_PENDING)
                ->get();
        } else if ($user->roll->level->name == Level::ASSI_DIRECTOR) {
            $data = Client::with('inspectionSessions')->whereHas('inspectionSessions', function ($sql) {
                return $sql->where('inspection_sessions.status', '=', 0);
            })->where('environment_officer_id', $id)
                ->where('need_inspection', Client::STATUS_PENDING)
                ->get();
        } else if ($user->roll->level->name == Level::ENV_OFFICER) {
            $envOfficer = EnvironmentOfficer::where('user_id', $user->id)->where('active_status', 1)->first();
            if ($envOfficer) {
                $data = Client::with('inspectionSessions')->whereHas('inspectionSessions', function ($sql) {
                    return $sql->where('inspection_sessions.status', '=', 0);
                })->where('environment_officer_id', $envOfficer->id)
                    ->where('need_inspection', Client::STATUS_PENDING)
                    ->get();
            }
        } else {
            abort(401);
        }
        return $data;
    }

    public function getOldFiles($count)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        if ($count == -1) {
            return Client::where('is_old', 0)->with('epls')->with('oldFiles')->orderBy('id', 'desc')->get();
        } else {
            return Client::where('is_old', 0)->with('epls')->with('oldFiles')->take($count)->orderBy('id', 'desc')->get();
        }
        //        return Client::where('is_old', 0)->with('epls')->with('oldFiles')->orderBy('id', 'desc')->get();
    }

    public function markOldFinish($id)
    {
        return DB::transaction(function () use ($id) {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $client = Client::find($id);
            $this->generateCertificateForOldData($client, $user);
            $client->is_old = 2; // inspected state
            $client->file_status = 5; // set file status
            $client->cer_status = 6; // set certificate status
            LogActivity::addToLog("Old file complete" . $id, $client);
            LogActivity::fileLog($client->id, 'File', "Old file complete", 1, 'old file complete', '');
            if ($client->save()) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function markOldUnfinish($id)
    {
        return DB::transaction(function () use ($id) {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
            $client = Client::find($id);
            $client->is_old = 0; // inspected state
            $client->file_status = 0; // set file status
            $client->cer_status = 0; // set certificate status
            $client->save();
            $certificate = DB::table('certificates')
                ->where('client_id', '=', $id)
                ->delete();
            LogActivity::addToLog("Old file confirm revert" . $id, $client);
            LogActivity::fileLog($client->id, 'File', "Old file confirm revert", 1, 'old file revert', '');
            if ($client == true) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        });
    }

    public function generateCertificateForOldData(Client $client, $user)
    {
        $epls = $client->epls;
        $siteClearances = $client->siteClearenceSessions;
        foreach ($epls as $epl) {
            $cer = Certificate::where('cetificate_number', $epl->certificate_no);
            if (!$cer) {
                $certificate = new Certificate();
                $certificate->client_id = $epl->client_id;
                $certificate->cetificate_number = $epl->certificate_no;
                $certificate->issue_date = $epl->issue_date;
                $certificate->expire_date = $epl->expire_date;
                $certificate->signed_certificate_path = $epl->path;
                $certificate->certificate_type = 0;
                $certificate->issue_status = 1;
                $certificate->user_id = $user->id;
                $certificate->save();
            }
        }

        foreach ($siteClearances as $siteClearance) {
            $sites = $siteClearance->siteClearances;
            foreach ($sites as $site) {
                $cer = Certificate::where('cetificate_number', $siteClearance->code);
                if (!$cer) {
                    $certificate = new Certificate();
                    $certificate->client_id = $siteClearance->client_id;
                    $certificate->cetificate_number = $siteClearance->code;
                    $certificate->issue_date = $site->issue_date;
                    $certificate->expire_date = $site->expire_date;
                    $certificate->signed_certificate_path = $site->certificate_path;
                    $certificate->certificate_type = 1;
                    $certificate->issue_status = 1;
                    $certificate->user_id = $user->id;
                    $certificate->save();
                }
            }
        }
    }

    public function getOldFilesDetails($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::where('is_old', 0)->where('id', $id)->first();
        if ($client) {
            $epls = $client->epls;
            if (count($epls) > 0) {
                return $client->epls[0];
            } else {
                return $epls;
            }
        } else {
            abort(404);
        }
    }

    public function getOldSiteClearanceData($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::where('is_old', 0)->where('id', $id)->first();
        if ($client) {
            $siteClearance = $client->siteClearenceSessions;
            if (count($siteClearance) > 0) {
                $siteClearanceSession = $client->siteClearenceSessions[0];
                $siteClearanceSession->site_clearances = $siteClearanceSession->siteClearances[0];
                return $siteClearanceSession;
            } else {
                return $siteClearance;
            }
        } else {
            abort(404);
        }
    }

    public function markInspection($inspectionNeed, $id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
        $client = Client::findOrFail($id);
        if ($inspectionNeed == 'needed') {
            LogActivity::fileLog($client->id, 'Inspection', "Mark inspection needed", 1, 'inspection', '');
            LogActivity::addToLog("Mark inspection needed", $client);
            $client->need_inspection = CLIENT::STATUS_INSPECTION_NEEDED;
        } else if ($inspectionNeed == 'no_needed') {
            LogActivity::fileLog($client->id, 'Inspection', "Mark inspection no need", 1, 'inspection', '');
            LogActivity::addToLog("Mark inspection no need", $client);
            $client->need_inspection = CLIENT::STATUS_INSPECTION_NOT_NEEDED;
        } else {
            abort(422);
        }
        if ($client->save()) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function file_problem_status($id, Request $request)
    {
        try {
            $user = Auth::user();
            $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
            request()->validate([
                'file_problem_status' => ['required', 'regex:(pending|clean|problem)'],
                'file_problem_status_description' => 'required|string',
                'file' => $request->file != null ? 'sometimes|required|min:8' : ''
            ]);

            $file = Client::findOrFail($id);
            // if (!($request->file == null || isset($request->file))) {
            //     $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            //     $fileUrl = '/uploads/' . FieUploadController::getOldFilePath($file);
            //     $storePath = 'public' . $fileUrl;
            //     $path = $request->file('file')->storeAs($storePath, $file_name);
            //     $oldFiles = new OldFiles();
            //     $oldFiles->path = "storage" . $fileUrl . "/" . $file_name;
            //     $oldFiles->type = $request->file->extension();
            //     $oldFiles->client_id = $file->id;
            //     $oldFiles->description = \request('description');
            //     $oldFiles->file_catagory = \request('file_catagory');
            //     $file->complain_attachment = "storage" . $fileUrl . "/" . $file_name;
            //     $msg = $oldFiles->save();
            // }
            if (\request('file_problem_status') == 'clean') {
                $file->complain_attachment = null;
            }
            $file->file_problem_status = \request('file_problem_status');
            $file->file_problem_status_description = \request('file_problem_status_description');
            $file_type = $file->cer_type_status;
            if ($file_type == 1 || $file_type == 2) {
                $fileTypeName = 'epl';
            } elseif ($file_type == 3 || $file_type == 4) {
                $fileTypeName = 'sc';
            } else {
                $fileTypeName = '';
            }
            LogActivity::fileLog($file->id, 'File', "set File problem status " . $file->file_problem_status, 1, $fileTypeName, '');
            LogActivity::addToLog("Mark file problem status", $file);
            if ($file->save()) {
                return array('id' => 1, 'message' => 'true');
            } else {
                return array('id' => 0, 'message' => 'false');
            }
        } catch (Exception $ex) {
            return array('id' => 0, 'message' => 'false');
        }
    }

    //    public function file_problem_status($id) {
    //        $user = Auth::user();
    //        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
    //        request()->validate([
    //            'file_problem_status' => ['required', 'regex:(pending|clean|problem)'],
    //            'file_problem_status_description' => 'required|string',
    //            'file' => 'mimes:jpeg,jpg,png,pdf'
    //        ]);
    //
    //        $file = Client::findOrFail($id);
    //        $file->file_problem_status = \request('file_problem_status');
    //        $file->file_problem_status_description = \request('file_problem_status_description');
    //        $file->file = \request('file_problem_status_description');
    //        LogActivity::fileLog($file->id, 'File', "set File problem status " . $file->file_problem_status, 1);
    //        LogActivity::addToLog("Mark file problem status", $file);
    //        if ($file->save()) {
    //            return array('id' => 1, 'message' => 'true');
    //        } else {
    //            return array('id' => 0, 'message' => 'false');
    //        }
    //    }

    public function changeFileStatus($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        request()->validate([
            'status_type' => 'required|string',
            'status_code' => 'required|string',
            'status_value' => 'nullable|string',
        ]);
        if (setFileStatus($id, \request('status_type'), \request('status_code'), \request('status_value'))) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function getDirectorPendingList()
    {
        return Client::getFileByStatusQuery('file_status', array(-2, 4, 6))->get();
    }

    public function getDirectorApprovedList()
    {
        return Client::where('file_status', '=', 5)->where('cer_status', '=', 5)->with('epls')->get();
    }

    public function getAssistanceDirectorPendingList($id)
    {
        return Client::getFileByStatusQuery('file_status', array(1, 3))->whereHas('environmentOfficer.assistantDirector', function ($query) use ($id) {
            $query->where('assistant_directors.id', $id);
        })->get();
    }

    public function getEnvironmentOfficerPendingList($id)
    {
        return Client::getFileByStatusQuery('file_status', array(0))->whereHas('environmentOfficer', function ($query) use ($id) {
            $query->where('environment_officers.id', $id);
        })->get();
    }

    public function getCertificateDraftingList($status)
    {
        return Client::getFileByStatusQuery('file_status', array(2))->where('cer_type_status', '!=', 0)->where('cer_status', $status)->get();
    }

    public function nextCertificateNumber($id)
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $client = Client::findOrFail($id);
        $certificate = new Certificate();

        if ($client->cer_type_status == 1 || $client->cer_type_status == 2) {
            //epl certificate
            $certificate->certificate_type = 0;
        } elseif ($client->cer_type_status == 3 || $client->cer_type_status == 4) {
            $certificate->certificate_type = 1;
        }
        $certificate->cetificate_number = $client->generateCertificateNumber();

        $certificate->client_id = $client->id;
        $certificate->issue_status = 0;
        $certificate->user_id = $user->id;
        $msg = $certificate->save();
        if ($client->cer_type_status == 1) {
            incrementSerial(Setting::CERTIFICATE_AI);
        }
        $file_type = $client->cer_type_status;
        if ($file_type == 1 || $file_type == 2) {
            $fileTypeName = 'epl';
        } elseif ($file_type == 3 || $file_type == 4) {
            $fileTypeName = 'sc';
        } else {
            $fileTypeName = '';
        }
        setFileStatus($client->id, 'cer_status', 1);
        fileLog($client->id, 'Certificate', 'User (' . $user->last_name . ') Start drafting', 0, $fileTypeName, '');
        LogActivity::addToLog("Start certificate drafting", $client);
        if ($msg) {
            return array('id' => 1, 'message' => 'true', 'certificate_number' => $certificate->cetificate_number);
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function getCertificateDetails($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        $client = Client::findOrFail($id);
        $certificate = Certificate::with('client')->where('client_id', $client->id)->where('issue_status', 0)->orderBy('id', 'desc')->first();
        if (!$certificate) {
            return array();
        } else {
            $certificate->issue_date = ($certificate->issue_date != null) ? Carbon::parse($certificate->issue_date)->format('Y-m-d') : date('Y-m-d');
            return $certificate;
        }
    }

    public function uploadCertificate(Request $request, $id)
    {
        request()->validate([
            'issue_date' => 'sometimes|required|date',
            'expire_date' => 'sometimes|required|date',
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf,doc,docx'
        ]);
        $user = Auth::user();
        $req = request()->all();
        unset($req['file']);
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        if ($request->exists('file')) {
            $type = $request->file->extension();
            $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            $fileUrl = "/uploads/industry_files/" . $certificate->client_id . "/certificates/draft/" . $id;
            $storePath = 'public' . $fileUrl;
            $path = 'storage' . $fileUrl . "/" . $file_name;
            $request->file('file')->storeAs($storePath, $file_name);
            $req['user_id_certificate_upload'] = $user->id;
            $req['certificate_upload_date'] = Carbon::now()->toDateString();
            $req['certificate_path'] = $path;
        } else {
            abort(422, "file key not found , ctech validation");
        }
        $msg = Certificate::where('id', $id)->update($req);

        fileLog($certificate->client_id, 'certificate', 'User (' . $user->last_name . ') uploaded draft', 0, 'upload draft', '');
        LogActivity::addToLog("Upload Draft", $certificate);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function uploadCorrectedFile(Request $request, $id)
    {
        request()->validate([
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf,doc,docx'
        ]);
        $user = Auth::user();
        $req = request()->all();
        unset($req['file']);
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        if ($request->exists('file')) {
            $type = $request->file->extension();
            $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            $fileUrl = "/uploads/industry_files/" . $certificate->client_id . "/certificates/draft/" . $id;
            $storePath = 'public' . $fileUrl;
            $path = 'storage' . $fileUrl . "/" . $file_name;
            $request->file('file')->storeAs($storePath, $file_name);
            $req['user_id_certificate_upload'] = $user->id;
            $req['corrected_file'] = $path;
        } else {
            abort(422, "file key not found , ctech validation");
        }
        $msg = Certificate::where('id', $id)->update($req);

        fileLog($certificate->client_id, 'certificate', 'User (' . $user->last_name . ') uploaded draft', 0, 'upload draft', '');
        LogActivity::addToLog("Upload Corrected File", $certificate);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function uploadOriginalCertificate($id, Request $request)
    {
        request()->validate([
            'issue_date' => 'sometimes|required|date',
            'expire_date' => 'sometimes|required|date',
            'file' => 'sometimes|required|mimes:jpeg,jpg,png,pdf'
        ]);
        $user = Auth::user();
        $req = request()->all();
        unset($req['file']);
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        if ($request->exists('file')) {
            $type = $request->file->extension();
            $file_name = Carbon::now()->timestamp . '.' . $request->file->extension();
            $fileUrl = "/uploads/industry_files/" . $certificate->client_id . "/certificates/original/" . $id;
            $storePath = 'public' . $fileUrl;
            $path = 'storage' . $fileUrl . "/" . $file_name;
            $request->file('file')->storeAs($storePath, $file_name);
            $req['signed_certificate_path'] = $path;
            $req['user_id_certificate_upload'] = $user->id;
        } else {
            abort(422, "file key not found , ctech validation");
        }
        $msg = Certificate::where('id', $id)->update($req);

        fileLog($certificate->client_id, 'certificate', 'User (' . $user->user_name . ')  uploaded the original', 0, 'upload original certificate', '');
        LogActivity::addToLog("Upload original", $certificate);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function issueCertificate(Request $request, $cer_id)
    {

        $issue_date = Carbon::parse($request->issue_date)->format('Y-m-d');
        $expire_date = Carbon::parse($request->expire_date)->format('Y-m-d');
        if (empty($request->issue_date) || empty($request->expire_date)) {
            return array('id' => 0, 'message' => 'issue date and expire date are required');
        }
        if ($issue_date >= $expire_date) {
            return array('id' => 0, 'message' => 'issue date must be less than expire date');
        }
        try {
            return DB::transaction(function () use ($cer_id, $issue_date, $expire_date) {
                $user = Auth::user();
                $pageAuth = $user->authentication(config('auth.privileges.environmentOfficer'));
                $certificate = Certificate::findOrFail($cer_id);
                if ($certificate->issue_status == 0) {
                    $file = Client::findOrFail($certificate->client_id);
                    $msg = setFileStatus($file->id, 'file_status', 5);
                    $msg = $msg && setFileStatus($file->id, 'cer_status', 6);
                    $certificate->issue_status = 1;
                    $certificate->issue_date = $issue_date;
                    $certificate->expire_date = $expire_date;
                    $certificate->updated_at = Carbon::now();
                    $certificate->user_id = $user->id;
                    $msg = $msg && $certificate->save();
                    $file = $certificate->client;

                    // check if => 1=new epl, 2=epl renew
                    if ($file->cer_type_status == 1 || $file->cer_type_status == 2) {
                        $epl = EPL::where('client_id', $certificate->client_id)->whereNull('issue_date')->where('status', 0)->first();
                        $epl->issue_date = $issue_date;
                        $epl->expire_date = $expire_date;
                        $epl->certificate_no = $certificate->cetificate_number;
                        $epl->status = 1;
                        $msg = $msg && $epl->save();

                        //check if 3=site clearance
                    } else if ($file->cer_type_status == 3) {
                        $site = SiteClearenceSession::where('client_id', $certificate->client_id)->whereNull('issue_date')->first();
                        $site->issue_date = $issue_date;
                        $site->expire_date = $expire_date;
                        $site->licence_no = $certificate->cetificate_number;
                        $site->status = 1;

                        $s = SiteClearance::where('site_clearence_session_id', $site->id)->where('status', 0)->first();
                        $s->status = 1;
                        $s->issue_date = $issue_date;
                        $s->expire_date = $expire_date;
                        $msg = $msg && $s->save();
                        $msg = $msg && $site->save();

                        //                            check if 4=site clearance renew
                    } else if ($file->cer_type_status == 4) {
                        $site = SiteClearenceSession::where('client_id', $certificate->client_id)->orderBy('id', 'desc')->first();
                        $site->issue_date = $issue_date;
                        $site->expire_date = $expire_date;
                        $site->status = 1; //status already 1
                        $site->save();
                        $s = SiteClearance::where('site_clearence_session_id', $site->id)->where('status', 0)->orderBy('id', 'desc')->first();
                        $s->status = 1;
                        $s->issue_date = $issue_date;
                        $s->expire_date = $expire_date;
                        $s->save();
                    } else {
                        abort(501, "Invalid File Status - error code");
                    }
                } else {
                    abort(422, "Certificate Already Issued");
                }

                $file_type = $file->cer_type_status;
                if ($file_type == 1 || $file_type == 2) {
                    $fileTypeName = 'epl';
                } elseif ($file_type == 3 || $file_type == 4) {
                    $fileTypeName = 'sc';
                } else {
                    $fileTypeName = '';
                }

                fileLog($file->id, 'certificate', 'User (' . $user->last_name . ') Issued the Certificate', 0, $fileTypeName, '');
                LogActivity::addToLog("Issue certificate", $certificate);
                return array('id' => 1, 'message' => 'Successfully Issued Certificate');
            });
        } catch (\Throwable $th) {
            return array('id' => 0, 'message' => 'Unable to issue certificate');
        }
    }

    public function completeDraftingCertificate($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::with('client.environmentOfficer')->whereId($id)->first();
        $client = $certificate->client;
        // dd($client);

        $file_type = $client->cer_type_status;
        if ($file_type == 1 || $file_type == 2) {
            $fileTypeName = 'epl';
        } elseif ($file_type == 3 || $file_type == 4) {
            $fileTypeName = 'sc';
        } else {
            $fileTypeName = '';
        }

        $msg = setFileStatus($certificate->client_id, 'cer_status', 2);
        fileLog($certificate->client_id, 'certificate', 'User (' . $user->first_name . ' ' . $user->last_name . ') complete draft', 0, $fileTypeName, '');
        LogActivity::addToLog("Complete draft", $certificate);
        $this->userNotificationsRepositary->makeNotification(
            $client->environmentOfficer->user_id,
            'Certificate Drafted for "' . $client->industry_name . '"',
            $certificate->client_id
        );
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }

    public function completeCertificate($id)
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $certificate = Certificate::findOrFail($id);
        // $certificate->issue_status = 1;
        // $certificate->save();
        $file = Client::findOrFail($certificate->client_id);
        $msg = setFileStatus($certificate->client_id, 'file_status', 5);
        // $msg = setFileStatus($certificate->client_id, 'cer_status', 5);
        fileLog($certificate->client_id, 'certificate', 'User (' . $user->user_name . ') complete certificate', 0, 'complete certificate', '');
        LogActivity::addToLog("Complete certificate", $certificate);
        if ($msg) {
            return array('id' => 1, 'message' => 'true');
        } else {
            return array('id' => 0, 'message' => 'false');
        }
    }


    //end to get expired certificates and certificates that expired within a month by env officer id

    public function getExpiredCertificates(Request $request)
    { //to all get expired certificates and certificates that expired within a month by env officer id
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        $ad_id = $request->input('ad_id');
        $date = Carbon::now();
        $date = $date->addDays(30);

        if ($pageAuth['is_read']) {
            $q = "SELECT
            e_p_l_s.id,
            e_p_l_s.client_id,
            e_p_l_s.expire_date,
            e_p_l_s.`code`,
            clients.industry_name,
	        clients.contact_no,
            clients.file_no,
            e_p_l_s.certificate_no,
            pradesheeyasabas.`name` AS pradesheeyasaba_name,
            (SELECT COUNT( warning_letters.id ) FROM warning_letters WHERE warning_letters.client_id = e_p_l_s.client_id ) AS warning_count,
	        (SELECT MAX(warning_letters.id) FROM warning_letters WHERE warning_letters.client_id = e_p_l_s.client_id ) AS last_letter
        FROM e_p_l_s
            INNER JOIN clients ON e_p_l_s.client_id = clients.id
            INNER JOIN pradesheeyasabas ON clients.pradesheeyasaba_id = pradesheeyasabas.id";
            if (isset($ad_id)) {
                $q .= " INNER JOIN environment_officers ON clients.environment_officer_id = environment_officers.id";
            }
            $q .= " WHERE e_p_l_s.id IN (
                SELECT  MAX( e_p_l_s.id )
                FROM  e_p_l_s
                GROUP BY  e_p_l_s.client_id )";
            if (isset($ad_id)) {
                $q .= " AND environment_officers.assistant_director_id = {$ad_id}";
            }
            $q .= " AND clients.deleted_at IS NULL";
            $q .= " AND clients.file_status = 5 HAVING DATE( e_p_l_s.expire_date ) < '{$date}'
            AND e_p_l_s.expire_date IS NOT NULL";
            $responses = \DB::select($q);
            foreach ($responses as &$res) {
                $res->due_date = Carbon::parse($res->expire_date)->diffForHumans();
                $res->expire_date = Carbon::parse($res->expire_date)->format('Y-m-d');
            }

            return $responses;
        } else {
            abort(401);
        }
    }

    public function getCofirmedFiles()
    { //to all get all active files
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        $client = Client::where('is_old', 2)->get();
        return $client;
    }

    public function get_file_cordinates($industry_cat_id, $eo_id)
    {
        $file_cords = \DB::table('clients')
            ->select('clients.industry_coordinate_x', 'clients.industry_coordinate_y', 'clients.file_no')
            ->where('clients.environment_officer_id', '=', $eo_id)
            ->where('clients.industry_category_id', '=', $industry_cat_id)
            ->get()->toArray();
        //                ->toSql();
        //        dd($file_cords);
        $locations = collect($file_cords)->map(function ($name) {
            return array($name->file_no, $name->industry_coordinate_x, $name->industry_coordinate_y);
        });
        // dd($file_cords);
        return $locations;
    }



    public function server_side_process(Request $request)
    {
        $columns = array(
            0 => 'id',
            1 => 'file_no',
            2 => 'first_name',
            3 => 'industry_name',
            4 => 'industry_registration_no',
            5 => 'certificate_number',
            6 => 'industry_address'
        );
        $totalData = Client::where('deleted_at', '=', null)->where('is_old', '!=', 0)->count();

        $totalFiltered = $totalData;
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if (empty($request->input('search.value'))) {
            $clients = Client::with('certificates', 'epls')->where('is_old', '!=', 0)
                ->offset($start)
                ->limit($limit)
                ->orderBy($order, $dir)
                ->get();
        } else {
            $search = $request->input('search.value');
            $clients = Client::with('certificates', 'epls')
                ->where('is_old', '!=', 0)
                //                    ->orWhere('id', 'LIKE', "%{$search}%")
                ->Where('file_no', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('industry_registration_no', 'LIKE', "%{$search}%")
                ->orWhere('industry_name', 'LIKE', "%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy('clients.' . $order, $dir)
                ->get();
            // dd($clients);
            $totalFiltered = Client::with('certificates', 'epls')->where('is_old', '!=', 0)
                //                    ->orWhere('id', 'LIKE', "%{$search}%")
                ->Where('file_no', 'LIKE', "%{$search}%")
                ->orWhere('first_name', 'LIKE', "%{$search}%")
                ->orWhere('industry_registration_no', 'LIKE', "%{$search}%")
                ->orWhere('industry_name', 'LIKE', "%{$search}%")
                ->count();
        }
        $data = array();
        if (!empty($clients)) {
            //            print_r($clients);
            //            exit;
            foreach ($clients as $client) {
                //                $show =  route('posts.show',$post->id);
                //                $edit =  route('posts.edit',$post->id);
                $cert = $client->certificates->first();
                $epl_cert = !empty($client->epls->first()) ? $client->epls->first() : '';
                // dump($client->id);
                // dd($cert->cetificate_number);
                $nestedData['id'] = $client->id;
                $nestedData['file_no'] = $client->file_no;
                $nestedData['client_name'] = $client->first_name . $client->last_name;
                $nestedData['industry_name'] = $client->industry_name;
                $nestedData['industry_registration_no'] = $client->industry_registration_no;
                $nestedData['certificate_number'] = !empty($cert) ? $cert->cetificate_number : (empty($epl_cert) ? '' : $epl_cert->certificate_no);
                $nestedData['industry_address'] = $client->industry_address;
                //                $nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
                //                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
                //                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' ><span class='glyphicon glyphicon-list'></span></a>
                //                                          &emsp;<a href='{$edit}' title='EDIT' ><span class='glyphicon glyphicon-edit'></span></a>";
                $data[] = $nestedData;
            }
        }
        $json_data = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data
        );
        echo json_encode($json_data);
    }

    public function eo_client_data(Request $request)
    {
        $prs = $request->pradeshiya_sabha;
        $ind_cat = $request->industry_category;
        $prs_check = $request->pradeshiya_sabha_check;
        $ind_cat_check = $request->industry_category_check;
        $client_data = null;

        if ($prs_check == 'on' && $ind_cat_check != 'on') {
            $client_data = Client::where('pradesheeyasaba_id', '=', $prs)
                ->join('e_p_l_s', 'clients.id', 'e_p_l_s.client_id')
                ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
                ->get();
        }
        if ($prs_check != 'on' && $ind_cat_check == 'on') {
            $client_data = Client::leftjoin('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
                ->leftjoin('e_p_l_s', 'clients.id', 'e_p_l_s.client_id')
                ->where('industry_category_id', '=', $ind_cat)
                ->get();
        }
        if ($prs_check == 'on' && $ind_cat_check == 'on') {
            $client_data = Client::where('pradesheeyasaba_id', '=', $prs)
                ->Where('industry_category_id', '=', $ind_cat)
                ->join('e_p_l_s', 'clients.id', 'e_p_l_s.client_id')
                ->join('industry_categories', 'clients.industry_category_id', 'industry_categories.id')
                ->get();
        }
        return $client_data;
    }

    public function expiredEplView()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('Reports.expired_epl', ['pageAuth' => $pageAuth]);
    }

    public function getExpiredEpl(Request $request)
    {

        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));

        $date = Carbon::now();
        $formatted_date = $date->addDays(30)->format('Y-m-d');

        $is_checked = $request->ad_check;
        $ad_id = $request->ad_id;

        $responses = EPL::selectRaw('MAX(id), client_id, expire_date')
            ->With(['client.pradesheeyasaba'])
            ->whereHas('Client', function ($query) {
                $query->where('clients.file_status', '!=', 0);
            });
        // ->selectRaw('max(id) as id, client_id, expire_date,cetificate_number, certificate_type')

        $responses->when($is_checked == 'on', function ($q) use ($ad_id) {
            return $q->whereHas('Client.environmentOfficer.assistantDirector', function ($query) use ($ad_id) {
                $query->where('assistant_directors.id', '=', $ad_id);
            });
        });

        $responses = $responses->having('expire_date', '<', $formatted_date)
            ->havingRaw('`expire_date` IS NOT NULL')
            ->groupBy('client_id')
            ->get();
        return view('Reports.expired_epl', ["data" => $responses, "pageAuth" => $pageAuth]);
    }

    public function getPendingExpiredCertificates(Request $request)
    {
        $is_checked = $request->is_checked;
        $ad_id = $request->id;
        $responses = EPL::With(['client.pradesheeyasaba', 'client.environmentOfficer.user']);
        // ->selectRaw('max(id) as id, client_id, expire_date,cetificate_number, certificate_type')
        $responses->when($is_checked == 'true', function ($q) use ($ad_id) {
            return $q->whereHas('client.environmentOfficer.assistantDirector', function ($query) use ($ad_id) {
                $query->where('assistant_directors.id', '=', $ad_id);
            });
        });

        $responses = $responses->where('expire_date', '=', null)
            ->groupBy('client_id')
            ->orderBy('id', 'desc')
            ->get();
        //to all get expired certificates and certificates that expired within a month by env officer id
        return $responses;
    }

    public function getPendingExpiredView()
    {
        $user = Auth::user();
        $pageAuth = $user->authentication(config('auth.privileges.clientSpace'));
        return view('Reports.pending_expired_list', ['pageAuth' => $pageAuth]);
    }

    public function changeStatus($client_id)
    {
        $client = Client::find($client_id);

        if ($client->file_status != 5) {
            return array('status' => 0, 'message' => 'File not completed');
        }
        $client->file_status = 0;
        $client->save();
        if ($client == true) {
            return array('status' => 1, 'message' => 'Successfully changed the file status');
        } else {
            return array('status' => 0, 'message' => 'File status changing was unsuccessfull');
        }
    }
    public function fixFileStatus(Request $request)
    {
        $client = Client::whereId($request->clint_id)->first();
        $client->file_status = 0;
        $client->save();
        if ($client == true) {
            return array('id' => 1, 'message' => 'Successfully changed the file status');
        } else {
            return array('id' => 0, 'message' => 'File status changing was unsuccessfull');
        }
    }

    public function changeOwner(Request $request)
    {
        $request->validate([
            'name_title' => 'required',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'address' => 'nullable',
            'email' => 'nullable|email',
            'nic' => 'nullable',
            'contact_no' => 'nullable',
            'industry_name' => 'required',
            'industry_contact_no' => 'nullable',
            'industry_address' => 'required',
            'industry_email' => 'nullable|email',
        ]);

        $ownerchange = ChangeOwner::create([
            'client_id' => $request->client_id,
            'name_title' => $request->name_title,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'email' => $request->email,
            'nic' => $request->nic,
            'contact_no' => $request->contact_no,
            'industry_name' => $request->industry_name,
            'industry_contact_no' => $request->industry_contact_no,
            'industry_address' => $request->industry_address,
            'industry_email' => $request->industry_email,
        ]);

        if ($ownerchange == true) {
            return array('status' => 1, 'message' => 'Successfully changed the owner details');
        } else {
            return array('status' => 0, 'message' => 'Ownership changing was unsuccessfull');
        }
    }

    /**
     * view to set application fee payment to profile
     *
     * @param Client $client
     * @return void
     */
    public function setProfilePayments(Client $client)
    {
        $onlineNewApplicationRequest = OnlineNewApplicationRequest::where('client_id', $client->id)->first();
        $invoices = Invoice::with('transactions')->whereHas('transactions', function ($query) {
            $query->whereNull('client_id')->where('type', 'application_fee');
        })->get();

        return view('set-profile-payment.index', compact('client', 'invoices', 'onlineNewApplicationRequest'));
    }

    /**
     * set application fee to profile
     *
     * @return void
     */
    public function setPayment(Client $client, Invoice $invoice)
    {
        $transactions = Transaction::where('invoice_id', $invoice->id)->get();

        foreach ($transactions as $transaction) {
            $transaction->update([
                'client_id' => $client->id,
            ]);
        }

        return redirect()->route('set-profile-payments', $client->id)->with('payment_set', 'Payment successfully added to the selected client');
    }
}
