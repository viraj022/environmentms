<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EPLNew extends Model
{
    protected $table = 'view_e_p_l_s_new';

    public function epl_renews()
    {
        return $this->hasMany(EPLRenew::class, 'client_id', 'client_id');
    }
}
