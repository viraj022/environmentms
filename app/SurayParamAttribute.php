<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SurayParamAttribute extends Model
{
    public const SELECTED = 'SELECTED';
    public const TEXT = 'TEXT';
    public const DATE = 'DATE';
    public const NUMERIC = 'NUMERIC';
    public function surveyValues()
    {
        return $this->hasMany(surveyValue::class, 'suray_param_attributes_id', 'id');
    }
}
