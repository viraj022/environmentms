<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommitteeRemark extends Model
{
    protected $fillable = ['remark', 'user_id', 'committee_id'];
}
