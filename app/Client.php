<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
        public const STATUS_INSPECTION_NEEDED = 'Inspection Needed';
        public const STATUS_INSPECTION_NOT_NEEDED = 'Inspection Not Needed';
        public const STATUS_PENDING = 'Pending';
        public const STATUS_COMPLETED = 'Completed';
        public const STATUS_NEW = 'New';

        public const IS_WORKING_NEW = 0;
        public const IS_WORKING_WORKING = 1;
        public const IS_WORKING_FINISH = 2;
        protected $appends = ['start_date_only'];

        public function getStartDateOnlyAttribute()
        {
                //return strtotime($this->schedule_date)->toDateString();
                return Carbon::parse($this->industry_start_date)->format('Y-m-d');
        }

        use SoftDeletes;
        public function epls()
        {
                return $this->hasMany(EPL::class);
        }
        public function siteClearenceSessions()
        {
                return $this->hasMany(SiteClearenceSession::class);
        }
        public function inspectionSessions()
        {
                return $this->hasMany(InspectionSession::class);
        }
        public function oldFiles()
        {
                return $this->hasMany(OldFiles::class);
        }

        public function environmentOfficer()
        {
                return $this->belongsTo(EnvironmentOfficer::class);
        }
        public function industryCategory()
        {
                return $this->belongsTo(IndustryCategory::class);
        }
        public function businessScale()
        {
                return $this->belongsTo(BusinessScale::class);
        }
        public function pradesheeyasaba()
        {
                return $this->belongsTo(Pradesheeyasaba::class);
        }

        public static function getFileByStatusQuery($statusType, $statusCodes)
        {
                $file = "";
                switch ($statusType) {
                        case 'file_status':
                                $file = Client::whereIn('file_status', $statusCodes);
                                break;
                        case 'inspection':
                                $file = Client::whereIn('file_status', $statusCodes);
                                break;
                        case 'cer_type_status':
                                $file = Client::whereIn('file_status', $statusCodes);
                                break;
                        case 'old_data':
                                $file = Client::whereIn('file_status', $statusCodes);
                                break;
                        case 'file_working':
                                $file = Client::whereIn('file_status', $statusCodes);
                                break;
                        case 'cer_status':
                                $file = Client::whereIn('file_status', $statusCodes);
                                break;
                        case 'file_problem':
                                $file = Client::whereIn('file_status', $statusCodes);
                                break;
                        default:
                                abort('422', 'unknown status type');
                }
                return $file->with('oldFiles')
                        ->with('industryCategory')
                        ->with('businessScale')
                        ->with('pradesheeyasaba')
                        ->with('environmentOfficer.assistantDirector');
        }

        public function generateCertificateNumber()
        {
                switch ($this->cer_type_status) {
                        case 1: //new epl
                                $cerNo = getSerialNumber(Setting::CERTIFICATE_AI);
                                $data =  str_pad($cerNo, 6, "0", STR_PAD_LEFT);
                                return $data . "/" . date("Y");
                        case 2: //epl renewal
                                $epl = EPL::Where('client_id', $this->id)->first();
                                $curEpl = EPL::Where('client_id', $this->id)->orderBy('id', 'desc')->first();
                                // dd($epl->toArray());
                                $serial_no =  Str::substr($epl->certificate_no, 0, strpos($epl->certificate_no, '/'));
                                $data = str_pad(($serial_no), 6, "0", STR_PAD_LEFT);
                                return  $data . "/" . date("Y") . "/r" . $curEpl->count;
                        case 3; //site_new
                                $client = Client::findOrFail($this->id);
                                // dd($client->siteClearenceSessions->reverse()[0]->code);
                                return $client->siteClearenceSessions->reverse()[0]->code;
                        case 4: //site_clearance_extetion
                                $client = Client::findOrFail($this->id);
                                return $client->siteClearenceSessions->reverse()[0]->code;
                                break;
                        default:
                }
        }

        public function minutes()
        {
                return $this->hasMany(Minute::class);
        }
}
