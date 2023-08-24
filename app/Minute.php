<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
    public const EPL = 'epl';
    public const SITE_CLEARANCE = 'site_clearance';

    public const DESCRIPTION_ENV_APPROVE_FILE = 'ENV_OFF_APP_FILE';  // officer approve file
    public const DESCRIPTION_ENV_REJECT_FILE = 'ENV_OFF_REJECT_FILE';  // officer reject file
    public const DESCRIPTION_ASSI_REJECT_FILE = 'ASSI_OFF_REJECT_FILE'; // assistance director reject file
    public const DESCRIPTION_ASSI_APPROVE_FILE = 'ASSI_OFF_APPROVE_FILE'; // assistance director approve file

    public const DESCRIPTION_ENV_APPROVE_CERTIFICATE = 'ENV_OFF_APP__CERTIFICATE'; // officer approve certificate
    public const DESCRIPTION_ENV_REJECT_CERTIFICATE = 'ENV_OFF_REJECT__CERTIFICATE'; // officer reject certificate
    public const DESCRIPTION_ASSI_REJECT_CERTIFICATE = 'ASSI_OFF_REJECT__CERTIFICATE'; // assistance director reject certificate
    public const DESCRIPTION_ASSI_APPROVE_CERTIFICATE = 'ASSI_OFF_APPROVE__CERTIFICATE'; // assistance director approve certificate

    public const DESCRIPTION_Dire_APPROVE_CERTIFICATE = 'DIRECTOR_APP__CERTIFICATE'; // director approve certificate
    public const DESCRIPTION_Dire_REJECT_CERTIFICATE = 'ENV_OFF_REJECT__CERTIFICATE'; // director reject certificate
    public const DESCRIPTION_Dire_Hold_CERTIFICATE = 'ASSI_OFF_REJECT__CERTIFICATE'; // director hold certificate

    protected $fillable = ['file_type', 'file_type_id', 'user_id', 'minute_description', 'situation','file_id'];
    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function fileTye()
    {
        $type = $this->file_type;
        if ($type === Minute::EPL) {
            return $this->belongsTo(EPL::class, 'file_type_id', 'id');
        } else if ($type === Minute::SITE_CLEARANCE) {
            return $this->belongsTo(SiteClearance::class, 'file_type_id', 'id');
        }
    }

    // file
    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'file_id');
    }
}
