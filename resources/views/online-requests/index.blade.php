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
                            <a class="nav-link" id="pills-tree-felling-applications-tab" data-toggle="pill"
                                href="#pills-tree-felling-applications" role="tab"
                                aria-controls="pills-tree-felling-applications" aria-selected="false">Tree Felling
                                Applications</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-refiling-paddy-applications-tab" data-toggle="pill"
                                href="#pills-refiling-paddy-applications" role="tab"
                                aria-controls="pills-refiling-paddy-applications" aria-selected="false">Refiling Paddy
                                Land</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-state-land-lease-applications-tab" data-toggle="pill"
                                href="#pills-state-land-lease-applications" role="tab"
                                aria-controls="pills-state-land-lease-applications" aria-selected="false">State Land
                                Leases</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-site-clearance-applications-tab" data-toggle="pill"
                                href="#pills-site-clearance-applications" role="tab"
                                aria-controls="pills-site-clearance-applications" aria-selected="false">Site Clearance</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-telecommunication-tower-applications-tab" data-toggle="pill"
                                href="#pills-telecommunication-tower-applications" role="tab"
                                aria-controls="pills-telecommunication-tower-applications"
                                aria-selected="false">Telecommunication Tower</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-new-epl-applications-tab" data-toggle="pill"
                                href="#pills-new-epl-applications" role="tab" aria-controls="pills-new-epl-applications"
                                aria-selected="false">New EPL</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="pills-renewal-epl-applications-tab" data-toggle="pill"
                                href="#pills-renewal-epl-applications" role="tab"
                                aria-controls="pills-renewal-epl-applications" aria-selected="false">Renewal EPL</a>
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
                                <table class="table table-striped table-condensed table-hover"
                                    id="new-applications-table">
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
                                                        {{ $new->title }} {{ $new->firstname }} {{ $new->lastname }}
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
                        <div class="tab-pane fade" id="pills-tree-felling-applications" role="tabpanel"
                            aria-labelledby="pills-tree-felling-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover"
                                    id="tree-felling-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
                                            <th>Land Type</th>
                                            <th>Pradeshiya Sabha Area</th>
                                            <th>Number of trees</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($treeFellingApplications as $treeFelling)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $treeFelling->name }}</td>
                                                <td>{{ $treeFelling->address }}</td>
                                                <td>{{ $treeFelling->telephone }}</td>
                                                <td>{{ $treeFelling->land_ownership_type }}</td>
                                                <td>{{ $treeFelling->pradeshiyaSabha->name }}</td>
                                                <td>{{ $treeFelling->number_of_trees }}</td>
                                                <td>{{ ucwords(str_replace('_', ' ', $treeFelling->status)) }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">
                                                        <span class="fa fa-eye"></span> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">No tree felling application requests received.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-refiling-paddy-applications" role="tabpanel"
                            aria-labelledby="pills-refiling-paddy-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover"
                                    id="refiling-paddy-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
                                            <th>Paddy Land Owner Name</th>
                                            <th>Pradeshiya Sabha Area</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($refilingPaddyApplications as $paddyRefiling)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $paddyRefiling->name }}</td>
                                                <td>{{ $paddyRefiling->address }}</td>
                                                <td>{{ $paddyRefiling->telephone }}</td>
                                                <td>{{ $paddyRefiling->paddy_land_owner_name }}</td>
                                                <td>{{ $paddyRefiling->pradeshiyaSabha->name }}</td>
                                                <td>{{ ucwords(str_replace('_', ' ', $paddyRefiling->status)) }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">
                                                        <span class="fa fa-eye"></span> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">No refiling paddy land application requests received.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-state-land-lease-applications" role="tabpanel"
                            aria-labelledby="pills-state-land-lease-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover"
                                    id="state-land-lease-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
                                            <th>Pradeshiya Sabha Area</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($stateLandLeasesApplications as $landLease)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $landLease->name }}</td>
                                                <td>{{ $landLease->address }}</td>
                                                <td>{{ $landLease->telephone }}</td>
                                                <td>{{ $landLease->pradeshiyaSabha->name }}</td>
                                                <td>{{ ucwords(str_replace('_', ' ', $landLease->status)) }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">
                                                        <span class="fa fa-eye"></span> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7">No state land lease application requests received.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-site-clearance-applications" role="tabpanel"
                            aria-labelledby="pills-site-clearance-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover"
                                    id="site-clearance-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Industry Name</th>
                                            <th>Industry Type</th>
                                            <th>Applicant name</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($onlineScApplications as $sc)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $sc->industry_name }}</td>
                                                <td>{{ $sc->industry_type }}</td>
                                                <td>{{ $sc->applicant_name }}</td>
                                                <td>{{ $sc->applicant_address }}</td>
                                                <td>{{ $sc->applicant_number }}</td>
                                                <td>{{ ucwords(str_replace('_', ' ', $sc->status)) }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">
                                                        <span class="fa fa-eye"></span> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">No site clearance application requests received.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-telecommunication-tower-applications" role="tabpanel"
                            aria-labelledby="pills-telecommunication-tower-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover"
                                    id="telecommunication-tower-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
                                            <th>Investment Amount</th>
                                            <th>Pradeshiya Sabha</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($teleTowerApplications as $teleTower)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $teleTower->name }}</td>
                                                <td>{{ $teleTower->address }}</td>
                                                <td>{{ $teleTower->contact_number }}</td>
                                                <td>{{ $teleTower->investment_amount }}</td>
                                                <td>{{ $teleTower->pradeshiyaSabha->name }}</td>
                                                <td>{{ ucwords(str_replace('_', ' ', $teleTower->status)) }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">
                                                        <span class="fa fa-eye"></span> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">No telecommunication tower application requests
                                                    received.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-new-epl-applications" role="tabpanel"
                            aria-labelledby="pills-new-epl-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover"
                                    id="new-epl-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Industry Name</th>
                                            <th>Industry Type</th>
                                            <th>Industry Address</th>
                                            <th>Applicant Name</th>
                                            <th>Applicant Telephone</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($newEplApplications as $newEpl)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $newEpl->industry_name }}</td>
                                                <td>{{ $newEpl->industry_type }}</td>
                                                <td>{{ $newEpl->location_address }}</td>
                                                <td>{{ $newEpl->applicant_name }}</td>
                                                <td>{{ $newEpl->applicant_telephone }}</td>
                                                <td>{{ ucwords(str_replace('_', ' ', $newEpl->status)) }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">
                                                        <span class="fa fa-eye"></span> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">No telecommunication tower application requests
                                                    received.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-renewal-epl-applications" role="tabpanel"
                            aria-labelledby="pills-renewal-epl-applications-tab">
                            <div class="table-responsive">
                                <table class="table table-striped table-condensed table-hover"
                                    id="renewal-epl-applications-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Industry Name</th>
                                            <th>EPL Number</th>
                                            <th>Industry Address</th>
                                            <th>Applicant Name</th>
                                            <th>Applicant Telephone</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1;
                                        @endphp
                                        @forelse ($renewalEplApplications as $renewalEpl)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $renewalEpl->industry_name }}</td>
                                                <td>{{ $renewalEpl->epl_number }}</td>
                                                <td>{{ $renewalEpl->industry_address }}</td>
                                                <td>{{ $renewalEpl->applicant_name }}</td>
                                                <td>{{ $renewalEpl->applicant_telephone }}</td>
                                                <td>{{ ucwords(str_replace('_', ' ', $renewalEpl->status)) }}</td>
                                                <td>
                                                    <a href="" class="btn btn-primary btn-sm">
                                                        <span class="fa fa-eye"></span> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8">No telecommunication tower application requests
                                                    received.</td>
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
                                                        {{ $new->title }} {{ $new->firstname }} {{ $new->lastname }}
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
