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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">

    <style>
        .attachment_image {
            position: relative;
            width: 100%;
        }

        .attachment_image .delete_attachment {
            position: absolute;
            top: 5px;
            right: 15px;
        }
    </style>
@endsection

@section('content')
    @if ($pageAuth['is_read'] == 1 || false)
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>(<a href="/inspection/epl/remarks/id/{{ $id }}">{{ $file_no }}</a>)
                            {{ $inspec_date }} Inspection Images</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="content-header">
            <!-- Default box -->

            <div class="row">
                <div class="col-md-4">
                    <div class="card card-gray">
                        <div class="card-header">
                            <label id="lblTitle">Add New Attachment</label>
                        </div>
                        <div class="card-body">
                            <div class="form-group" id="useToHideAmount">
                                <label>Attachment *</label>
                                <input id="fileInput" type="file" accept="image/*" class="form-control" value="">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="btnSave" type="button" class="btn btn-success">Save File</button>
                        </div>
                        <div class="overlay dark disInspection">
                            <p class="text-white"><i class="fa fa-check"></i> Inspection Completed </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="card card-gray">
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

    <script src="/../../plugins/moment/moment.min.js"></script>
    <script src="/../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
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
    <script src="/../../js/InspectionRemarksJS/inspection_status.js" type="text/javascript"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>

    <script>
        //    $(function () {
        var ID = "{{ $id }}";
        const file_url="{{ env('DO_URL') }}/";
        getaAttachmentbyId(ID, function(res) {
            iterateSavedImages(res,file_url);
        });
        loadInspectionStatusAPI(ID, function(resp) { //<-- Get Inspection Status
            if (resp.status === 0) {
                $('.disInspection').removeClass('overlay'); //Remove If inspection not completed
            } else {
                $('.disInspection').addClass('overlay');
            }
        });

        $(document).on('click', '.removeImage', function() {
            if (confirm('Are you sure you want to remove this Image?')) {
                remove_Image($(this).val(), function(parameters) {
                    if (parameters.id == 1) {
                        getaAttachmentbyId(ID, function(res) {
                            iterateSavedImages(res,file_url);
                        });
                        $('.ekko-lightbox').modal('hide');
                    }
                });
            }
        });
        $(document).on('click', '#btnSave', function() {
            let file = $('#fileInput')[0].files[0];
            save_Attachment(ID, {
                'file': file
            }, function(parameters) {
                show_mesege(parameters);
                if (parameters.id == 1) {
                    getaAttachmentbyId(ID, function(res) {
                        iterateSavedImages(res,file_url);
                    });
                    $('#fileInput').val('');
                }
            });
        });
        //    });
        $(function() {
            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
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
        });

        $(document).on('click', '.delete_attachment', function() {
            let attid = $(this).data("attachment_id");
            if (confirm('Are you sure you want to delete this attachment?')) {
                remove_Image(attid, function(p) {
                    if (p.id == '1') {
                        getaAttachmentbyId(ID, function(res) {
                            iterateSavedImages(res,file_url);
                        });
                    }
                });
            }
        });
    </script>
@endsection
