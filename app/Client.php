<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
        public const STATUS_INSPECTION_NEEDED = 'Inspection Needed';
        public const STATUS_INSPECTION_NOT_NEEDED = 'Inspection Not Needed';
        public const STATUS_NEW = 'New';

        public const IS_WORKING_NEW = 0;
        public const IS_WORKING_WORKING = 1;
        public const IS_WORKING_FINISH = 2;



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
}
