<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificate;

class CertificateRefferenceController extends Controller
{
    public function saveReferenceNo(Request $request)
    {
        $certificate = Certificate::find($request->cert_id);
        $certificate->refference_no = $request->cert_ref_no;
        $certificate->save();
        if ($certificate == true) {
            return array('status' => 1, 'message' => 'Reference Number Saved Successfully');
        } else {
            return array('status' => 0, 'message' => 'Reference Number Not Saved');
        }
    }
}
