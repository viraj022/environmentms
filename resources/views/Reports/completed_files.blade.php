@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
    <link rel="stylesheet" type="text/css" href="/dataTable/datatables.min.css" />
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="mb-3">Completed Files</h1>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card border border-primary">
                        <form action="{{ route('completed-files-list') }}" method="post">
                            @csrf
                            <div class="card-header bg-primary text-white">
                                Search completed files
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
                {{-- @dd($result) --}}
                <div class="col-lg-12">
                    @if (empty($result))
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
                                            <th>Industry Name</th>
                                            <th>File no</th>
                                            <th>EPL/Sc</th>
                                            <th>License no</th>
                                            <th>Pradeshiya sabha</th>
                                            <th>File category</th>
                                            <th>File subcategory</th>
                                            <th>Assistant director</th>
                                            <th>Issue date</th>
                                            <th>Expire date</th>
                                            <th>Director approval date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($result as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value->industry_name }}</td>
                                                <td>{{ $value->file_number }}</td>
                                                <td>{{ $value->code }}</td>
                                                <td>{{ $value->certificate_number }}</td>
                                                <td>{{ $value->pradesheeyasaba }}</td>
                                                <td>{{ $value->industry_category }}</td>
                                                <td>{{ $value->industry_sub_category }}</td>
                                                <td>{{ substr(str_replace('and the team', '', $value->Ad_name), 18) }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($value->issue_date)->format('Y-m-d') }}</td>
                                                <td>{{ Carbon\Carbon::parse($value->expire_date)->format('Y-m-d') }}</td>
                                                <td>{{ Carbon\Carbon::parse($value->director_approve_date)->format('Y-m-d') }}
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
    <script>
        $(document).ready(function() {
            $('#completed_files_table').DataTable();
        });
    </script>
@endsection
