<?php

use App\Client;

function changeDateFormate()
{
    return "h1";
}

function productImagePath($image_name)
{
    return public_path('images/products/' . $image_name);
}

function setFileStatus($fileId, $statusType, $statusCode, $statusValue)
{
    $file = Client::findOrfail($fileId);
    switch($statusType){
        case '':
        break;
        default:
    }

}
