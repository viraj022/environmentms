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
{{--    {{dump($pageAuth)}}--}}
    @if($pageAuth['is_read']==1 || false)
        {{--    <h1>{{$p['name']}}</h1>--}}
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12 col-sm-6">
                        <h1>Environment Protection License</h1>
                    </div>
                </div>
            </div>
        </section>



        <section class="content-header">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    @if($pageAuth['is_create']==1 || false)
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <label>Attachment Upload</label>
                                </div>

                                <form method="POST" action="/users">
                                    @csrf
                                    <div class="card-body" id="div_file_input">
                     




                                <div class="card-footer">
                                <!--         <button type="submit" class="btn btn-success">Register</button> -->
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
     
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
  
//GetAttachmentsBy_Application('Environment Protection Licence');
loadAttachmentList();

function loadAttachmentList() {
var html ;
   GetAttachmentsBy_Application('Environment Protection Licence',function (result) {
 
        $.each(result, function (index, value) {
html= '<div class="form-group">';
html+= '<label for="exampleInputFile" class="col-9">'+value.name+'</label>';
html+= '<input type="file" id="'+value.id+'" class="col-3">';
html+= '</div>';
          
       $( "#div_file_input" ).append(html);
        });
    });
}

    </script>
@endsection
