<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurveySession extends Model
{
    public function surveyTitles()
    {
        return $this->belongsToMany(surveyTitle::class);
    }
}
