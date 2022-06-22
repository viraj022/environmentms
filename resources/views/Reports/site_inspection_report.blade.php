@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@extends('layouts.navbar')
@extends('layouts.sidebar')
@extends('layouts.footer')


@section('content')
    <div class="container mt-3">
        <center>
            <h5>Report of Site Inspection</h5>
        </center>
        <table class="table table-borderless">
            <tbody>
                <tr>
                    <th width="30%">01).Date</th>
                    <td colspan="3">{{ Carbon\Carbon::parse($inspectionSession->schedule_date)->format('Y-m-d') }}</td>
                </tr>
                <tr>
                    <th>02).Tel</th>
                    <td colspan="3">{{ $inspectionSession->client->industry_contact_no }}</td>
                </tr>
                <tr>
                    <th rowspan="2">03).Persons Interviewed</th>
                        @foreach ($inspectionSession->inspection_interviewers as $persons)
                        <td>{{ $loop->iteration }}- {{ $persons->name }}</td>
                            @if ($loop->iteration % 2 == 0)
                                </tr>
                                <tr>
                            @endif
                        @endforeach
                </tr>
                <tr>
                    <th>04).Inspected By</th>
                    @php
                        $eo = $inspectionSession->environmentOfficer->user;
                    @endphp
                    <td colspan="3">{{ $eo->first_name }} {{ $eo->last_name }}</td>
                </tr>
                <tr>
                    <th>05).Project Description</th>
                </tr>
                <tr>
                    <td>i). Project Type</td>
                    <td>{{ $inspectionSession->project_area_type }}</td>
                    <td>ii).Project Name</td>
                    <td></td>
                </tr>
                <tr>
                    <td>iii). Location</td>
                    <td></td>
                    <td>iv).GPS</td>
                    <td>{{  $inspectionSession->client->industry_coordinate_x }} - {{  $inspectionSession->client->industry_coordinate_y }}</td>
                </tr>
                <tr>
                    <td>v). Proposed Land</td>
                    <td>a.Extent- {{ $inspectionSession->proposed_land_ext }}</td>
                    <td>b.Use- {{ $inspectionSession->land_use }}</td>
                    <td>c.Ownership- {{ $inspectionSession->ownersip }}</td>
                </tr>
                <tr>
                    <td>vi). Adjoining Lnads</td>
                    <td>N-  {{ $inspectionSession->adj_land_n }}</td>
                    <td>E-  {{ $inspectionSession->adj_land_e }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>S-  {{ $inspectionSession->adj_land_s }}</td>
                    <td>W-  {{ $inspectionSession->adj_land_w }}</td>
                </tr>
                <tr>
                    <td>vii). Distance to the residence and of house within </td>
                    <td colspan="3">{{ $inspectionSession->house_within_100 }} 50m</td>
                </tr>
                <tr>
                    <td>viii). Sensitive areas and public places (with distance) </td>
                    <td colspan="3">{{ $inspectionSession->sensitive_area_desc }}</td>
                </tr>
                <tr>
                    <td>ix). Observations & Special issues </td>
                    <td colspan="3">{{ $inspectionSession->special_issue_desc }}</td>
                </tr>
                <tr>
                    <th>06). Sketch of the project site </th>
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
                    <th>07). Recommendations </th>
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
