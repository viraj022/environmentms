<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $fillable = [
        'subject', 'table', 'field', 'user_id', 'url', 'ip', 'method', 'headers', 'request_data', 'response_code', 'response_data'
    ];
}
