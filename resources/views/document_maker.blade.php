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
                                <input type="text" class="form-control" name="letter_title" id="letter_title" placeholder="Enter the letter title" value="{{$letter_title}}">
                            </div>
                            @if($letter_status != 'COMPLETED')
                            <button class="btn btn-success" id="updateLetter">Update</button>
                            <button class="btn btn-dark" id="completeLetter">Complete</button>
                            @else
                            <h3><span class="text-danger">Completed</span></h3>
                            @endif
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
                        <textarea name="editor1">{{$letter_content}}</textarea>
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
    $('#updateLetter').click(function() {
        update_doc();
    });

    $('#completeLetter').click(function() {
        complete_doc();
    });


    function complete_doc() {

        Swal.fire({
            title: 'Once you complete you cant edit this letter?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'confirm',
            denyButtonText: `Don't confirm`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.value) {
                let letter_id = "{{$id}}";
                let url = "/api/letter_status_change/status/COMPLETED/letter/"+letter_id;
                ajaxRequest('POST', url, null, function(resp) {
                   if (resp.status == 1) {
                       swal.fire('success', 'Successfully completed the letter', 'success');
                       location.reload();
                   } else {
                       swal.fire('failed', 'Letter completion was unsuccessful', 'warning');
                   }
              });
            } else if (result.isDenied) {
                Swal.fire('Canceled!', 'Confirmation was cancelled', 'info')
            }
        })

       
    }


    function update_doc() {
        let data = {
            "content": EDITOR_DATA.getData(),
            "letter_id": "{{$id}}",
            "letter_title": $('#letter_title').val()
        };
        let url = '/api/update_document';
        if (data.content != '' && data.complain_id != '') {
            ajaxRequest('POST', url, data, function(resp) {
                if (resp.status == 1) {
                    swal.fire('success', 'letter content updation is successfull', 'success');
                } else {
                    swal.fire('failed', 'letter content updation was unsuccessful', 'warning');
                }
            });
        } else {
            swal.fire('failed', 'complain id and document content are required to update letter', 'warning');
        }
    }
</script>
@endsection
