@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
{{-- @extends('layouts.footer') --}}
@section('pageStyles')
    <!-- This section didnt work for me -->

    <style>
        /* SHADE DAYS IN THE PAST */
        td.fc-day.fc-past {
            background-color: #EEEEEE;
        }

        table.dataTable td {
            word-break: break-word;
        }

    </style>
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Letter view</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    {{-- <div class="sticky-top mb-3"> --}}
                        <div class="card">
                            <div class="card-body">
                                <div id="letter_container">
                                    <div class="form-group">
                                        {{-- <h5><label>Letter Title: </label></h5> --}}
                                        <h4 class="text-center"><b>{{ $letter->letter_title }}</b></h4>
                                    </div>
                                    <hr>
                                    <div class="form-group d-flex justify-content-center pt-5">
                                        {{-- <h5><label>Content: </label></h5> --}}
                                        <div style="width: 21cm; height: 29.7cm"><div>{!! $letter->letter_content !!}</div></div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    {{-- </div> --}}
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection



@section('pageScripts')
    <!-- Page script -->

    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <script>

    </script>
@endsection
