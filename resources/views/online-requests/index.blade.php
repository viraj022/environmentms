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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12 col-sm-6">
                    <h1>Online Requests</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="pills-renewals-tab" data-toggle="pill" href="#pills-renewals"
                                role="tab" aria-controls="pills-renewals" aria-selected="true">Renewals</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-new-applications-tab" data-toggle="pill"
                                href="#pills-new-applications" role="tab" aria-controls="pills-new-applications"
                                aria-selected="false">New Applications</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-rejected-new-applications-tab" data-toggle="pill"
                                href="#pills-rejected-new-applications" role="tab"
                                aria-controls="pills-rejected-new-applications" aria-selected="false">Rejected New
                                Applications</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-renewals" role="tabpanel"
                            aria-labelledby="pills-renewals-tab">
                            <table class="table table-striped table-condensed table-hover" id="renewals_table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Renewal Type</th>
                                        <th>Certificate/License No.</th>
                                        <th>Person Name</th>
                                        <th>Industry Name</th>
                                        <th>Business Reg. No.</th>
                                        <th>Contact No.</th>
                                        <th>Mobile No.</th>
                                        <th>Email</th>
                                        <th>Attachment</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($renewalApplications as $renewal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $renewal->renewal_type)) }}</td>
                                            <td>{{ $renewal->certificate_number }}</td>
                                            <td>{{ $renewal->person_name }}</td>
                                            <td>{{ $renewal->industry_name }}</td>
                                            <td>{{ $renewal->business_registration_no }}</td>
                                            <td>{{ $renewal->contact_no }}</td>
                                            <td>{{ $renewal->mobile_no }}</td>
                                            <td>{{ $renewal->email }}</td>
                                            <td>
                                                <a href="{{ route('online-requests.renewal.view-attachment', $renewal) }}"
                                                    target="_blank">View
                                                    File</a>
                                            </td>
                                            <td>{{ ucwords(str_replace('_', ' ', $renewal->status)) }}</td>
                                            <td>
                                                <a href="{{ route('online-requests.renewal.view', $renewal->id) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <span class="fa fa-eye"></span> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="12">No renewal requests received.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="pills-new-applications" role="tabpanel"
                            aria-labelledby="pills-new-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover" id="new-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Pradeshiya Sabha</th>
                                            <th>Industry Category</th>
                                            <th>Business Scale</th>
                                            <th>Industry Sub Category</th>
                                            <th>Business Name</th>
                                            <th>Start Date</th>
                                            <th>Contact No</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($newApplications as $new)
                                            @if (empty($new->rejected_at))
                                                <tr class="{{ $new->isRejected() ? 'table-danger' : '' }}">
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        {{ $new->title }}
                                                        @if (!empty($new->lastname))
                                                            {{ $new->firstname }} {{ $new->lastname }}
                                                        @else
                                                            {{ $new->firstname }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $new->pradeshiyaSabha->name }}</td>
                                                    <td>
                                                        @if (!empty($new->industryCategory->name))
                                                            {{ $new->industryCategory->name }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($businessScales[$new->business_scale]))
                                                            {{ $businessScales[$new->business_scale] }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($new->industry_sub_category))
                                                            {{ $new->industry_sub_category }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $new->business_name }}
                                                        @if (!empty($new->business_registration_number))
                                                            <br />Reg. No.: {{ $new->business_registration_number }}
                                                        @else
                                                            Reg. No.: -
                                                        @endif
                                                    </td>
                                                    <td>{{ $new->start_date }}</td>
                                                    <td>
                                                        {{ $new->mobile_number }}
                                                        <br />
                                                        {{ $new->industry_contact_no }}
                                                    </td>
                                                    <td>{!! $new->isRejected()
                                                        ? '<span class="badge badge-danger">Rejected</span>'
                                                        : ucwords(str_replace('_', ' ', $new->status)) !!}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('online-requests.new-application.view', $new) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <span class="fa fa-eye"></span> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="12">No new application requests received.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-rejected-new-applications" role="tabpanel"
                            aria-labelledby="pills-rejected-new-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover"
                                    id="rejected-new-applications-table">
                                    <colgroup>
                                        <col style="width: 3%">
                                        <col style="width: 9%">
                                        <col style="width: 6%">
                                        <col style="width: 6%">
                                        <col style="width: 6%">
                                        <col style="width: 6%">
                                        <col style="width: 8%">
                                        <col style="width: 6%">
                                        <col style="width: 6%">
                                        <col style="width: 6%">
                                        <col style="width: 20%;">
                                        <col style="width: 10%">
                                        <col style="width: 8%">
                                    </colgroup>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Pradeshiya Sabha</th>
                                            <th>Industry Category</th>
                                            <th>Business Scale</th>
                                            <th>Industry Sub Category</th>
                                            <th>Business Name</th>
                                            <th>Start Date</th>
                                            <th>Contact No</th>
                                            <th>Status</th>
                                            <th>Rejected Minute</th>
                                            <th>Rejected Date</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($newApplications as $new)
                                            @if (!empty($new->rejected_at))
                                                <tr class="{{ $new->isRejected() ? 'table-danger' : '' }}">
                                                    <td>{{ $i++ }}</td>
                                                    <td>
                                                        {{ $new->title }}
                                                        @if (!empty($new->lastname))
                                                            {{ $new->firstname }} {{ $new->lastname }}
                                                        @else
                                                            {{ $new->firstname }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $new->pradeshiyaSabha->name }}</td>
                                                    <td>{{ $new->industryCategory->name }}</td>
                                                    <td>{{ $businessScales[$new->business_scale] }}</td>
                                                    <td>{{ $new->industry_sub_category }}</td>
                                                    <td>{{ $new->business_name }}
                                                        <br />Reg. No.: {{ $new->business_registration_number }}
                                                    </td>
                                                    <td>{{ $new->start_date }}</td>
                                                    <td>
                                                        {{ $new->mobile_number }} <br />
                                                        {{ $new->industry_contact_no }}
                                                    </td>
                                                    <td>{!! $new->isRejected()
                                                        ? '<span class="badge badge-danger">Rejected</span>'
                                                        : ucwords(str_replace('_', ' ', $new->status)) !!}
                                                    </td>
                                                    <td>{{ Str::limit($new->rejected_minute, 100, '...') }}</td>
                                                    <td>{{ Carbon\Carbon::parse($new->rejected_at)->format('Y-m-d h:i A') }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('online-requests.new-application.view', $new) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <span class="fa fa-eye"></span> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr>
                                                <td colspan="12">No new application requests received.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('pageScripts')
    <!-- Page scripts -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        $(function() {

        });
        @if (session('rejected_success'))
            Swal.fire('Success', '{{ session('rejected_success') }}', 'success');
            $('#pills-rejected-new-applications-tab').tab('show');
        @endif
    </script>
@endsection
