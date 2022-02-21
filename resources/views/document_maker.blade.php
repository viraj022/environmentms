@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
    <!-- This section didnt work for me -->
    <!-- fullCalendar -->
    <link rel="stylesheet" href="../plugins/fullcalendar/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-daygrid/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-timegrid/main.min.css">
    <link rel="stylesheet" href="../plugins/fullcalendar-bootstrap/main.min.css">
    <style>
        /* SHADE DAYS IN THE PAST */
        td.fc-day.fc-past {
            background-color: #EEEEEE;
        }

    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Letter Writer</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky-top mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Letter Title*</label>
                                    <input type="text" class="form-control" name="letter_title" id="letter_title"
                                        placeholder="Enter the letter title">
                                </div>
                                <button class="btn btn-success" id="saveLetter">Save</button>
                                <button class="btn btn-dark" id="printLetter">Print</button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-gray">
                            <div class="card-header">
                                <h4 class="card-title">Events</h4>
                            </div>
                            <div class="card-body">
                                <!-- the events -->
                                <p class='text-success'>Loading...</p>

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card card-gray">
                        <div class="card-body p-0">
                            <textarea name="editor1"></textarea>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection



@section('pageScripts')
    <!-- Page script -->

    <!-- InputMask -->
    <script src="../../plugins/moment/moment.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../plugins/ckeditor/ckeditor.js"></script>
    <!-- AdminLTE App -->
    <script>
        CKEDITOR.editorConfig = function(config) {
            config.toolbarGroups = [{
                    name: 'document',
                    groups: ['mode', 'document', 'doctools']
                },
                {
                    name: 'clipboard',
                    groups: ['clipboard', 'undo']
                },
                {
                    name: 'editing',
                    groups: ['find', 'selection', 'spellchecker', 'editing']
                },
                {
                    name: 'forms',
                    groups: ['forms']
                },
                '/',
                {
                    name: 'basicstyles',
                    groups: ['basicstyles', 'cleanup']
                },
                {
                    name: 'paragraph',
                    groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']
                },
                {
                    name: 'links',
                    groups: ['links']
                },
                {
                    name: 'insert',
                    groups: ['insert']
                },
                '/',
                {
                    name: 'styles',
                    groups: ['styles']
                },
                {
                    name: 'colors',
                    groups: ['colors']
                },
                {
                    name: 'tools',
                    groups: ['tools']
                },
                {
                    name: 'others',
                    groups: ['others']
                },
                {
                    name: 'about',
                    groups: ['about']
                }
            ];

            config.removeButtons = 'Templates,RemoveFormat,CopyFormatting,CreateDiv,Anchor,Image,Smiley,Iframe';
        };
        var EDITOR_DATA = CKEDITOR.replace('editor1');
        $('#saveLetter').click(function() {
            save_doc();
        });

        function save_doc() {
            let data = {
                "title": $('#letter_title').val(),
                "content": EDITOR_DATA.getData()
            };
            let url = '/api/save_document/';
            if (data.title != '' && data.content != '') {
                ajaxRequest('POST', url, data, function(resp) {
                    if (resp.status == 1) {
                        swal.fire('success', 'letter saving is successfull', 'success');
                    } else {
                        swal.fire('failed', 'letter saving was unsuccessful', 'warning');
                    }
                });
            } else {
                swal.fire('failed', 'Title and content are required to save letter', 'warning');
            }
        }
    </script>
@endsection
