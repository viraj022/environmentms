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
                <h1>(<a href="/epl_profile/client/{{$client}}/profile/{{$epl_id}}">{{$epl_number}}</a>) - Attachment Upload</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <!--                    <div class="card-header">
                                            <label id="lblTitle">Un-assigned EPL</label>
                                        </div>-->
                    <div class="card-body">
                        <table class="table table-condensed" id="tblAttachments">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Attachments</th>
                                    <th style="">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
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
<!-- AdminLTE App -->
<script src="/../../dist/js/adminlte.min.js"></script>
<script src="/../../js/attachmentsjs/get.js"></script>
<!-- AdminLTE for demo purposes -->

<script>
    
//    $(function () {
var EPL_ID = "{{$epl_id}}";
all_attachmentsList(EPL_ID);

$(document).on('click', '.removeAttachment', function () {
    if (confirm('Are you sure you want to remove this attachment?')) {
        removeEPL_Attachment(EPL_ID, $(this).val(), function (parameters) {
            if (parameters.id == 1) {
                Toast.fire({
                    type: 'success',
                    title: 'Enviremontal MS</br>Attachment Succuessfully Removed !'
                });
                all_attachmentsList(EPL_ID);
            } else {
                Toast.fire({
                    type: 'error',
                    title: 'Enviremontal MS</br>Error'
                });
            }
        });
    }
});
$(document).on('change', '.fileInput', function () {
    let selector = $(this);
    readImage(selector.attr('id'), function (img) {
        if (img) {
//                alert(JSON.stringify(img));
            if (confirm('Are you sure you want to upload this attachment?')) {
                saveEPL_Attachment(img, EPL_ID, selector.data('attachment_id'), function (parameters) {
                    if (parameters.id == 1) {
                        Toast.fire({
                            type: 'success',
                            title: 'Enviremontal MS</br>Attachment Succuessfully Uploaded !'
                        });
                        all_attachmentsList(EPL_ID);
                    } else if (parameters.id == 0) {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>' + parameters.message
                        });

                    } else {
                        Toast.fire({
                            type: 'error',
                            title: 'Enviremontal MS</br>Error'
                        });
                    }
                });
            }
        }
    });
});
//    });
</script>
@endsection
