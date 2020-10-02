<?php

namespace App\Http\Controllers;

use App\Client;
use App\EPL;
use App\SiteClearenceSession;
use Illuminate\Http\Request;

class FieUploadController extends Controller
{
    public const BASE_PATH = "IndustryFiles";

    public static function getEPLFolderPath(EPL $epl)
    {
        return  FieUploadController::BASE_PATH . "/" . $epl->client_id . "/" . $epl->id;
    }
    public static function getEPLSiteClearanceFoldersPath(SiteClearenceSession $site)
    {
        return  FieUploadController::BASE_PATH . "/" . $site->client_id . "/" . $site->id;
    }
    public static function getOldFilePath(Client $client)
    {
        return  FieUploadController::BASE_PATH . "/" . $client->id . "/old";
    }
    public static function getDeedFilePath(Client $client)
    {
        return  FieUploadController::BASE_PATH . "/" . $client->id . "/deed";
    }
    public static function getEPLAPPLICATIONFilePath(EPL $epl)
    {
        return  FieUploadController::getEPLFolderPath($epl->id) . "/applications";
    }
    public static function getSiteClearanceAPPLICATIONFilePath(SiteClearenceSession $site)
    {
        return  FieUploadController::getEPLFolderPath($site->id) . "/applications";
    }
    public static function getEPLCertificateFilePath(EPL $epl)
    {
        return  FieUploadController::getEPLFolderPath($epl->id) . "/applications";
    }
    public static function getSiteClearanceCertificateFilePath(SiteClearenceSession $site)
    {
        return  FieUploadController::getEPLFolderPath($site->id) . "/applications";
    }
}
