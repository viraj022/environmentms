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
                                    <input type="date" name="start_data" id="start_data" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="end_date">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    @if (empty($completedEPL))
                        <div class="alert alert-info">
                            Please select a date to view completed Files.
                        </div>
                    @else
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Industry Name</th>
                                            <th>File no</th>
                                            <th>EPL</th>
                                            <th>SC</th>
                                            <th>License no</th>
                                            <th>Pradeshiya sabhawa</th>
                                            <th>File category</th>
                                            <th>File subcategory</th>
                                            <th>Assistant director</th>
                                            <th>Issue date</th>
                                            <th>Expire date</th>
                                            <th>Director approval date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($completedEPL as $completedEPLs)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $completedEPLs->client->industry_name }}</td>
                                                <td>{{ $completedEPLs->client->file_no }}</td>
                                                <td>{{ $completedEPLs->code }}</td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ $completedEPLs->client->pradesheeyasaba->name }}</td>
                                                <td>{{ $completedEPLs->client->industryCategory->name }}</td>
                                                <td>{{ $completedEPLs->client->industry_sub_category }}</td>
                                                <td></td>
                                                <td>{{ $completedEPLs->issue_date }}</td>
                                                <td>{{ $completedEPLs->expire_date }}</td>
                                                <td></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="13">No available completed files</td>
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
