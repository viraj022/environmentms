<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeRemark extends Model
{
    protected $fillable = ['remark', 'user_id', 'committee_id', 'path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function committee()
    {
        return $this->belongsTo(Committee::class);
    }
}
