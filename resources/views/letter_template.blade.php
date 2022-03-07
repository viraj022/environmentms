@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Letter Writer @if (@isset($template->template_name))
                            editing - {{ $template->template_name }}
                        @endif
                    </h1>
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
                                    <label>Letter Template Name*</label>
                                    <input type="text" class="form-control" name="letter_temp_name" id="letter_temp_name"
                                        placeholder="Enter the letter template name"
                                        value="{{ isset($template->template_name) ? $template->template_name : '' }}">
                                </div>
                                @if (isset($template->template_name))
                                    <a href="/letter_template" class="btn btn-dark">Back</a>
                                    <button class="btn btn-warning" id="updateLetTemp">Update</button>
                                @else
                                    <button class="btn btn-success" id="saveLetTemp">Save</button>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-gray">
                            <div class="card-header">
                                <h4 class="card-title">Letter Templates</h4>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="letter_temp_tbl">
                                    <thead>
                                        <tr>
                                            <th>Template Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr></tr>
                                    </tbody>
                                </table>
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
                            <textarea name="editor1">{{ isset($template->content) ? $template->content : '' }}</textarea>
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

        $(document).ready(function() {
            load_templates();
        });

        $('#saveLetTemp').click(function() {
            save_template();
        });

        $('#updateLetTemp').click(function() {
            update_template();
        });


        function save_template() {

            const data = {
                template_name: $('#letter_temp_name').val()
            };

            let url = "/api/create_let_template";
            if (data.template_name != '') {
                ajaxRequest('POST', url, data, function(resp) {
                    if (resp.status == 1) {
                        swal.fire('success', 'Successfully save the letter template', 'success');
                        location.reload();
                    } else {
                        swal.fire('failed', 'Letter template saving was unsuccessful', 'warning');
                    }
                });
            } else {
                swal.fire('failed', 'template name is required to create letter template', 'warning');
            }
        }


        function update_template() {
            var temp_id = "{{ isset($template->id) ? $template->id : '' }}";
            let data = {
                "template_id": temp_id,
                "template_name": $('#letter_temp_name').val(),
                "template_content": EDITOR_DATA.getData()
            };
            let url = '/api/update_let_template';

            if (data.template_name != '' && data.template_content != '' && data.template_id != '') {
                ajaxRequest('POST', url, data, function(resp) {
                    if (resp.status == 1) {
                        swal.fire('success', 'letter content updation is successfull', 'success');
                    } else {
                        swal.fire('failed', 'letter content updation was unsuccessful', 'warning');
                    }
                });
            } else {
                swal.fire('failed', 'document content is required to update letter template', 'warning');
            }
        }

        function load_templates() {
            let url = '/api/load_templates';
            ajaxRequest('GET', url, null, function(resp) {
                var template_tbl = " ";
                $.each(resp, function(key, value2) {
                    template_tbl += "<tr><td>" + value2.template_name + "</td><td><a href='/load_temp/id/" +
                        value2.id +
                        "' class='btn btn-primary mr-2'>Edit</a></td></tr>";
                });
                $('#letter_temp_tbl tbody').html(template_tbl);
                // $('#letter_temp_tbl').DataTable({
                //     aLengthMenu: [
                //         [10, 25, 50, 100, -1],
                //         [10, 25, 50, 100, "All"]
                //     ],
                //     "bDestroy": true,
                //     iDisplayLength: 10
                // });
            });

        }
    </script>
@endsection
