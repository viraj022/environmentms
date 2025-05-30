<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{

    public const call = 1;
    public const written = 2;
    public const verbal = 3;

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user');
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user');
    }

    public function complainMinutes()
    {
        return $this->hasMany(ComplainMinute::class);
    }

    public function complainComments()
    {
        return $this->hasMany(ComplainComment::class);
    }

    public function complainAssignLog()
    {
        return $this->hasMany(ComplainAssignLog::class);
    }

    protected $fillable = [
        'complainer_name', 'complainer_address', 'comp_contact_no', 'recieve_type', 'complain_des', 'created_user', 'complainer_code', 'assigned_user', 'assigner_user', 'pradeshiya_saba_id', 'client_id'
    ];

    public function letters()
    {
        return $this->hasMany(Letter::class);
    }

    public function pradesheeyasaba()
    {
        return $this->belongsTo(Pradesheeyasaba::class, 'pradeshiya_saba_id', 'id');
    }
}
