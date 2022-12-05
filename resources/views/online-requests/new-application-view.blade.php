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
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>New Application Request Details</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card border border-primary">
                        <div class="card-header bg-primary">
                            <strong>Client Details</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped m-0">
                                <colgroup>
                                    <col style="width: 50%;">
                                    <col style="width: 50%;">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $newApplication->title }}
                                            @if (!empty($newApplication->lastname))
                                                {{ $newApplication->firstname }} {{ $newApplication->lastname }}
                                            @else
                                                {{ $newApplication->firstname }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $newApplication->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Mobile Number</th>
                                        <td>{{ $newApplication->mobile_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email Address</th>
                                        <td>{{ $newApplication->email_address }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card border border-success">
                        <div class="card-header bg-success">
                            <strong>Other Attachments</strong>
                        </div>
                        <div class="card-body">

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-success">
                            <strong>Minute</strong>
                        </div>
                        <div class="card-body">
                            {{ $newApplication->rejected_minute }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card border border-success">
                        <div class="card-header bg-success">
                            <strong>Industry Details</strong>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped m-0">
                                <colgroup>
                                    <col>
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>Pradeshiya Sabha</th>
                                        <td>{{ $newApplication->pradeshiyaSabha->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Industry Category</th>
                                        <td>
                                            @if (!empty($newApplication->industryCategory->name) && !empty($newApplication->industryCategory->code))
                                                {{ $newApplication->industryCategory->name }} -
                                                {{ $newApplication->industryCategory->code }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Business Scale</th>
                                        <td>
                                            @if (!empty($businessScales[$newApplication->business_scale]))
                                                {{ $businessScales[$newApplication->business_scale] }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Industry Sub-category</th>
                                        <td>{{ $newApplication->industry_sub_category }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Registration Number</th>
                                        <td>{{ $newApplication->business_registration_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Business Name</th>
                                        <td>{{ $newApplication->business_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Is in industry zone?</th>
                                        <td>{{ $newApplication->is_in_industry_zone ? 'Yes' : 'No' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Investment Amount</th>
                                        <td>{{ number_format(doubleval($newApplication->investment_amount), 2) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Industry Address</th>
                                        <td>{{ $newApplication->industry_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td>{{ $newApplication->start_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Submitted Date</th>
                                        <td>{{ $newApplication->submitted_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Contact Number</th>
                                        <td>{{ $newApplication->industry_contact_no }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email Address</th>
                                        <td>{{ $newApplication->industry_email_address }}</td>
                                    </tr>
                                    <tr>
                                        <th>View Attachments</th>
                                        <td>
                                            @php
                                                $attachmentUrl = config('online-request.url');
                                            @endphp
                                            @if (empty($newApplication->road_map) &&
                                                empty($newApplication->deed_of_land) &&
                                                empty($newApplication->survey_plan))
                                                No documents uploaded.
                                            @endif

                                            @if (isset($newApplication->road_map))
                                                <a href="{{ $attachmentUrl . '/storage/' . str_replace('public/', '', $newApplication->road_map) }}"
                                                    class="btn btn-primary btn-sm mx-2" target="_blank">View Road Map</a>
                                            @endif
                                            @if (isset($newApplication->deed_of_land))
                                                <a href="{{ $attachmentUrl . '/storage/new-attachments/deed-of-lands/' . str_replace('public/', '', $newApplication->deed_of_land) }}"
                                                    class="btn btn-primary btn-sm mx-2" target="_blank">View Deed of
                                                    Land</a>
                                            @endif
                                            @if (isset($newApplication->survey_plan))
                                                <a href="{{ $attachmentUrl . '/storage/new-attachments/survey-plans/' . str_replace('public/', '', $newApplication->survey_plan) }}"
                                                    class="btn btn-primary btn-sm" target="_blank">View Survey Plan</a>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($newApplication->status == 'complete')
                    <div class="alert alert-success">This new application request has been processed and completed.</div>
                @else
                    <form action="{{ route('client-space') }}" method="post">
                        @csrf

                        <input type="hidden" name="new_application_request" value="{{ $newApplication->id }}">

                        @if (empty($newApplication->rejected_at))
                            <button type="submit" class="btn btn-success">Send to create new industry profile</button>
                        @endif
                    </form>

                    <!-- Button trigger modal -->
                    @if (empty($newApplication->rejected_at))
                        <button type="button" class="btn btn-danger mx-3" data-toggle="modal" data-target="#exampleModal">
                            Reject New Application
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Add Minute</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form
                                            action="{{ route('online-requests.new-application.reject', $newApplication->id) }}"
                                            method="post">
                                            @csrf
                                            <textarea name="rejected_minute" id="rejected_minute" cols="30" rows="2" class="form-control"
                                                placeholder="Enter minute here" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Add Minute</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (!empty($newApplication->rejected_at))
                        <a class="btn btn-warning mx-3" href="{{ route('online-requests.index') }}">Go Back to Online
                            Requests</a>
                    @endif
                @endif

                <a href="{{ route('online-requests.new-application-details.view', $newApplication->id) }}"
                    class="btn btn-primary">View Submitted Form</a>
            </div>
    </section>
@endsection

@section('pageScripts')
    <!-- Page scripts -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script>
        $(function() {
            // init clipboard
            new ClipboardJS('.btn');
        });
    </script>
@endsection
