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


        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="title_t" data-toggle="pill" href="#title_tab" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Title</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="param_t" data-toggle="pill" href="#param_tab" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Parameter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="attr_t" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Attributes</a>
                    </li>
                    <!--                    <li class="nav-item">
                                            <a class="nav-link" id="custom-tabs-two-messages-tab" data-toggle="pill" href="#custom-tabs-two-messages" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Attribute Options</a>
                                        </li>-->
                    <li class="nav-item">
                        <a class="nav-link" id="param_type_t" data-toggle="pill" href="#param_types" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Parameter Types</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sur_priv" data-toggle="pill" href="#survey_prev" role="tab" aria-controls="custom-tabs-two-messages" aria-selected="false">Preview</a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">

                    <!--TAB 1-->
                    <div class="tab-pane fade active show" id="title_tab" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <label>Survey Title Registration</label>
                                    </div>

                                    <form method="" action="">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Title Name</label>
                                                <input type="text" class="form-control form-control-sm" placeholder="Enter Title Name" value="" id="title_text">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary" id="add_title">Add</button>
                                            <button type="button" class="btn btn-danger" id="delete_title">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">All Users</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-condensed " id="title_table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">#</th>
                                                    <th>Tile Name</th>
                                                    <th style="width: 20%">Action</th>
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

                    <!--TAB 2-->
                    <div class="tab-pane fade" id="param_tab" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <label>Title Parameters</label>
                                    </div>

                                    <form method="" action="">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Title :</label>
                                                <select class="form-control title_cbo" id="title_comboParam"></select>
                                            </div>

                                            <div class="form-group">
                                                <label>Parameter Name:</label>
                                                <input type="text" class="form-control form-control-sm" placeholder="Enter Name" value="" id="param_name">
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary" id="add_parameter">Add</button>
                                            <button type="button" class="btn btn-danger" id="delete_param">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Selected Title</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-condensed " id="param_table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">#</th>
                                                    <th>Attribute Name</th>
                                                    <th style="width: 20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--TAB 3-->
                    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <label>Title Attributes Registration</label>
                                    </div>

                                    <form method="" action="">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Title :</label>
                                                <label class="attr_tab_title"></label>
                                                <!--<select class="form-control title_cbo" id="title_combo"></select>-->
                                            </div>

                                            <div class="form-group">
                                                <label>Attribute Name:</label>
                                                <input type="text" class="form-control form-control-sm" placeholder="Enter Attribute Name" value="" id="attr_name">
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary" id="add_attr">Add</button>
                                            <button type="button" class="btn btn-danger" id="delete_attr">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Selected Title</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-condensed " id="attribute_table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">#</th>
                                                    <th>Attribute Name</th>
                                                    <th style="width: 20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--TAB 4-->
                    <div class="tab-pane fade" id="param_types" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <label>Attributes Options Registration</label>
                                    </div>

                                    <form method="" action="">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>Title :</label>
                                                <label class="attr_tab_title"></label>
                                            </div>
                                            <div class="form-group">
                                                <label>Attribute :</label>
                                                <select class="form-control attr_cbo" id="attr_combo"></select>
                                            </div>
                                            <div class="form-group">
                                                <label>Parameter :</label>
                                                <select class="form-control avl_param_cmb" id="param_combo"></select>
                                            </div>

                                            <div class="form-group">
                                                <label>Attribute Value Type :</label>
                                                <select class="form-control attr_type_cbo" id="survey_type">
                                                    <option value="TEXT">Text</option>
                                                    <option value="DATE">Date</option>
                                                    <option value="NUMERIC">Numeric</option>
                                                    <option value="SELECTED">Select</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary" id="add_attrPara">Add</button>
                                            <button type="button" class="btn btn-danger" id="attr_param_val_del">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Selected Title</h3>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-condensed " id="attr_param_val_table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">#</th>
                                                    <th>Parameter Name</th>
                                                    <th>Value Type</th>
                                                    <th style="width: 20%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="survey_prev" role="tabpanel" aria-labelledby="custom-tabs-two-messages-tab">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <label class="attr_tab_title text-center">Attributes Options Registration</label>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered" id="sur_privTbl">
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>

        <!-- /.modal-->
        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Large Modal</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="" action="" class="">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-10">
                                        <label class=" col-10">Option Value Name:</label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Value Name" value="" id="attr_val_name">
                                    </div>
                                    <div class="form-group col-2">
                                        <button type="button" class="btn btn-primary" id="sel_value">Add</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-10">
                                        <label>Option Value:</label>
                                        <select class="form-control attr_val_cmb" id="attr_option_combo"></select>
                                    </div>
                                    <div class="form-group col-2">
                                        <button type="button" class="btn btn-danger pull-right" id="attr_val_delete">Delete</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    </div>
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
<script src="/js/survey/survey.js" type="text/javascript"></script>
<script>
    var F_TAB = 'title_t';
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 4000

    });
    function AlertMEssege(type) {
        if (type == 'true') {
            Toast.fire({
                type: 'success',
                title: '<h4>Success</h4>'
            });
        } else {
            Toast.fire({
                type: 'error',
                title: '<h4>Error !</h4>'
            });
        }
    }
    $(function () {

        load_titleTable();
//        load_attr_valTable();
//        load_attr_types();
        load_titleCombo(function () {
            $('.attr_tab_title').html($('#title_comboParam :selected').text());
            load_attrCombo(parseInt($('#title_comboParam').val()), function () {
                load_avl_paramCombo(parseInt($('#title_comboParam').val()), parseInt($('#attr_combo').val()));//available parameter combo
            });
            load_attributeTable(parseInt($('#title_comboParam').val()));
            load_paramTable(parseInt($('#title_comboParam').val()));
        });
        $(document).on('click', '.val_sel', function () {
            load_attr_valCombo($(this).val());
            $('#sel_value').val($(this).val());
        });
        $(document).on('click', '.btn-danger', function () {
            var ar = {"title_t": "title_t", "param_t": "param_t", "attr_t": "attr_t", "param_type_t": "param_type_t", "sel_value": "sel_value"};
            var f_v = ar[F_TAB];
            var del_id = parseInt($(this).val());
//            alert(this.id);
//            return false;
            if (this.id == 'attr_val_delete') {
                f_v = 'sel_value';
                del_id = parseInt($('#attr_option_combo').val());
            }
            remove_survData(f_v, del_id, function (p) {
                AlertMEssege(p.mgs);
                load_survTable();
                load_titleCombo();
                reset_form_data();
                if (this.id == 'attr_val_delete') {
                    load_attr_valCombo($(this).val());
                }
            });
        });
        $(document).on('click', '.btn-dark', function () {
            set_selected_form_data(JSON.parse(decodeURIComponent($(this).data('row'))));
        });
        $(document).on('click', '.btn-primary', function () {
            var ar = {"title_t": "title_t", "param_t": "param_t", "attr_t": "attr_t", "param_type_t": "param_type_t", "sel_value": "sel_value"};
            var f_v = ar[F_TAB];
//            alert(this.id);
//            return false;
            if (this.id == 'sel_value') {
                f_v = 'sel_value';
            }
//            add_title
//add_parameter
//add_attr
//add_attrPara

//            console.log(get_form_object(f_v));
//            return false;
            save_survey(f_v, get_form_object(f_v), function (p) {
                AlertMEssege(p.mgs);
                if (p.mgs == 'true') {
                    if (f_v == 'sel_value') {
                        load_attr_valCombo(parseInt($('#sel_value').val()));
                    }
                    load_survTable();
                    load_titleCombo();
                    reset_form_data();
                }
            });
        });
        //---- on change
        $('.title_cbo, .attr_cbo').change(function () {
            $('.attr_tab_title').html($('#title_comboParam :selected').text());
            load_survTable();
        });
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000
        });
        function get_form_object(foc) {
            var FD = {};
            switch (foc) {
                case 'title_t':
                    FD["survey_title_name"] = $('#title_text').val().trim();
                    FD["survey_title_status"] = 1;
                    break;
                case 'param_t':
                    FD["survey_parameter_name"] = $('#param_name').val().trim();
                    FD["survey_title_id"] = parseInt($('#title_comboParam').val());
                    break;
                case 'attr_t':
                    FD["survey_attribute_name"] = $('#attr_name').val().trim();
//                    FD["survey_attribute_type"] = $('#survey_type').val();
//                    FD["survey_attribute_note"] = $('#attr_note').val().trim();
                    FD["survey_title_id"] = $('#title_comboParam').val();
                    break;
                case 'sel_value':
                    FD["survey_value_name"] = $('#attr_val_name').val().trim();
                    FD["suray_param_attributes_id"] = parseInt($('#sel_value').val());
                    break;
                case 'param_type_t':
                    FD["survey_parameter_id"] = $('#param_combo').val();
                    FD["survey_attribute_id"] = $('#attr_combo').val();
                    FD["type"] = $('#survey_type').val();
                    break;
            }
            return FD;
        }
        function set_selected_form_data(sel_row) {
//            alert(F_TAB);
            switch (F_TAB) {
                case 'title_t':
                    $('#delete_title').val(sel_row.id);
                    $('#title_text').val(sel_row.name);
                    break;
                case 'param_t':
                    $('#param_name').val(sel_row.name);
                    $('#delete_param').val(sel_row.id);
                    break;
                case 'attr_t':
                    $('#title_combo').val(sel_row.survey_title_id);
                    $('#survey_type').val(sel_row.type);
                    $('#attr_name').val(sel_row.name);
                    $('#attr_note').val(sel_row.note);
                    $('#delete_attr').val(sel_row.id);
                    break;
                case 'custom-tabs-two-messages-tab':
                    $('#attr_combo').val(sel_row.survey_attribute_id);
                    $('#attr_val_name').val(sel_row.name);
                    $('#attr_val_delete').val(sel_row.id);
                    break;
                case 'param_type_t':
                    $('#attr_param_val_del').val(sel_row.id);
                    break;
            }
        }
        function reset_form_data() {
//            alert(F_TAB);
            switch (F_TAB) {
                case 'title_t':
                    $('#delete_title').val('');
                    $('#title_text').val('');
                    break;
                case 'param_t':
                    $('#param_name').val('');
                    $('#delete_param').val('');
                    break;
                case 'attr_t':
                    $('#attr_name').val('');
                    $('#delete_attr').val('');
                    break;
                case 'sel_value':
                    $('#sel_value').val('');
                    $('#attr_val_name').val('');
                    $('#attr_val_delete').val('');
                    break;
            }
        }
        function load_survTable() {
//            alert(F_TAB);
            switch (F_TAB) {
                case 'title_t':
                    load_titleTable();
                    break;
                case 'param_t':
                    load_paramTable(parseInt($('#title_comboParam').val()));
                    break;
                case 'attr_t':
                    load_attributeTable(parseInt($('#title_comboParam').val()));
                    break;
                case 'param_type_t':
                    load_attr_param_Table(parseInt($('#attr_combo').val()));
                    load_avl_paramCombo(parseInt($('#title_comboParam').val()), parseInt($('#attr_combo').val()));//available parameter combo
                    break;
            }
        }

//Initialize Select2 Elements
        $('.select2').select2();
        $("#tblUsers").DataTable();
        $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
            F_TAB = $(e.target).attr("id");
            switch (F_TAB) {
                case 'param_t':
                    load_paramTable(parseInt($('#title_comboParam').val()));
                    break;
                case 'attr_t':
                    load_attributeTable(parseInt($('#title_comboParam').val()));
                    break;
                case 'param_type_t':
                    load_attrCombo(parseInt($('#title_comboParam').val()), function () {
                        load_avl_paramCombo(parseInt($('#title_comboParam').val()), parseInt($('#attr_combo').val()));//available parameter combo
                        load_attr_param_Table(parseInt($('#attr_combo').val()));
                    });
                    break;
                case 'sur_priv':
                    gen_priv($('#title_comboParam').val());
                    break;
            }
//            alert(F_TAB);
        });
    });
</script>
@endsection
