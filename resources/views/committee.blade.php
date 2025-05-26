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
    @if ($pageAuth['is_read'] == 1 || false)
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>File No: (<a href="/industry_profile/id/{{ $client }}">{{ $file_no }}</a>) -
                            Committee</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-5">
                        <div class="card card-gray">
                            <div class="card-header">
                                <label id="lblTitle">Create New Committee</label>
                            </div>
                            <div class="card-body">
                                <input id="getSiteClearanceId" value="{{ $id }}" type="text"
                                    class="form-control form-control-sm d-none">
                                <div class="form-group">
                                    <label>Name*</label>
                                    <input id="getFname" type="text" class="form-control form-control-sm"
                                        placeholder="Enter attachment..." value="">
                                    <div id="valFname" class="d-none">
                                        <p class="text-danger">First Name is required!</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Date*</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input id="date" name="datepickerUi" type="text" data-date=""
                                            data-date-format="YYYY MM DD" max="2999-12-31"
                                            class="form-control form-control-sm" placeholder="Enter Issue Date..."
                                            value="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Member*</label>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <select id="getCommitUser" class="form-control form-control-sm">
                                                <option value="#">--</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5">
                                            <button id="btnAddMember" type="submit" class="btn btn-success">Add</button>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped" id="tblComMembers">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>First Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer">
                                @if ($pageAuth['is_create'] == 1 || false)
                                    <button id="btnSave" type="button" class="btn btn-primary">Save</button>
                                @endif
                                @if ($pageAuth['is_update'] == 1 || false)
                                    <button id="btnUpdate" type="button" class="btn btn-warning d-none">Update</button>
                                @endif
                                @if ($pageAuth['is_delete'] == 1 || false)
                                    <button id="btnDelete" type="button" class="btn btn-danger d-none">Delete</button>
                                @endif
                                <button id="btnReset" type="submit" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-7">
                        <div class="card card-gray">
                            <div class="card-header">
                                <h3 class="card-title">Committees</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body table-responsive" style="height: 450px;">
                                    <table class="table table-bordered table-striped" id="tblCommittees">
                                        <thead>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Name</th>
                                                <th>Schedule Date</th>
                                                <th>Comment</th>
                                                <th>Action</th>
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
    <script src="../../js/CommitteeSourceJS/committee_data.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script>
        var ITEM_LIST = [];
        $(function() {
            //Load table
            committeeMemberCombo();
            getCommitteeTableUI();
            //click save button
            $('#btnSave').click(function() {
                var data = fromValues();
                methodCommitteeAPI(data, 1, null, function(resp) {
                    if (resp.id === 1) {
                        getCommitteeTableUI();
                        resetinputFields();
                    }
                    show_mesege(resp);
                });
            });
            //click update button
            $('#btnUpdate').click(function() {
                var data = fromValues();
                methodCommitteeAPI(data, 2, $(this).val(), function(resp) {
                    if (resp.id === 1) {
                        getCommitteeTableUI();
                        resetinputFields();
                    }
                    show_mesege(resp);
                });
            });
            //click delete button
            $('#btnDelete').click(function() {
                methodCommitteeAPI(null, 3, $(this).val(), function(resp) {
                    if (resp.id === 1) {
                        getCommitteeTableUI();
                        resetinputFields();
                    }
                    show_mesege(resp);
                });
            });
            //Select button action
            $(document).on('click', '.btnAction', function() {
                methodCommitteeAPI(null, 4, $(this).val(), function(e) {
                    $('#getFname').val(e.name);
                    $('#date').val(e.schedule_date);
                    selectedApplication_table(e.commety_pool);
                });
                $('#btnUpdate').val($(this).val());
                $('#btnDelete').val($(this).val());
                showUpdate();
            });

            $('#btnAddMember').click(function() {
                add_itemToBill();
            });

            // $('input[name="datepickerUi"]').daterangepicker({
            //     singleDatePicker: true,
            //     locale: {
            //         format: 'YYYY-MM-DD'
            //     }
            // });

            function add_itemToBill() {
                let member_id = parseInt($('#getCommitUser').val());
                let member_name = $('#getCommitUser :selected').html();
                if (isValueExsist(member_id)) {
                    alert('"' + member_name + '" already added !');
                    return false;
                }
                if (isNaN(member_id)) {
                    alert("invalid Application Type!");
                    return false;
                }
                ITEM_LIST.push({
                    id: member_id,
                    first_name: member_name
                });
                selectedApplication_table(ITEM_LIST);
            }

            function isValueExsist(value) {
                let ret = false;
                $.map(ITEM_LIST, function(val) {
                    if (val.id == value) {
                        ret = true;
                    }
                });
                return ret;
            }
            //Member remove button action
            $(document).on('click', '.app_removeBtn', function() {
                remove_itemFrom_bill($(this).val());
            });

            function remove_itemFrom_bill(rem_val) {
                // get index of object with id:37
                var removeIndex = ITEM_LIST.map(function(item) {
                    return item.id;
                }).indexOf(rem_val);
                // remove object
                ITEM_LIST.splice(removeIndex, 1);
                selectedApplication_table(ITEM_LIST);
            }

        });

        //Reset
        $('#btnReset').click(function() {
            resetinputFields();
            hideAllErrors();
            $('#valContact').addClass('d-none');
            $('#valNic').addClass('d-none');
            showSave();
        });
        //show update buttons
        function showUpdate() {
            $('#btnSave').addClass('d-none');
            $('#btnUpdate').removeClass('d-none');
            $('#btnDelete').removeClass('d-none');
        }
        //show save button
        function showSave() {
            $('#btnSave').removeClass('d-none');
            $('#btnUpdate').addClass('d-none');
            $('#btnDelete').addClass('d-none');
        }
        //Reset all fields
        function resetinputFields() {
            $('#getFname').val('');
            $('#date').val('');
            selectedApplication_table('');
            showSave();
        }
        //HIDE ALL ERROR MSGS
        function hideAllErrors() {
            $('#valUnique').addClass('d-none');
            $('#valNic').addClass('d-none');
            $('#valContact').addClass('d-none');
        }
        //get form values
        function fromValues() {
            var nameArray = ITEM_LIST.map(function(el) {
                return el.id;
            });
            var data = {
                name: $('#getFname').val(),
                site_clearence_session_id: $('#getSiteClearanceId').val(),
                schedule_date: $('#date').val(),
                members: nameArray
            };
            return data;
        }
    </script>
@endsection
