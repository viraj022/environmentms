<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
    public const EPL = 'epl';
    public const SITE_CLEARANCE = 'site_clearance';
    public const DESCRIPTION_ENV_APPROVE = 'ENV_OFF_APP_FILE';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function fileTye()
    // {
    //     $type = $this->file_type;
    //     if ($type === Minute::EPL) {
    //         return $this->belongsTo(EPL::class, 'file_type_id', 'id');
    //     } else if ($type === Minute::SITE_CLEARANCE) {
    //         return $this->belongsTo(SiteClearance::class, 'file_type_id', 'id');
    //     }
    // }
}
