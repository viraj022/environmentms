<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Committee extends Model
{
      use SoftDeletes;
      protected $fillable = ['name', 'site_clearence_session_id', 'client_id', 'remark', 'schedule_date'];

      public function siteClearenceSession()
      {
            return $this->belongsTo(SiteClearenceSession::class);
      }

      public function commetyPool()
      {
            return $this->belongsToMany(CommetyPool::class);
      }
}
