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
                    <td>
                        @foreach (json_decode($applicationData->activities, true) as $key => $value)
                        {{ ucwords($value) }} <br>
                    @endforeach
                    </td>
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
                <tr>
                    <th colspan="2">
                        <center>Filled by Collector</center>
                    </th>
                </tr>
                <tr>
                    <th>Site/s of Collection (Name and Address)
                    </th>
                    <td>{{ $applicationData->site_collecion }}</td>
                </tr>
                <tr>
                    <th>Proposed dates or frequency of collection
                    </th>
                    <td>{{ $applicationData->proposed_date_frequency }}</td>
                </tr>
                <tr>
                    <th>Estimated quantity to be collected
                    </th>
                    <td>{{ $applicationData->estimate_quatity_to_collect }}</td>
                </tr>
                <tr>
                    <th>Type of packaging envisaged (Eg.bulk, drummed, tanker etc.) and method of collection)
                    </th>
                    <td>{{ $applicationData->type_of_parking }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Filled by transporter</center>
                    </th>
                </tr>
                <tr>
                    <th>Mode of transportation to be used
                    </th>
                    <td>{{ $applicationData->mode_of_transpotation }}</td>
                </tr>
                <tr>
                    <th>Class/Type of vehicle
                    </th>
                    <td>{{ $applicationData->class_type_of_vehicles }}</td>
                </tr>
                <tr>
                    <th>Registered number/s
                    </th>
                    <td>{{ $applicationData->registered_number }}</td>
                </tr>
                <tr>
                    <th>Number of vehicles
                    </th>
                    <td>{{ $applicationData->number_of_vehicles }}</td>
                </tr>
                <tr>
                    <th>Details of Routes (include road maps) times and dates
                    </th>
                    <td>{{ $applicationData->route_details }}</td>
                </tr>
                <tr>
                    <th>Emergency measures adopted and precautions taken to prevent
                        accidents
                    </th>
                    <td>{{ $applicationData->emergency_measure }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Filled by Storer</center>
                    </th>
                </tr>
                <tr>
                    <th>Location and extent of the storage site
                    </th>
                    <td>{{ $applicationData->location_of_extend_storage_site }}</td>
                </tr>
                <tr>
                    <th>Type of packaging envisaged for storing
                    </th>
                    <td>{{ $applicationData->type_of_parking_enviasaged }}</td>
                </tr>
                <tr>
                    <th>Period of time waste will be stored
                    </th>
                    <td>{{ $applicationData->period_of_time_waste }}</td>
                </tr>
                <tr>
                    <th>Information relating to recycling/recovery of final
                        disposal of the waste
                    </th>
                    <td>{{ $applicationData->information_relating_recycling }}</td>
                </tr>
                <tr>
                    <th>Emergency measures adopted to
                        prevent accidents
                    </th>
                    <td>{{ $applicationData->emergency_measures_adopted }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Filled by recycler/recoverer</center>
                    </th>
                </tr>
                <tr>
                    <th>Location of the recycling/recovery facility
                    </th>
                    <td>{{ $applicationData->location_of_recovery_facilities }}</td>
                </tr>
                <tr>
                    <th>Method used in the recycling/recovery process
                    </th>
                    <td>{{ $applicationData->methord_used_in_the_recovery }}</td>
                </tr>
                <tr>
                    <th>Purpose of recycling/recovery and the market
                        availability for the end product
                    </th>
                    <td>{{ $applicationData->purpose_of_recycling }}</td>
                </tr>
                <tr>
                    <th>Emergency measures adopted in the
                        event of an accident
                    </th>
                    <td>{{ $applicationData->emergency_measure_adoped_in_the_events }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Filled by Disposer</center>
                    </th>
                </tr>
                <tr>
                    <th>Location of the site for Disposal
                    </th>
                    <td>{{ $applicationData->location_of_the_site_for_disposal }}</td>
                </tr>
                <tr>
                    <th>Method of Disposal
                    </th>
                    <td>{{ $applicationData->method_of_disposal }}</td>
                </tr>
                <tr>
                    <th>Description of the treatment process
                    </th>
                    <td>{{ $applicationData->description_of_the_treatment_process }}</td>
                </tr>
                <tr>
                    <th>Emergency measures adopted at the site in the even of an accident
                    </th>
                    <td>{{ $applicationData->emergency_measures_adopted_site_accident }}</td>
                </tr>
                <tr>
                    <th>Information on the after care of the disposal site
                    </th>
                    <td>{{ $applicationData->information_on_the_after_care }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
