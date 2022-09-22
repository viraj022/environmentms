@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')


@section('content')
    <div class="container mt-3">
        <center>
            <u><h5>Report of Site Inspection</h5></u>
        </center>
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <td width="35%">01).Date</td>
                    <th colspan="3">{{ Carbon\Carbon::parse($inspectionSession->schedule_date)->format('Y-m-d') }}</th>
                </tr>
                <tr>
                    <td>02).Tel</td>
                    <th colspan="3">{{ $inspectionSession->client->industry_contact_no }}</th>
                </tr>
                <tr>
                    <td rowspan="2">03).Persons Interviewed</td>
                        @foreach ($inspectionSession->inspection_interviewers as $persons)
                        <th>{{ $loop->iteration }}- {{ $persons->name }}</th>
                            @if ($loop->iteration % 2 == 0)
                                </tr>
                                <tr>
                            @endif
                        @endforeach
                </tr>
                <tr>
                    <td>04).Inspected By</td>
                    @php
                        $eo = $inspectionSession->environmentOfficer->user;
                    @endphp
                    <th colspan="3">{{ $eo->first_name }} {{ $eo->last_name }}</th>
                </tr>
                <tr>
                    <td>05).Project Description</td>
                </tr>
                <tr>
                    <td style="padding-left: 32px !important;">i). Project Type</td>
                    <th><b>{{ $inspectionSession->project_area_type }}<b></td>
                    <td>ii).Project Name</td>
                    <th></th>
                </tr>
                <tr>
                    <td style="padding-left: 32px !important;">iii). Location</td>
                    <th></th>
                    <td>iv).GPS</td>
                    <th>{{  $inspectionSession->client->industry_coordinate_x }} - {{  $inspectionSession->client->industry_coordinate_y }}</th>
                </tr>
                <tr>
                    <td style="padding-left: 32px !important;">v). Proposed Land</td>
                    <th>a.Extent- {{ $inspectionSession->proposed_land_ext }}</th>
                    <th>b.Use- {{ $inspectionSession->land_use }}</th>
                    <th>c.Ownership- {{ $inspectionSession->ownersip }}</th>
                </tr>
                <tr>
                    <td style="padding-left: 32px !important;">vi). Adjoining Lnads</td>
                    <th>N-  {{ $inspectionSession->adj_land_n }}</th>
                    <th>E-  {{ $inspectionSession->adj_land_e }}</th>
                </tr>
                <tr>
                    <td></td>
                    <th>S-  {{ $inspectionSession->adj_land_s }}</th>
                    <th>W-  {{ $inspectionSession->adj_land_w }}</th>
                </tr>
                <tr>
                    <td style="padding-left: 32px !important;">vii). Distance to the residence and of house within </td>
                    <th colspan="3">{{ $inspectionSession->house_within_100 }} 50m</th>
                </tr>
                <tr>
                    <td style="padding-left: 32px !important;">viii). Sensitive areas and public places (with distance) </td>
                    <th colspan="3">{{ $inspectionSession->sensitive_area_desc }}</th>
                </tr>
                <tr>
                    <td style="padding-left: 32px !important;">ix). Observations & Special issues </td>
                    <th colspan="3">{{ $inspectionSession->special_issue_desc }}</th>
                </tr>
                <tr>
                    <td>06). Sketch of the project site </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <div> 
                            <img class="border p-2" style="border-color: #000 !important;" src="{{ asset('storage/'.$inspectionSession->sketch_path) }}" alt="" width="400"
                            height="400">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>07). Recommendations </td>
                    <td colspan="3"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Signature:</td>
                </tr>
            </tbody>

        </table>
    </div>
@endsection
