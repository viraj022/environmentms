<?php

namespace App\Repositories;

use App\Certificate;
use App\Client;
use App\EPL;
use App\OnlineNewApplicationRequest;
use App\OnlineNewEpl;
use App\OnlineRenewalApplicationRequest;
use App\OnlineRenewalEpl;
use App\OnlineRequest;
use App\OnlineRequestStatus;
use App\OnlineSiteClearance;
use App\RefilingPaddyLand;
use App\SiteClearenceSession;
use App\StateLandLease;
use App\TelecommunicationTower;
use App\TreeFelling;

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

    public function getCertificateByCertificateNumber($certificateNumber, $cerType)
    {
        if ($cerType == 'epl') {
            return EPL::where('code', $certificateNumber)->first();
        } else {
            return SiteClearenceSession::where('code', $certificateNumber)->first();
        }
        // return Certificate::where('cetificate_number', $certificateNumber)->first();
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
