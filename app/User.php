<?php

namespace App;

use App\Roll;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    public const ACTIVE = 'Active';
    public const INACTIVE = 'Inactive';
    public const ARCHIVED = 'Archived';

    public const NATIONAL = 'National';
    public const PROVINCIAL = 'Provincial';
    public const LOCAL = 'Local';
    public const SUBOFFICE = 'Suboffice';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roll()
    {
        return $this->belongsTo(Roll::class);
    }

    public function institute()
    {
        $level = $this->roll->level->name;
        if ($level === Level::PROVINCIAL) {
            return $this->belongsTo(ProvincialCouncil::class, 'institute_Id', 'id');
        } else if ($level === Level::LOCAL) {
            return $this->belongsTo(LocalAuthority::class, 'institute_Id', 'id');
        } else {
            return 0;
        }
    }

    public function privileges()
    {
        return $this->belongsToMany(Privilege::class)->withPivot('is_read', 'is_create', 'is_update', 'is_delete');
    }

    public function authentication($id)
    {
        $pre = $this->privileges;
        foreach ($pre as $p) {
            if ($p['id'] == $id) {
                return $p['pivot'];
            }
        }
        return null;
    }
    public function surveys()
    {
        return SurveySession::where('session_status', "1")->get();
    }
    public function office()
    {
        $level = $this->roll->level->name;
        if ($level === Level::NATIONAL) {
            return User::NATIONAL;
        } else if ($level === Level::PROVINCIAL) {
            return User::PROVINCIAL;
        } else if ($level === Level::LOCAL) {
            $office = LocalAuthority::find($this->institute_Id);
            if ($office->parent_id == null) {
                return User::LOCAL;
            } else {
                return User::SUBOFFICE;
            }
        }
    }
}
