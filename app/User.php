<?php

namespace App;

use App\Roll;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;
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

    protected $with = [
        'roll.level'
    ];


    public function roll()
    {
        return $this->belongsTo(Roll::class);
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
    public function findForPassport($username)
    {
        return $this->where('user_name', $username)->first();
    }

    public function complains() {
        return $this->hasMany(Complain::class);
    }

    public function complainAssignLogs() {
        return $this->hasMany(ComplainAssignLog::class);
    }

    public function letterTemplates(){
        return $this->hasMany(LetterTemplate::class);
    }

    public function ComplainComments()
    {
        return $this->hasMany(ComplainComment::class);
    }

    public function ComplainMinutes()
    {
        return $this->hasMany(ComplainMinute::class);
    }
}
