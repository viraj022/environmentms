<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComplainAssignLog extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function complain()
    {
        return $this->belongsTo(Complain::class);
    }

    public function assignerUser()
    {
        return $this->belongsTo(User::class, 'assigner_user');
    }

    public function assigneeUser()
    {
        return $this->belongsTo(User::class, 'assignee_user');
    }

    protected $fillable = [
        'complain_id', 'user_id', 'assigned_time', 'assignee_user', 'assigner_user'
    ];
}
