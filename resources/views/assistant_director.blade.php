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
                <h1>Assistant Director</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-5">
                <div class="card card-success">
                    <div class="card-header">
                        <label id="lblTitle">Add New Assistant Director</label>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Zone*</label>
                            <select id="getZone" class="form-control form-control-sm select2 select2-purple" data-dropdown-css-class="select2-purple"
                                                    style="width: 100%;" name="level">
                                <option>Loading...</option>
                            </select>
                            <div id="valZone" class="d-none"><p class="text-danger">Field is required</p></div>
                        </div>

                        <div class="form-group" id="comboUserDiplay">
                            <label>Users*</label>
                            <select id="getUsers" class="form-control form-control-sm select2 select2-purple" style="width: 100%;" name="level">
                                <option>Loading...</option>
                            </select>
                            <div id="valUsers" class="d-none"><p class="text-danger">Field is required</p></div>
                        </div>

                        <div class="form-group d-none" id="lblUserDiplay">
                            <label>Users</label>
                            <label  id="lblUserName" class="form-control form-control-sm"></label>
                        </div>


                    </div>
                    <div class="card-footer">
                       <button id="btnReset" type="submit" class="btn btn-info d-none">Reset</button>
                       @if($pageAuth['is_create']==1 || false)
                       <button id="btnSave" type="submit" class="btn btn-success">Save</button>
                       @endif
                       @if($pageAuth['is_update']==1 || false)
                       <button id="btnUpdate" type="submit" class="btn btn-warning d-none">Update</button>
                       @endif
                       @if($pageAuth['is_delete']==1 || false)
                       <button  id="btnshowDelete" type="submit" class="btn btn-danger d-none"  data-toggle="modal"
                       data-target="#modal-danger">Delete</button>
                       @endif
                   </div>                           
               </div>
           </div>


           <div class="col-md-7">
            <div class="card card-success">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">All Assistant Directors</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <div class="card-body table-responsive" style="height: 450px;">
                                        <table class="table table-condensed" id="tblAssistantDirectors">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Assistant Director Name</th>
                                                    <th>User Name</th>
                                                    <th>Zone Name</th>
                                                    <th style="width: 140px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>                                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Delete Selected Item</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b>Are you sure you want to permanently delete this Item? </b></p>
                <p>Once you continue, this process can not be undone. Please Procede with care.</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                <button id="btnDelete" type="submit" class="btn btn-outline-light" data-dismiss="modal">Delete Permanently</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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
<script src="../../js/AssistantDirJS/submit.js"></script>
<script src="../../js/AssistantDirJS/get.js"></script>
<script src="../../js/AssistantDirJS/update.js"></script>
<script src="../../js/AssistantDirJS/delete.js"></script>
<!-- AdminLTE App -->
<script>
    $(function () {
//Load table

        //loadTable();
        loadZoneCombo();
        loadUsersCombo();
        loadTable();
//click save button
$('#btnSave').click(function () {
    var data = 
    {
        "user_id":$('#getUsers').val(),
        "zone_id":$('#getZone').val()
    }
    //alert(JSON.stringify(data));

    AddAssistantDir(data, function (result) {
        if (result.id == 1) {
            Toast.fire({
                type: 'success',
                title: 'Enviremontal MS</br>Saved'
            });

        } else {
            Toast.fire({
                type: 'error',
                title: 'Enviremontal MS</br>Error'
            });
        }
         loadZoneCombo();
    loadUsersCombo();
    loadTable();
    });

});
//click update button
$('#btnReset').click(function () {
    showSaveBtn();
    loadZoneCombo();
    loadUsersCombo();
    loadTable();
});
//click delete button
$('#btnDelete').click(function () {
    //alert('delete btn');
    deleteAssistantDir($('#btnDelete').val(), function (result) {
        if (result.id == 1) {
            Toast.fire({
                type: 'success',
                title: 'Enviremontal MS</br>Removed!'
            });
            
        } else {
            Toast.fire({
                type: 'error',
                title: 'Enviremontal MS</br>Error'
            });
        }
        loadZoneCombo();
    loadUsersCombo();
    loadTable();
            showSaveBtn();

       // resetinputFields();
        //hideAllErrors();
    });
});
//select button action 
$(document).on('click', '.btnAction', function () {
    getaAssistantDirbyId(this.id, function (result) {
        //alert(result.id);
        $('#lblUserName').text(result.first_name+' '+result.last_name);
        $('#getZone').val(result.zone_id);

        $('#btnUpdate').val(result.id);
        $('#btnDelete').val(result.id);
        showUpdate_DeleteBtn();
    });
    hideAllErrors();
});
});
//show update buttons    
function showUpdate_DeleteBtn() {
    $('#btnSave').addClass('d-none');
    //$('#btnUpdate').removeClass('d-none');
    $('#btnshowDelete').removeClass('d-none');
    $('#btnReset').removeClass('d-none');

    $('#comboUserDiplay').addClass('d-none');
    $('#lblUserDiplay').removeClass('d-none');
}
//show save button    
function showSaveBtn() {
    $('#btnReset').addClass('d-none');
    $('#btnSave').removeClass('d-none');
    $('#btnUpdate').addClass('d-none');
    $('#btnshowDelete').addClass('d-none');
    $('#lblUserDiplay').addClass('d-none');
    $('#comboUserDiplay').removeClass('d-none');

}
//Reset all fields    
function resetinputFields() {
    $('#getName').val('');
    $('#getCode').val('');
    $('#btnUpdate').val('');
    $('#btnDelete').val('');
}

//HIDE ALL ERROR MSGS   
function hideAllErrors() {
    $('#valName').addClass('d-none');
    $('#valCode').addClass('d-none');
    $('#uniName').addClass('d-none');
    $('#uniCode').addClass('d-none');
}
</script>
@endsection
