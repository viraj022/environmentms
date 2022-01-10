<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model {

    public const call = 1;
    public const written = 2;
    public const verbal = 3;

    public function assignedUser() {
        return $this->belongsTo(User::class, 'assigned_user');
    }

    public function createdUser() {
        return $this->belongsTo(User::class, 'created_user');
    }

    protected $fillable = [
        'complainer_name', 'complainer_address', 'comp_contact_no', 'recieve_type', 'complain_des', 'created_user', 'complainer_code'
    ];


}
