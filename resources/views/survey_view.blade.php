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
<section class="content-header">
    <div class="container-fluid">
@dump($surveySession['id'])
@dump($surveySession['name'])
@dump($surveySession['session_status'])
@if($surveySession['session_status']==1)
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">

            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    <!--TAB 1-->
                    <div class="tab-pane fade active show" id="title_tab" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <label>Add Survey Results</label>
                                    </div>

                                    <form method="" action="">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Title Name</label>
                                                <select class="form-control title_cbo" id="title_combo"></select>
                                            </div>
                                            <div class="form-group">
                                                <label>Attribute :</label>
                                                <select class="form-control attr_cbo" id="attr_combo"></select>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary">Add</button>
                                            <button type="button" class="btn btn-warning">Update</button>
                                            <button type="button" class="btn btn-danger" id="delete_title">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Add Results</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-condensed " id="sur_resTbl">
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
            <div class="card-body">
                <!--TAB 1-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <label>Add Survey Results</label>
                            </div>
                            <table class="table table-condensed">
                                <thead></thead>
                                <tbody>
                                    <tr>
                                        <th>Attribute</th>
                                        <th>Action</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
</div>
@else
<h1>Survey Is Over</h1>
@endif
</section>
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
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

<!--added by viraj-->
<script src="/js/survey/survey_results.js" type="text/javascript"></script>
<script>
    function get_form_val() {
        var RET_OBJ = [];
        let list = $('.in_val');
        var D_TYPE = {"select-one": "SELECTED", "text": "TEXT", "number": "NUMERIC", "date": "DATE"};
        $.each(list, function (index, row) {
            var typ = D_TYPE[$(row).prop("type")];
            var vl = $(row).val();
            var id = $(row).data('row_id');
            if (typ == 'SELECTED') {
                vl = $('#v_' + id + ' :selected').text();
            }

            RET_OBJ.push({'value': vl, 'type': typ, 'suray_param_attribute_id': id});
        });
        return RET_OBJ;
    }
    $(function () {
        load_titleCombo(function () {
            load_attrCombo(parseInt($('#title_combo').val()), function () {
                iterate_results_form(parseInt($('#attr_combo').val()));
            });
        });

        $(document).on('click', '.btn-primary', function () {
            var data = get_form_val();
            console.log(data);
            save_survey_val(data, function (p) {
                if (p.mgs == 'true') {
                    Toast.fire({
                        type: 'success',
                        title: 'Waste Management System</br>Data Saved'
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: 'Waste Management System</br>Error !'
                    });
                }
            });
        });
        $('#title_combo').change(function () {
            load_attrCombo(parseInt($('#title_combo').val()), function () {
                iterate_results_form(parseInt($('#attr_combo').val()));
            });
        });
        $('#attr_combo').change(function () {
            iterate_results_form(parseInt($('#attr_combo').val()));
        });
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000
        });

//Initialize Select2 Elements
        $('.select2').select2();
        $("#tblUsers").DataTable();

    });
</script>
@endsection
