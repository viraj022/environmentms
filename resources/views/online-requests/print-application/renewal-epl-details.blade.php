@extends('online-requests.print-application.application-print-layout')

@section('appheadertitle')
    <h4>
        <center>Environmental Protection License Renewal Application</center>
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
                        <center>Industry Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of Industry</th>
                    <td>{{ $applicationData->industry_name }}</td>
                </tr>
                <tr>
                    <th>Address of Industry</th>
                    <td>{{ $applicationData->industry_address }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Applicant Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of applicant</th>
                    <td>{{ $applicationData->applicant_name }}</td>
                </tr>
                <tr>
                    <th>Address of applicant</th>
                    <td>{{ $applicationData->applicant_address }}</td>
                </tr>
                <tr>
                    <th>NIC</th>
                    <td>{{ $applicationData->applicant_nic }}</td>
                </tr>
                <tr>
                    <th>Telephone</th>
                    <td>{{ $applicationData->applicant_telephone }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $applicationData->applicant_email }}</td>
                </tr>
                <tr>
                    <th>Pradeshiya Sabha</th>
                    <td>{{ $applicationData->pradeshiyaSabha->name }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Previous EPL Datails</center>
                    </th>
                </tr>
                <tr>
                    <th>Previous EPL number</th>
                    <td>{{ $applicationData->epl_number }}</td>
                </tr>
                <tr>
                    <th>Date of issue</th>
                    <td>{{ $applicationData->epl_issued }}</td>
                </tr>
                <tr>
                    <th>Expiry Date</th>
                    <td>{{ ucwords($applicationData->epl_expired) }}</td>
                </tr>
                <tr>
                    <th>Any expansion/change, done after the last EPL (Provide details)</th>
                    <td>{{ $applicationData->changes_after_last_epl }}</td>
                </tr>
                <tr>
                    <th>Any change in production process/Raw materials/Final products, done after the last EPL</th>
                    <td>{{ $applicationData->production_changes }}</td>
                </tr>
                <tr>
                    <th>Details of the reports obtained from other departments</th>
                    <td>{{ $applicationData->other_department_report }}</td>
                </tr>
                <tr>
                    <th>Other Details</th>
                    <td>{{ $applicationData->other_details }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
