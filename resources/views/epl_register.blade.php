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

<div class="modal fade" id="modal-danger">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h4 class="modal-title">Delete Attachment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><b>Are you sure you want to permanently delete this Attachment ? </b></p>
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
<script src="../../js/attachmentsjs/submit.js"></script>
<script src="../../js/attachmentsjs/get.js"></script>
<script src="../../js/attachmentsjs/update.js"></script>
<script src="../../js/attachmentsjs/delete.js"></script>
<!-- AdminLTE App -->
<script>
$(function(){
       alert({{$id}});
{{-- function readFile() {
  
  if (this.files && this.files[0]) {
    
    var FR= new FileReader();
    
    FR.addEventListener("load", function(e) {
      document.getElementById("img").src       = e.target.result;
      document.getElementById("b64").innerHTML = e.target.result;
      AddPayments({"name": e.target.result},function(){
          alert("Message Sent");
      })
    }); 
    
    FR.readAsDataURL( this.files[0] );
  }
  
} --}}

{{-- document.getElementById("inp").addEventListener("change", readFile); --}}
$("#btnSave").click(function(){
    alert("wada");
  var img =  document.getElementById("inp")
      if (img.files && img.files[0]) {
    
    var FR= new FileReader();
    
    FR.addEventListener("load", function(e) {
      document.getElementById("img").src       = e.target.result;
      document.getElementById("b64").innerHTML = e.target.result;
      AddPayments({"file": e.target.result},function(){
          alert("Message Sent");
      })
    }); 
    
    FR.readAsDataURL( img.files[0] );
  }else{
      alert("No Image")
  }
    });
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

    
}
</script>
@endsection
