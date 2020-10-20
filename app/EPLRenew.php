<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EPLRenew extends Model
{
    protected $table = 'e_p_l_s_renewals_view';

    public function epl_new()
    {
        return $this->belongsTo(EPLNew::class, 'client_id', 'client_id');
    }
}
