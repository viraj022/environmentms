<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnvironmentOfficer extends Model
{
    public function assistantDirector()
    {
        return $this->belongsTo(AssistantDirector::class);
    }
}
