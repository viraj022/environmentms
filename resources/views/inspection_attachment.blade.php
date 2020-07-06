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
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="/../../plugins/ekko-lightbox/ekko-lightbox.css">
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
                <h1>(<a href="/inspection/epl/remarks/id/{{$id}}">{{$epl_numner}}</a>) {{$inspec_date}} Inspection Images</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <!-- Default box -->

    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <label id="lblTitle">Add New Payment</label>
                </div>
                <div class="card-body">

                    <div class="form-group" id="useToHideAmount">
                        <label>Attachment *</label>
                        <input id="fileInput" type="file" class="form-control" value="">
                    </div>

                </div>
                <div class="card-footer">
                    <button id="btnSave" type="button" class="btn btn-success">Save File</button>
                </div>                           
            </div>
        </div>

        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h4 class="card-title">Images</h4>
                </div>
                <div class="card-body">
                    <div class="row" id="image_row"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- /.card -->

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
<!-- Ekko Lightbox -->
<script src="/../../plugins/ekko-lightbox/ekko-lightbox.js"></script>
<!--<script src="/../../plugins/ekko-lightbox/ekko-lightbox.min.js"></script>-->

<script src="/../../js/attachmentsjs/inspection_attachment.js"></script>
<!-- AdminLTE for demo purposes -->

<script>
//    $(function () {
var ID = "{{$id}}";
getaAttachmentbyId(ID, function (res) {
    iterateSavedImages(res);
});

$(document).on('click', '.removeImage', function () {
    if (confirm('Are you sure you want to remove this Image?')) {
        remove_Image($(this).val(), function (parameters) {
            if (parameters.id == 1) {
                Toast.fire({
                    type: 'success',
                    title: 'Enviremontal MS</br>Attachment Succuessfully Removed !'
                });
                getaAttachmentbyId(ID, function (res) {
                    iterateSavedImages(res);
                });
                $('.ekko-lightbox').modal('hide');
            } else {
                Toast.fire({
                    type: 'error',
                    title: 'Enviremontal MS</br>Error'
                });
            }
        });
    }
});
$(document).on('click', '#btnSave', function () {
    let selector = $('#fileInput');
    readImage(selector.attr('id'), function (img) {
        if (img) {
            save_Attachment(img, ID, function (parameters) {
                if (parameters.id == 1) {
                    Toast.fire({
                        type: 'success',
                        title: 'Enviremontal MS</br>Attachment Succuessfully Uploaded !'
                    });
                    getaAttachmentbyId(ID, function (res) {
                        iterateSavedImages(res);
                    });
                    $('#fileInput').val('');
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
    });
});
//    });
$(function () {
    $(document).on('click', '[data-toggle="lightbox"]', function (event) {
        event.preventDefault();
        $(this).ekkoLightbox({
            alwaysShowClose: true
        });
    });

//        $('.filter-container').filterizr({gutterPixels: 3});
//        $('.btn[data-filter]').on('click', function () {
//            $('.btn[data-filter]').removeClass('active');
//            $(this).addClass('active');
//        });
})
</script>
@endsection
