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
            <h1 class="mb-3">Director Certificate approved files</h1>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card border border-primary">
                        <form action="{{ route('minutes-report-list') }}" method="post">
                            @csrf
                            <div class="card-header bg-primary text-white">
                                Search Director Certificate approved files
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="start_data">Start Date</label>
                                    <input type="date" name="start_data" id="start_data" class="form-control"
                                        value="{{ $start_data }}">
                                </div>
                                <div class="mb-3">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ $end_date }}">
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                {{-- @dd($minutes_data) --}}
                <div class="col-lg-12">
                    @if (empty($minutes_data))
                        <div class="alert alert-info">
                            Please select a date to view completed Files.
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body">
                                <table class="table" id="completed_files_table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Industry File</th>
                                            <th>EPL/Sc</th>
                                            <th>Minute</th>
                                            <th>Minuted at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($minutes_data as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td><a href="{{ url('industry_profile/id/'.$value->client->id) }}" target="_blank">{{ $value->client->file_no }} - {{ $value->client->industry_name }}</a></td>
                                                <td>@if ($value->file_type=='epl')
                                                    EPL
                                                @elseif ($value->file_type=='site_clearance')
                                Site Clearance
                                @endif
                                            </td>
                                                <td>{{ $value->minute_description }}</td>
                                                <td>{{ Carbon\Carbon::parse($value->updated_at)->format('Y-m-d') }}</td>
                                                {{-- <td>{{ $value->updated_at }}</td> --}}

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="12">No available completed files</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
    <script src="../../dist/js/adminlte.min.js"></script>
    <script src="../../dist/js/demo.js"></script>
    <script>
        $(document).ready(function() {
            $('#completed_files_table').DataTable();
        });
    </script>
@endsection
