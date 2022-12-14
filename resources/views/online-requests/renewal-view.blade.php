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
    <link rel="stylesheet" href="{{ asset('plugins/fancybox/fancybox.css') }}">
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
                    <h1>Renewal Request Details</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-body p-0">
                        <table class="table table-striped table-hover m-0" id="renewal-details-table">
                            <colgroup>
                                <col style="width: 50%;">
                                <col style="width: 50%;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th>Renewal Type</th>
                                    <td>{{ ucwords(str_replace('_', ' ', $renewal->renewal_type)) }}</td>
                                </tr>
                                <tr>
                                    <th>Certificate/License No.</th>
                                    <td class="clearfix">
                                        <strong id="certificate_number">{{ $renewal->certificate_number }}</strong>

                                        <button class="btn btn-light btn-sm d-inline ml-2"
                                            data-clipboard-target="#certificate_number">
                                            <span class="fa fa-copy"></span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Person Name</th>
                                    <td>{{ $renewal->person_name }}</td>
                                </tr>
                                <tr>
                                    <th>Industry Name</th>
                                    <td>{{ $renewal->industry_name }}</td>
                                </tr>
                                <tr>
                                    <th>Business Reg. No.</th>
                                    <td>{{ $renewal->business_registration_no }}</td>
                                </tr>
                                <tr>
                                    <th>Contact No.</th>
                                    <td>{{ $renewal->contact_no }}</td>
                                </tr>
                                <tr>
                                    <th>Mobile No.</th>
                                    <td>{{ $renewal->mobile_no }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $renewal->email_address }}</td>
                                </tr>
                                {{-- <tr>
                                    <th>Attachment</th>
                                    <td>
                                        <a href="{{ route('online-requests.renewal.view-attachment', $renewal) }}"
                                            target="_blank">View File</a>
                                    </td>
                                </tr> --}}
                                <tr>
                                    <th>Status</th>
                                    <td>{{ ucwords(str_replace('_', ' ', $renewal->status)) }}</td>
                                </tr>
                                <tr>
                                    <th>View Attachments</th>
                                    <td>
                                        @php
                                            $attachmentUrl = config('online-request.url');
                                        @endphp
                                        @if (empty($renewal->road_map) && empty($renewal->deed_of_land) && empty($renewal->survey_plan))
                                            No documents uploaded.
                                        @endif
                                        @if (isset($renewal->road_map))
                                            <a href="{{ $attachmentUrl . '/storage/renewal-attachments/route-map/' . str_replace('public/', '', $renewal->road_map) }}"
                                                class="btn btn-primary btn-sm" data-fancybox>Road Map</a>
                                        @endif
                                        @if (isset($renewal->deed_of_land))
                                            <a href="{{ $attachmentUrl . '/storage/renewal-attachments/deed-of-lands/' . str_replace('public/', '', $renewal->deed_of_land) }}"
                                                class="btn btn-primary btn-sm" data-fancybox>Deed of Land</a>
                                        @endif
                                        @if (isset($renewal->survey_plan))
                                            <a href="{{ $attachmentUrl . '/storage/renewal-attachments/survey-plans/' . str_replace('public/', '', $renewal->survey_plan) }}"
                                                class="btn btn-primary btn-sm mt-2" data-fancybox>Survey Plan</a>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Application</th>
                                    <td>
                                        <a href="{{ route('online-requests.renewal-application-details.view', $renewal->id) }}"
                                            class="btn btn-primary btn-sm mx-2" target="_blank">View
                                            Application</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-6">
                    @if (empty($renewal->client_id))
                        <div class="card">
                            <div class="card-header">
                                Assign Client
                            </div>
                            <div class="card-body">
                                @if ($client)
                                    <h6>Client found from provided Certificate Number</h6>
                                    <div class="alert alert-success">
                                        <strong>Client Name:
                                        </strong>{{ sprintf('%s %s', $client->first_name, $client->last_name) }}<br />
                                        <strong>Address: {{ $client->address }}</strong>
                                        ({{ $client->contact_no }})<br />
                                        <strong>Industry: </strong>{{ $client->industry_name }}
                                        ({{ $client->industry_contact_no }})
                                    </div>

                                    <form action="{{ route('renewals.update-client', $renewal->id) }}" method="post">
                                        @csrf
                                        <input type="hidden" id="renewal_client_id" name="renewal_client_id"
                                            value="{{ $client->id }}" required>
                                        <input type="hidden" name="renewal_renewal_id" id="renewal_renewal_id"
                                            value="{{ $renewal->id }}" required>

                                        <input type="hidden" name="renewal_update_certificate_number"
                                            id="renewal_update_certificate_number"
                                            value="{{ $renewal->certificate_number }}">

                                        <button type="submit" class="btn btn-primary">
                                            Assign Client Profile and Save Changes
                                        </button>
                                    </form>
                                @else
                                    <div class="alert alert-warning">
                                        Cannot find client by certificate number. Please assign client manually with file
                                        number
                                        below.
                                    </div>

                                    <div class="mb-2">
                                        <label for="search_file_no">File Number</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="File number"
                                                aria-label="File number" aria-describedby="search_renewal_client"
                                                id="search_file_no">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button"
                                                    id="search_renewal_client">Search</button>
                                            </div>
                                        </div>
                                        <div class="alert alert-success d-none" id="client_search_results">
                                            <p>
                                                <strong>Client Name: </strong>
                                                <span id="search_result_client_name"></span>
                                                <br>
                                                <strong>Industry Name: </strong>
                                                <span id="search_result_industry_name"></span>
                                                <br>
                                                <strong>File Number: </strong>
                                                <span id="search_result_file_number"></span>
                                            </p>

                                            <form action="{{ route('renewals.update-client', $renewal->id) }}"
                                                method="post">
                                                @csrf
                                                <input type="hidden" id="renewal_client_id" name="renewal_client_id"
                                                    value="" required>
                                                <input type="hidden" name="renewal_renewal_id" id="renewal_renewal_id"
                                                    value="{{ $renewal->id }}" required>

                                                <div class="mb-2">
                                                    <label for="certificate_number">Certificate Number</label>
                                                    <input type="text" name="renewal_update_certificate_number"
                                                        id="renewal_update_certificate_number" class="form-control"
                                                        value="{{ $renewal->certificate_number }}" required>
                                                    <span class="form-text">Make changes to the certificate number if it is
                                                        incorrect.</span>
                                                </div>

                                                <button type="submit" class="btn btn-primary">Assign Client Profile and
                                                    Save
                                                    Changes</button>
                                            </form>
                                        </div>

                                        <div class="alert alert-info d-none" id="client_search_no_result">
                                            Cannot find client using the given client id.
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="card">
                            <div class="card-header">
                                Payments
                            </div>
                            <div class="card-body">
                                <p>Send a link to the online payments portal to the client via SMS and Email.</p>
                                <p>Link will be sent via SMS to {{ $renewal->mobile_number }} and emailed to
                                    {{ $renewal->email_address }}</p>

                                <form action="{{ route('online-request.payment.sendlink', $renewal->onlineRequest->id) }}"
                                    method="post" class="has-validation">
                                    @csrf

                                    <div class="mb-2">
                                        <label for="payment_amount">Payment Amount</label>
                                        <input type="number" name="payment_amount" id="payment_amount"
                                            class="form-control" required min="1" step="1">
                                    </div>

                                    <div class="mb-2">
                                        <button type="submit" class="btn btn-success">Send Payment Link</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endif
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.10/clipboard.min.js"></script>
    <script src="{{ asset('plugins/fancybox/fancybox.umd.js') }}"></script>
    <script>
        function searchClientByOldNumber() {
            let file_no = $('#search_file_no').val();
            if (file_no.trim().length == 0) {
                $('#client_search_results').addClass('d-none');
                $('#client_search_no_result').removeClass('d-none');
                return false;
            }

            $.get('{{ route('renewals.client-by-fileno') }}', {
                file_no: file_no
            }, function(res) {
                if (res.data) {
                    console.log('in here');
                    $('#search_result_client_name').html(`${res.data.first_name} ${res.data.last_name}`);
                    $('#search_result_industry_name').html(res.data.industry_name);
                    $('#search_result_file_number').html(res.data.file_no);

                    $('#client_search_results').removeClass('d-none');
                    $('#client_search_no_result').addClass('d-none');
                    $('#renewal_client_id').val(res.data.id);
                } else {
                    $('#client_search_no_result').removeClass('d-none');
                    $('#client_search_results').addClass('d-none');

                    $('#search_result_client_name').html('');
                    $('#search_result_industry_name').html('');
                    $('#search_result_file_number').html('');
                    $('#renewal_client_id').val('');
                }
            }, 'json');
        }

        $('#search_renewal_client').click(function() {
            searchClientByOldNumber();
        });

        $(function() {
            // init clipboard
            new ClipboardJS('.btn');
        });
    </script>
@endsection
