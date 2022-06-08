<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this);
        $latestEpl = $this->epls->first();
        $lastSiteClearanceSession = $this->siteClearenceSessions->first();
        $lastSiteClearance = false;
        $date = '';
        if ($lastSiteClearanceSession) {
            $lastSiteClearance = $lastSiteClearanceSession->siteClearances->first();
        }
        if ($latestEpl && $lastSiteClearance) {
            // get latest date of EPL and Site Clearance
            $date = Carbon::parse($latestEpl->submitted_date)->greaterThan(Carbon::parse($lastSiteClearance->submit_date)) ? $latestEpl->submitted_date : $lastSiteClearance->submit_date;
        } else {
            if ($latestEpl) {
                $date = Carbon::parse($latestEpl->submitted_date)->format("Y-m-d");
            }
            if ($lastSiteClearance) {
                $date = Carbon::parse($lastSiteClearance->submit_date)->format("Y-m-d");
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->first_name . ' ' . $this->last_name,
            'address' => $this->address,
            'industry_name' => $this->industry_name,
            'phone' => $this->contact_no,
            // 'email' => $this->email,
            'file_no' => $this->file_no,
            'cer_type_status' => $this->cer_type_status,
            'industry_start_date' => $this->industry_start_date,
            'file_status' => $this->file_status,
            'need_inspection' => $this->need_inspection,
            'cer_status' => $this->cer_status,
            'is_old' => $this->is_old,
            'epl_code' => $latestEpl ? $latestEpl->code : '',
            'site_clearance_code' => $lastSiteClearanceSession ? $lastSiteClearanceSession->code : '',
            'date_to_show' => $date,
        ];
    }
}
