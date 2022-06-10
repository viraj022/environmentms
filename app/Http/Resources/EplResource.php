<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EplResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // 'id' => $this->id,
            'code' => $this->code,
            // 'issue_date' => $this->issue_date,
            // 'expire_date' => $this->expire_date,
            'submitted_date' => $this->submitted_date,
            // 'status' => $this->status,
            // 'path' => $this->path,
            // 'rejected_date' => $this->rejected_date,
        ];
    }
}
