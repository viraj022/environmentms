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
    <!--    Register New Client START-->
    <div class="container-fluid reg-newClient">
        <div class="row">
            <h1>{{$id}}</h1>
            <div class="col-md-12">
                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header">
                            <label id="lblTitle">Register New Business</label>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Pradeshiya Sabha*</label>
                                <select id="prsdeshiySb" class="form-control form-control-sm" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                                <label>Industry Category*</label>
                                <select id="industryCat" class="form-control form-control-sm" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                                <label>Business Scale*</label>
                                <select id="businesScale" class="form-control form-control-sm" style="width: 100%;"></select>
                            </div>
                            <div class="form-group">
                                <label>Business Registration Number*</label>
                                <input id="business_name" type="text" class="form-control form-control-sm" placeholder="Enter Number" value="">
                            </div>
                            <div class="form-group">
                                <label>Business Name*</label>
                                <input id="business_name" type="text" class="form-control form-control-sm" placeholder="Enter Name..." value="">
                            </div>

                            <div class="form-group">
                                <label>Is this Industry</label>
                                <select id="getZone" class="form-control form-control-sm" style="width: 100%;">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Address*</label>
                                <input id="getAddressT" type="text" class="form-control form-control-sm" placeholder="Enter Name..." value="">
                            </div>
                            <div class="form-group">
                                <label>Contact Number*</label>
                                <input id="" type="number" class="form-control form-control-sm" placeholder="10 digits" value="">
                            </div>
                            <div class="form-group">
                                <label>Start Date*</label>
                                <input id="startDate" type="date" class="form-control form-control-sm" placeholder="Enter Name..." value="">
                            </div>
                            <div class="form-group">
                                <label>Contact No*</label>
                                <input id="getContactn" type="text" class="form-control form-control-sm" placeholder="Enter Name..." value="">
                            </div>
                            <div class="form-group">
                                <label>Email*</label>
                                <input id="getEmail" type="text" class="form-control form-control-sm" placeholder="Enter Name..." value="">
                            </div>
                            <div class="form-group">
                                <label>Map*</label>
                                <iframe width="650" height="350" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/view?zoom=12&center=7.4818%2C80.3609&key=AIzaSyBAwqPnybWbCL3EbCT3pOF60c2d4JiYp4c" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($pageAuth['is_create']==1 || false)
                            <button id="btnSave" type="button" class="btn btn-success">Save</button>
                            @endif
                            @if($pageAuth['is_update']==1 || false)
                            <button id="btnUpdate" type="submit" class="btn btn-warning">Update</button>
                            @endif
                            @if($pageAuth['is_delete']==1 || false)
                            <button  id="btnshowDelete" type="submit" class="btn btn-danger"  data-toggle="modal"
                                     data-target="#modal-danger">Delete</button>
                            @endif

                            <input id="inp" type='file'>
                            <p id="b64"></p>
                            <img id="img" height="150">
                        </div>                           
                    </div>
                </div>
                <!--If something about Datatable place tt here again! -->
            </div>
        </div>
    </div>
    <!--Register New Client END-->

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
<script src="../../js/epl/epl_register.js"></script>
<script src="../../js/attachmentsjs/submit.js"></script>
<script src="../../js/attachmentsjs/get.js"></script>
<script src="../../js/attachmentsjs/update.js"></script>
<script src="../../js/attachmentsjs/delete.js"></script>
<!-- AdminLTE App -->
<script>
$(function(){
loadPradeshiyaSabha();
IndustryCategoryCombo();
BusinessScaleCombo();
//    alert({{$id}});
{{-- function readFile() {

if (this.files && this.files[0]) {

var FR = new FileReader();
FR.addEventListener("load", function(e) {
document.getElementById("img").src = e.target.result;
document.getElementById("b64").innerHTML = e.target.result;
AddPayments({"name": e.target.result}, function(){
alert("Message Sent");
})
});
FR.readAsDataURL(this.files[0]);
}

} --}}

{{-- document.getElementById("inp").addEventListener("change", readFile); --}}
//    $("#btnSave").click(function(){
//    alert("wada");
//    var img = document.getElementById("inp")
//            if (img.files && img.files[0]) {
//
//    var FR = new FileReader();
//    FR.addEventListener("load", function(e) {
//    document.getElementById("img").src = e.target.result;
//    document.getElementById("b64").innerHTML = e.target.result;
//    AddPayments({"file": e.target.result}, function(){
//    alert("Message Sent");
//    })
//    });
//    FR.readAsDataURL(img.files[0]);
//    } else{
//    alert("No Image")
//    }
//    });
});
function AddPayments(data, callBack) {
$.ajax({
type: "POST",
        headers: {
        "Authorization": "Bearer " + $('meta[name=api-token]').attr("content"),
                "Accept": "application/json"
        },
        url: "/api/epl",
        data: data,
        dataType: "json",
        cache: false,
        processDaate: false,
        success: function (result) {

        if (typeof callBack !== 'undefined' && callBack != null && typeof callBack === "function") {
        callBack(result);
        }
        },
        error: function (xhr, textStatus, errorThrown) {
        alert(textStatus + ':' + errorThrown);
        }
});
$("#btnSave").click(function(){
var data = fromValues();
if (Validiteinsert(data)) {
// if validiated
AddClient(data, function (result) {
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

});
}
});
}
</script>
@endsection
