<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class surveyTitle extends Model
{
    public function surveyAttributes()
    {
        return $this->hasMany(surveyAttribute::class);
    }
    public function parameters()
    {
        return $this->hasMany(Parameter::class, 'titleID', 'id');
    }
    public function surveySessions()
    {
        return $this->belongsToMany(SurveySession::class);
    }
}
