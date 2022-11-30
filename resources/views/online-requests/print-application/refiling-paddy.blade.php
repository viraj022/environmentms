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
                    <th>Extent of the land</th>
                    <td>{{ $applicationData->gs_division }}</td>
                </tr>
                <tr>
                    <th>Survey plan number</th>
                    <td>{{ $applicationData->agrarian_service_division }}</td>
                </tr>
                <tr>
                    <th>Existing utility of the land</th>
                    <td>{{ $applicationData->paddy_land_owner_name }}</td>
                </tr>
                <tr>
                    <th>Purpose of lease</th>
                    <td>{{ $applicationData->deed_number }}</td>
                </tr>
                <tr>
                    <th>Any sensitive areas within 100m from the boundary of the land</th>
                    <td>{{ $applicationData->survey_plan_number }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
