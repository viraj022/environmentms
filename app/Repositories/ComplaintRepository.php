<?php

namespace App\Repositories;

use App\Complain;

class ComplaintRepository
{

    public function getComplaints($from, $to)
    {
        $query = Complain::join('pradesheeyasabas', 'complains.pradeshiya_saba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->join('assistant_directors', 'zones.id', 'assistant_directors.zone_id')
            ->join('users', 'assistant_directors.user_id', 'users.id')
            ->whereRaw('DATE(complains.created_at) BETWEEN ? AND ?', [$from, $to])
            ->selectRaw('assistant_directors.id as ass_id,users.first_name, users.last_name, COUNT(complains.id) AS total')
            ->groupBy('zones.id')
            ->orderBy('zones.name')
            ->get();

        return $query;
    }
}
