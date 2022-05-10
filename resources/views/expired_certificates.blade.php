@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<!-- Select2 -->
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
@if($pageAuth['is_read']==1 || false)
<section class="content-header">
    <div class="container-fluid">
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input id="getByAssDir" class="form-check-input" type="checkbox">
                            <label class="form-check-label">Search By Assistant Director</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select id="getAsDirect" class="form-control form-control-sm">
                                <option value="0">Loading..</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button id="getByAssDirGenBtn" type="button" class="btn btn-block btn-primary btn-xs">Generate</button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4 class="d-flex justify-content-center"><b>Expired Certificates</b></h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 700px;">
                            <table class="table table-condensed" id="tblExpiredCertificate">
                                <thead>
                                    <tr>
                                        <th style="width: 5em">#</th>
                                        <th style="width: 20em">Industry Name</th>
                                        <th style="width: 25em">File No</th>
                                        <th style="width: 25em">Pradeshiya Sabha</th>
                                        <th style="width: 20em">Status</th>
                                        <th style="width: 20em">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
@endif
@endsection

@section('pageScripts')
<!-- Page script -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../js/CertificatePreferJS/expired_certificate.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
//Load table
        loadAssDirCombo();
        getExpireCerByAssDir(null);
//select button action 
        $(document).on('click', '#getByAssDirGenBtn', function () {
            if ($('#getByAssDir').is(":checked")) {
//                alert();
                getExpireCerByAssDir($('#getAsDirect').val());
            } else {
                getExpireCerByAssDir(null);
            }
        });
    });
</script>
@endsection