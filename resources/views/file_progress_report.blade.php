@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('pageStyles')
<!-- Theme style -->
<link rel="stylesheet" href="/dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-12 col-sm-6">
                <h1>Files Progress</h1>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <!--    Register New Client START-->
    <div class="container-fluid reg-newClient">
        {{-- {{ dd($report_data) }} --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        <table class="table table-condensed" id="eo_client_tbl">
                            <thead>
                                <tr class="tblTrsec">
                                    <th style="width: 10px">#</th>
                                    <th>File</th>
                                    <th>Type</th>
                                    <th>Client Name</th>
                                    <th>Industry Category</th>
                                    <th>Submitted Date</th>
                                    <th>File Updated Date</th>
                                    <th>File Status</th>

                                    <!--<th class="inspectTbl" style="width: 180px">Inspection</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($report_data as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="/industry_profile/id/{{ $data->id }}" target="_blank">{{ $data->file_no }}</a></td>
                                    <td>{{ $file_type_status[$data->cer_type_status] }}</td>
                                    <td>{{ $data->first_name }} {{ $data->last_name }}</td>
                                    <td>{{ $data->industryCategory->name }}</td>
                                    @if(isset($data->epls[0]->submitted_date))
                                    <td>{{ $data->epls[0]->submitted_date }}</td>
                                    @elseif(isset($data->siteClearenceSessions->siteClearances))
                                    <td>{{ $data->siteClearenceSessions->siteClearances[0]->submit_date }}</td>
                                    @else
                                    <td>N/A</td>
                                    @endif
                                    <td>{{ $data->updated_at->format('Y/m/d H:i') }}</td>
                                    @if($data->environment_officer_id != null)
                                    <td>{{ $file_status[$data->file_status] }}</td>
                                    @else
                                    <td> Not Assigned </td>
                                    @endif
                                </tr>
                                @empty
                                <p>No replies</p>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--</form>-->
            </div>
        </div>
    </div>
    <!--Register New Client END-->

</section>
@endsection

@section('pageScripts')
<!-- Page script -->
<script src="../../dist/js/adminlte.min.js"></script>

<script>
    $('#eo_client_tbl').DataTable();
</script>
@endsection