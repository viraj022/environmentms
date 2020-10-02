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

    public static function getInspectionFolderPath(InspectionSession $inspection)
    {
        return  FieUploadController::BASE_PATH . "/" . $inspection->client_id . "/inspection" . $inspection->id;
    }
    public static function getEPLApplicationFilePath(EPL $epl)
    {
        return  FieUploadController::getEPLFolderPath($epl) . "/application";
    }
    public static function getSiteClearanceAPPLICATIONFilePath(SiteClearenceSession $site)
    {
        return  FieUploadController::getEPLSiteClearanceFoldersPath($site) . "/application";
    }
    public static function getEPLCertificateFilePath(EPL $epl)
    {
        return  FieUploadController::getEPLFolderPath($epl) . "/certificates";
    }
    public static function getSiteClearanceCertificateFilePath(SiteClearenceSession $site)
    {
        return  FieUploadController::getEPLSiteClearanceFoldersPath($site) . "/certificates";
    }
    public static function getInspectionFilePath(InspectionSession $inspection)
    {
        return  FieUploadController::BASE_PATH . "/"  . $inspection->client_id . "/inspections/" . $inspection->id;
    }
    public static function getRoadMapPath(Client $client)
    {
        return  FieUploadController::BASE_PATH . "/" . $client->id . "/application/file1";
    }
    public static function getDeedFilePath(Client $client)
    {
        return  FieUploadController::BASE_PATH . "/" . $client->id . "/application/file2";
    }
    public static function getSurveyFilePath(Client $client)
    {
        return  FieUploadController::BASE_PATH . "/" . $client->id . "/application/file3";
    }
    public static function getEPLAttachmentPath(EPL $epl)
    {
        return  FieUploadController::getEPLApplicationFilePath($epl) . "/attachments";
    }
}
