<?php

namespace App\Repositories;

use App\Complain;

class ComplaintRepository
{

    public function getComplaints($from, $to)
    {
        $query = Complain::join('pradesheeyasabas', 'complains.pradeshiya_saba_id', 'pradesheeyasabas.id')
            ->join('zones', 'pradesheeyasabas.zone_id', 'zones.id')
            ->whereRaw('DATE(complains.created_at) BETWEEN ? AND ?', [$from, $to])
            ->selectRaw('zones.id as zone_id, zones.name as zone_name, COUNT(complains.id) AS total')
            ->groupBy('zones.id')
            ->orderBy('zones.name')
            ->get()->keyBy('zone_id');

        return $query;
    }
}
