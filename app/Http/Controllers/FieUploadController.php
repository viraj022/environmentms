<?php

namespace App\Http\Controllers;

use App\Client;
use App\EPL;
use App\InspectionSession;
use App\SiteClearenceSession;
use Illuminate\Http\Request;

class FieUploadController extends Controller
{
    public const BASE_PATH = "industry_files";

    public static function getEPLFolderPath(EPL $epl)
    {
        // dd($epl->id);
        return  FieUploadController::BASE_PATH . "/" . $epl->client_id . "/epl/" . $epl->id;
    }
    public static function getEPLSiteClearanceFoldersPath(SiteClearenceSession $site)
    {
        return  FieUploadController::BASE_PATH . "/" . $site->client_id . "/site_clearance" . $site->id;
    }
    public static function getOldFilePath(Client $client)
    {
        return  FieUploadController::BASE_PATH . "/" . $client->id . "/old";
    }
    public static function getDeedFilePath(Client $client)
    {
        return  FieUploadController::BASE_PATH . "/" . $client->id . "/deed";
    }
    public static function getInspectionFolderPath(InspectionSession $inspection)
    {
        return  FieUploadController::BASE_PATH . "/" . $inspection->client_id . "/inspection" . $inspection->id;
    }
    public static function getEPLApplicationFilePath(EPL $epl)
    {
        return  FieUploadController::getEPLFolderPath($epl) . "/applications";
    }
    public static function getSiteClearanceAPPLICATIONFilePath(SiteClearenceSession $site)
    {
        return  FieUploadController::getEPLSiteClearanceFoldersPath($site) . "/applications";
    }
    public static function getEPLCertificateFilePath(EPL $epl)
    {
        return  FieUploadController::getEPLFolderPath($epl->id) . "/certificates";
    }
    public static function getSiteClearanceCertificateFilePath(SiteClearenceSession $site)
    {
        return  FieUploadController::getEPLFolderPath($site->id) . "/certificates";
    }
    public static function getEPLInspectionFilePath(InspectionSession $inspection)
    {
        return  FieUploadController::getInspectionFolderPath($inspection->id) . "/epl" . $inspection->id;
    }
}
