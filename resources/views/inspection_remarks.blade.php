@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<!-- Select2 -->
<link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
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
                <h1>(<a href="/industry_profile/id/{{$file_id}}">{{$file_no}}</a>) {{$inspec_date}} Inspection Comments</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="row" id="showUiDb">

                </div>
                <!--Add New Comment Section-->
                <div class="card card-primary">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Add New Comment</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Comment*</label>
                                            <input id="getComment" type="text" class="form-control form-control-sm" placeholder="Enter Your Comment" value="">
                                            <a class="error invalid-feedback aefFGE d-none">Please enter your comment</a>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        @if($pageAuth['is_create']==1 || false)
                                        <button id="btnSave" type="submit" class="btn btn-success">Save</button>
                                        @endif
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div> 
                <!--Add New Comment END-->
            </div>
            <div class="col-md-4">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bullhorn"></i>
                            Callouts
                        </h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="callout callout-success">
                            <h5><a href="/inspection/personals/id/{{$id}}" class="text-success font-weight-bold ">Add Personals</a></h5>

                            <p>Personals who participated in the inspection</p>
                        </div>
                        <div class="callout callout-success">
                            <h5><a href="/inspection_attachment/id/{{$id}}" class="text-success font-weight-bold ">Add Attachments</a></h5>

                            <p>Add images, attachment in inspection</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>

            <div class="col-md-8">

            </div>
        </div>
<!--        <div class="modal fade" id="modal-danger">
            <div class="modal-dialog">
                <div class="modal-content bg-danger">
                    <div class="modal-header">
                        <h4 class="modal-title">Delete Selected Remark</h4>
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
                 /.modal-content 
            </div>
             /.modal-dialog 
        </div>-->
</section>
@endif
@endsection



@section('pageScripts')
<!-- Page script -->

<!-- Select2 -->
<script src="/../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="/../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="/../../plugins/moment/moment.min.js"></script>
<script src="/../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="/../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="/../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="/../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="/../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="/../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/../../dist/js/demo.js"></script>
<script src="/../../js/InspectionRemarksJS/submit.js"></script>
<script src="/../../js/InspectionRemarksJS/get.js"></script>
<!--<script src="../../js/RemarksJS/update.js"></script>-->
<script src="/../../js/InspectionRemarksJS/delete.js"></script>
<!-- AdminLTE App -->
<script>
$(function () {
    var ID = "{{$id}}";
    loadInterface(ID);
//click save button
    $('#btnSave').click(function () {
        var data = fromValues();
        if (Validiteinsert(data)) {
            AddComment(data, ID, function (result) {
                if (result.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: 'Saved'
                    });
                } else {
                    Toast.fire({
                        type: 'error',
                        title: 'Error'
                    });
                }
                loadInterface(ID);
                resetinputFields();
            });
        }
    });

//Reset all fields    
    function resetinputFields() {
        $('#getComment').val('');
        $('#btnUpdate').val('');
        $('#btnDelete').val('');
    }
//get form values
    function fromValues() {
        var data = {
            remark: $('#getComment').val()
        };
        return data;
    }
});
</script>
@endsection
