<?php

namespace App\Repositories;

use App\Certificate;
use App\Client;
use App\OnlineNewApplicationRequest;
use App\OnlineNewEpl;
use App\OnlineRenewalApplicationRequest;
use App\OnlineRenewalEpl;
use App\OnlineRequest;
use App\OnlineRequestStatus;
use App\OnlineSiteClearance;
use App\RefilingPaddyLand;
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

    /**
     * Get all tree felling application requests
     * Ordered by created date
     *
     * @return Collection
     */
    public function getAllTreeFellingApplications()
    {
        return TreeFelling::with('onlineRequest')
            ->with(['pradeshiyaSabha'])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Get all refiling paddy application requests
     * Ordered by created date
     *
     * @return Collection
     */
    public function getAllRefilingPaddyApplications()
    {
        return RefilingPaddyLand::with('onlineRequest')
            ->with(['pradeshiyaSabha'])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Get all state land lease application requests
     * Ordered by created date
     *
     * @return Collection
     */
    public function getAllStateLandLeasesApplications()
    {
        return StateLandLease::with('onlineRequest')
            ->with(['pradeshiyaSabha'])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Get all site clearance application requests
     * Ordered by created date
     *
     * @return Collection
     */
    public function getAllSiteClearanceApplications()
    {
        return OnlineSiteClearance::with('onlineRequest')
            ->with(['pradeshiyaSabha'])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Get all telecommunication tower application requests
     * Ordered by created date
     *
     * @return Collection
     */
    public function getAllTelecommunicationTowerApplications()
    {
        return TelecommunicationTower::with('onlineRequest')
            ->with(['pradeshiyaSabha'])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Get all new epl application requests
     * Ordered by created date
     *
     * @return Collection
     */
    public function getAllNewEplApplications()
    {
        return OnlineNewEpl::with('onlineRequest')
            ->with(['pradeshiyaSabha'])
            ->orderBy('created_at')
            ->get();
    }

    /**
     * Get all epl renewal application requests
     * Ordered by created date
     *
     * @return Collection
     */
    public function getAllRenewalEplApplications()
    {
        return OnlineRenewalEpl::with('onlineRequest')
            ->with(['pradeshiyaSabha'])
            ->orderBy('created_at')
            ->get();
    }
}
