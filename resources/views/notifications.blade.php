@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('pageStyles')
    <link href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <style>
        table td {
            vertical-align: top;
            padding: 5px;
            word-break: break-all;
            /* MUST ADD THIS */
        }

    </style>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class=" mt-5 col-md-9">
                    <div class="card card-primary">
                        <div class="card-header"> Notification Table </div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered" id="complain_tbl">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Notification</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($notifications as $notification)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if ($notification->is_read == 0)
                                                    <i class="fas fa-envelope mr-2"></i>
                                                @else
                                                    <i class="fas fa-envelope-open mr-2"></i>
                                                @endif
                                                {{ $notification->message }}
                                            </td>
                                            <td>
                                                <a href="{{ route('userNotification.show', $notification) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Read
                                                </a>
                                            </td>
                                            <td>{{ $notification->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center"><b>No Data</b></td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>

    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="../../dist/js/adminlte.min.js"></script>

    <!-- Page script -->
    <script>

    </script>
@endsection
