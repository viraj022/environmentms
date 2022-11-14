<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeOwner extends Model
{
    protected $fillable = [
        'client_id',
        'name_title',
        'first_name',
        'last_name',
        'address',
        'email',
        'nic',
        'contact_no',
        'industry_name',
        'industry_contact_no',
        'industry_address',
        'industry_email',
    ];
}
