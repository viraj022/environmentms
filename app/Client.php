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
        
        public function environmentOfficer() {
            return $this->belongsTo(EnvironmentOfficer::class);
        }
}
