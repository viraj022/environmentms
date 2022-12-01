@extends('online-requests.print-application.application-print-layout')

@section('appheadertitle')
    <h4>
        <center>Application for Refiling of Paddy Lands</center>
    </h4>
@endsection

@section('contents')
    <div class="row">
        <div class="col-lg-6">
            <table class="table">
                <colgroup>
                    <col style="width: 40%">
                    <col style="width: 60%">
                </colgroup>
                <tr>
                    <th colspan="2">
                        <center>Applicant Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Applicant Name</th>
                    <td>{{ $applicationData->name }}</td>
                </tr>
                <tr>
                    <th>Applicant Address</th>
                    <td>{{ $applicationData->address }}</td>
                </tr>
                <tr>
                    <th>Applicant NIC</th>
                    <td>{{ $applicationData->nic }}</td>
                </tr>
                <tr>
                    <th>Applicant telephone number</th>
                    <td>{{ $applicationData->telephone }}</td>
                </tr>
                <tr>
                    <th>Applicant Email</th>
                    <td>{{ $applicationData->email }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Information of project</center>
                    </th>
                </tr>
                <tr>
                    <th>Pradeshiya Sabha Area</th>
                    <td>{{ $applicationData->pradeshiyaSabha->name }}</td>
                </tr>
                <tr>
                    <th>Divisional Secretariat</th>
                    <td>{{ $applicationData->division_secretariat }}</td>
                </tr>
                <tr>
                    <th>GS Division</th>
                    <td>{{ $applicationData->gs_division }}</td>
                </tr>
                <tr>
                    <th>Agrarian Service Division</th>
                    <td>{{ $applicationData->agrarian_service_division }}</td>
                </tr>
                <tr>
                    <th>Name of the paddy land owner</th>
                    <td>{{ $applicationData->paddy_land_owner_name }}</td>
                </tr>
                <tr>
                    <th>Deed Number</th>
                    <td>{{ $applicationData->deed_number }}</td>
                </tr>
                <tr>
                    <th>Survey Plan Number</th>
                    <td>{{ $applicationData->survey_plan_number }}</td>
                </tr>
                <tr>
                    <th>Extent of the land to be refilled</th>
                    <td>{{ $applicationData->extent_of_land }}</td>
                </tr>
                <tr>
                    <th>Current utility of the land</th>
                    <td>{{ ucwords($applicationData->utility_of_land) }}</td>
                </tr>
                <tr>
                    <th>Current utilities of bounded lands</th>
                    <td>{{ $applicationData->utility_of_bounded_land }}</td>
                </tr>
                <tr>
                    <th>Proposed utility of the land</th>
                    <td>{{ $applicationData->proposed_land_utility }}</td>
                </tr>
                <tr>
                    <th>Reasons for abandonment paddy land</th>
                    <td>{{ $applicationData->reason }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
