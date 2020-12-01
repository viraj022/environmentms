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
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Application Attachment Setup</h1>
            </div>
        </div>
    </div>
</section>

<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="card card-gray">
                    <div class="card-header">
                        <label>Roles</label>
                    </div>
                    <div class="card-body">
                        <label>Application Type</label>
                        <select class="form-control select2 select2-purple applicationType" data-dropdown-css-class="select2-purple"style="width: 100%;"></select>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Available Attachments</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-condensed " id="allAt_tbl">
                                <thead>
                                    <tr><td><input type="checkbox" id="chkAll"></td><td></td></tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card-footer">
                        @if($pageAuth['is_create']==1 || false)
                        <button id="btnSave" type="submit" class="btn btn-success">Save</button>
                        @endif
                        <button id="btnReset" type="submit" class="btn btn-default">Reset</button>
                    </div>
                </div>
            </div>
            <!--            <div class="col-md-5">
                            <div class="card card-gray">
                                <div class="card-body">
                                    <div class="row">
            
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Assigned Attachments</h3>
                                                </div>
                                                 /.card-header 
                                                <div class="card-body p-0">
                                                    <table class="table table-condensed" id="assigned_at">
            
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                                 /.card-body 
                                            </div>
                                        </div>
            
                                    </div>
                                </div>
                            </div>
                        </div>-->
        </div>
    </div>
</section>

@endif
@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="../../js/attachmentsjs/attachment_map.js"></script>
<!-- AdminLTE App -->
<script>
    GetApplications(function () {
        GetAllDetails(parseInt($('.applicationType').val()));
    });
    $('.applicationType').change(function () {
        GetAllDetails(parseInt($('.applicationType').val()));
    });
    $('#btnSave').click(function () {
        var chk_list = [];
        $.each($("input[name='atachCheck']:checked"), function () {
            chk_list.push($(this).val());
        });
        submitData({id: $('.applicationType').val(), attachment: chk_list}, function (res) {
            if (res.id == 1) {
                Toast.fire({
                    type: 'success',
                    title: 'Enviremontal MS</br>Removed!'
                });
                GetAllDetails(parseInt($('.applicationType').val()));
            } else {
                Toast.fire({
                    type: 'error',
                    title: 'Enviremontal MS</br>Error'
                });
            }
        });
    });
    $('#btnReset').click(function () {
        GetAllDetails(parseInt($('.applicationType').val()));
    });
    $('#chkAll').click(function () {
        if ($(this).is(':checked')) {
            $('input[name=atachCheck]').attr('checked', true);
        } else {
            $('input[name=atachCheck]').attr('checked', false);
        }

    });
</script>
@endsection
