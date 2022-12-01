@extends('online-requests.print-application.application-print-layout')

@section('appheadertitle')
    <h4>
        <center>Form of Application for a Licence for Scheduled Waste Management</center>
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
                        <center>Basic Information</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of the Facility/Activity</th>
                    <td>{{ $applicationData->facility_name }}</td>
                </tr>
                <tr>
                    <th>Location/Address</th>
                    <td>{{ $applicationData->address }}</td>
                </tr>
                <tr>
                    <th>Telephone No</th>
                    <td>{{ $applicationData->telephone }}</td>
                </tr>
                <tr>
                    <th>Pradeshiya Sabha</th>
                    <td>{{ $applicationData->pradeshiyaSabha->name }}</td>
                </tr>
                <tr>
                    <th>District</th>
                    <td>{{ $applicationData->district }}</td>
                </tr>
                <tr>
                    <th>Province</th>
                    <td>{{ $applicationData->province }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Contact Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of the Officer to be contacted in an emergency</th>
                    <td>{{ $applicationData->emergency_name }}</td>
                </tr>
                <tr>
                    <th>Mobile Number</th>
                    <td>{{ $applicationData->emergency_number }}</td>
                </tr>
                <tr>
                    <th>Fixed Line Number</th>
                    <td>{{ $applicationData->emergency_phone }}</td>
                </tr>
                <tr>
                    <th>Fax Number</th>
                    <td>{{ $applicationData->emergency_fax }}</td>
                </tr>
                <tr>
                    <th>E-mail Address</th>
                    <td>{{ $applicationData->emergency_email }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $applicationData->emergency_address }}</td>
                </tr>
                <tr>
                    <th>Authorization required for (Please tick appropriate activity/activities)</th>
                    <td>{{ $applicationData->activities }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Applicant Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Full Name of the Applicant/Industry</th>
                    <td>{{ $applicationData->applicant_name }}</td>
                </tr>
                <tr>
                    <th>Applicant Address</th>
                    <td>{{ $applicationData->applicant_address }}</td>
                </tr>
                <tr>
                    <th>Applicant Contact Number</th>
                    <td>{{ $applicationData->applicant_number }}</td>
                </tr>
                <tr>
                    <th>Applicant Fax Number</th>
                    <td>{{ $applicationData->applicant_fax }}</td>
                </tr>
                <tr>
                    <th>In case of renewal of licence, previous licence number and date</th>
                    <td>{{ $applicationData->licence_number }}</td>
                </tr>
                <tr>
                    <th>Qualifications to engage in the activity covered by the permit</th>
                    <td>{{ $applicationData->permit_qualifications }}</td>
                </tr>
                <tr>
                    <th>Insurance cover details</th>
                    <td>{{ $applicationData->insurance }}</td>
                </tr>
                <tr>
                    <th>Arrangements for security and emergency procedures</th>
                    <td>{{ $applicationData->emergency_procedures }}</td>
                </tr>
                <tr>
                    <th>Information on accidents as a result of the management of waste</th>
                    <td>{{ $applicationData->accidents_info }}</td>
                </tr>
                <tr>
                    <th>Health and safety measures adopted for the workers and the public</th>
                    <td>{{ $applicationData->workers_health }}</td>
                </tr>
                <tr>
                    <th>Waste category/categories identified as per the Scheduled VII</th>
                    <td>{{ $applicationData->waste_category }}</td>
                </tr>
                <tr>
                    <th> Quality and quantity waste handled</th>
                    <td>{{ $applicationData->waste_handle }}</td>
                </tr>
                <tr>
                    <th>Details of the operation system for carrying out the activity/activities</th>
                    <td>{{ $applicationData->detail_operation }}</td>
                </tr>
                <tr>
                    <th>If application is for the establishment of a disposal site, location description and other details
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
