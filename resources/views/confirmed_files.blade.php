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
                <div class="card">
                    <div class="card-header">
                       <h4 class="d-flex justify-content-center"><b>Confirmed Files</b></h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body table-responsive" style="height: 450px;">
                            <table class="table table-condensed" id="confirmed_files">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 40em">Industry Name</th>
                                        <th style="width: 10em">File No</th>
                                        <th style="width: 20em">File Problem Status</th>
                                        <th style="width: 10em">Action</th>
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
<!-- Select2 -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../js/CertJS/confirmed_cert.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
//Load table
        loadAssDirCombo();
        getConfirmedCerByAssDir(null);
//select button action 
        $(document).on('click', '#getByAssDirGenBtn', function () {
            if ($('#getByAssDir').is(":checked")) {
//                alert();
                getConfirmedCerByAssDir($('#getAsDirect').val());
            } else {
                getConfirmedCerByAssDir(null);
            }
        });
    });

</script>
@endsection
