<?php

namespace App\Repositories;

use App\Certificate;
use App\Client;
use App\OnlineNewApplicationRequest;
use App\OnlineRenewalApplicationRequest;
use App\OnlineRequest;
use App\OnlineRequestStatus;

class OnlineRequestRepository
{
    /**
     * Get all OnlineRenewalApplicationRequest entries
     * ordered by created date
     *
     * @return Collection
     */
    public function getAllRenewalApplications()
    {
        return OnlineRenewalApplicationRequest::with('onlineRequest')
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Get all new application requests
     * Ordered by created date
     *
     * @return Collection
     */
    public function getAllNewApplications()
    {
        return OnlineNewApplicationRequest::with('onlineRequest')
            ->with(['pradeshiyaSabha', 'industryCategory'])
            ->orderBy('created_at')
            ->get();
    }

    public function getCertificateByCertificateNumber($certificateNumber)
    {
        return Certificate::where('cetificate_number', $certificateNumber)->first();
    }

    public function getClientByFileNumber($fileNumber)
    {
        return Client::where('file_no', $fileNumber)->first();
    }

    public function getClientById($clientId)
    {
        return Client::where('id', $clientId)->first();
    }

    public function getCertificateByClientIdAndCertificateNumber($clientId, $certificateNumber)
    {
        return Certificate::where('client_id', $clientId)
            ->where('cetificate_number', $certificateNumber)
            ->first();
    }

    public function createOnlineRequestStatus($data)
    {
        return OnlineRequestStatus::create($data);
    }
}
