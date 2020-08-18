<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
        use SoftDeletes;
        public function epls()
        {
                return $this->hasMany(EPL::class);
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
