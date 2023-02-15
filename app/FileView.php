<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FileView extends Model
{
    protected $table = 'file_view';
    protected $hidden = [
        'password', 'api_token',
    ];

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
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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
                $data = str_pad(($serial_no), 4, "0", STR_PAD_LEFT);
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

    public function resetFile()
    {
    }
    /**
     * return woring file type and id and its model
     */
    public function getActiveWorkingFileType()
    {
        $rtn = [];
        switch ($this->cer_type_status) {
            case 1:
                $epl =   EPL::where('client_id', $this->id)->orderBy('id', 'DESC')->first();
                $rtn['type'] = 'EPL';
                $rtn['id'] = $epl->id;
                $rtn['model'] = $epl;
                break;
            case 2:
                $epl =   EPL::where('client_id', $this->id)->orderBy('id', 'DESC')->first();
                $rtn['type'] = 'EPL';
                $rtn['id'] = $epl->id;
                $rtn['model'] = $epl;
                break;
            case 3:
                $siteSession =   SiteClearenceSession::where('client_id', $this->id)->orderBy('id', 'DESC')->first();
                $site = $siteSession->siteClearances->last();
                $rtn['type'] = 'SITE';
                $rtn['id'] = $site->id;
                $rtn['model'] = $site;
                break;
            case 4:
                $siteSession =   SiteClearenceSession::where('client_id', $this->id)->orderBy('id', 'DESC')->first();
                $site = $siteSession->siteClearances->last();
                $rtn['type'] = 'SITE';
                $rtn['id'] = $site->id;
                $rtn['model'] = $site;
                break;
            default:
                // $rtn = [];
        }

        return $rtn;
    }
}
