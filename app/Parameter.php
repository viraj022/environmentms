<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    public function SurayParamAttributes()
    {
        return $this->hasMany(SurayParamAttribute::class);
    }
    // wherehas('SurayParamAttributes',function($queary){$queary->where('survey_attribute_id',1);})->where('titleID',1)->get();
    // whereDoesntHave('SurayParamAttributes',function($queary){$queary->where('survey_attribute_id',1);})->where('titleID',1)->get();
}
