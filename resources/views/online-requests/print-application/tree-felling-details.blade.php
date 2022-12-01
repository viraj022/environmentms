@extends('online-requests.print-application.application-print-layout')

@section('appheadertitle')
    <h4>
        <center>Application for Tree Felling</center>
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
                    <th>Number of trees to be felt</th>
                    <td>{{ $applicationData->number_of_trees }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Details of the Land</center>
                    </th>
                </tr>
                <tr>
                    <th>Address of the land</th>
                    <td>{{ $applicationData->address_of_land }}</td>
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
                    <th>Land ownership</th>
                    <td>{{ ucwords($applicationData->land_ownership_type) }}</td>
                </tr>
                <tr>
                    <th>Extent of the land</th>
                    <td>{{ $applicationData->extent_of_land }}</td>
                </tr>
                <tr>
                    <th>Deed number</th>
                    <td>{{ $applicationData->deed_number }}</td>
                </tr>
                <tr>
                    <th>Survey plan number</th>
                    <td>{{ $applicationData->survey_plan_number }}</td>
                </tr>
                <tr>
                    <th>Whether the trees has already felt</th>
                    <td>{{ ucwords($applicationData->trees_already_felt) }}</td>
                </tr>
                <tr>
                    <th>Current land use</th>
                    <td>{{ $applicationData->current_land_use }}</td>
                </tr>
                <tr>
                    <th>Land use pattern within 100m areas</th>
                    <td>{{ $applicationData->land_pattern_within_100m }}</td>
                </tr>
                <tr>
                    <th>Reason for tree felling</th>
                    <td>{{ $applicationData->tree_felling_reason }}</td>
                </tr>
                <tr>
                    <th>Rehabilitation plan for the tree felt land</th>
                    <td>{{ $applicationData->rehabilitation_plan }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
