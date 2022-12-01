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
                    <th>Name of Industry</th>
                    <td>{{ $applicationData->facility_name }}</td>
                </tr>
                <tr>
                    <th>Type of Industry</th>
                    <td>{{ $applicationData->address }}</td>
                </tr>
                <tr>
                    <th>Industry Address</th>
                    <td>{{ $applicationData->telephone }}</td>
                </tr>
                <tr>
                    <th>Pradeshiya Sabha</th>
                    <td>{{ $applicationData->pradeshiyaSabha->name }}</td>
                </tr>
                <tr>
                    <th>Divisional Secretariat Division</th>
                    <td>{{ $applicationData->district }}</td>
                </tr>
                <tr>
                    <th>Is the site within an approval industrial zone?</th>
                    <td>{{ $applicationData->province }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Applicant Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of the applicant</th>
                    <td>{{ $applicationData->emergency_name }}</td>
                </tr>
                <tr>
                    <th>Address of the applicant</th>
                    <td>{{ $applicationData->emergency_number }}</td>
                </tr>
                <tr>
                    <th>Applicant telephone number</th>
                    <td>{{ $applicationData->emergency_phone }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Contact Person Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of the contact person</th>
                    <td>{{ $applicationData->emergency_fax }}</td>
                </tr>
                <tr>
                    <th>Contact Person Designation</th>
                    <td>{{ $applicationData->emergency_email }}</td>
                </tr>
                <tr>
                    <th>Contact Person Address</th>
                    <td>{{ $applicationData->emergency_address }}</td>
                </tr>
                <tr>
                    <th>Contact Person Telephone number</th>
                    <td>{{ $applicationData->activities }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Amount of capital investment</center>
                    </th>
                </tr>
                <tr>
                    <th>Local Amount</th>
                    <td>{{ $applicationData->applicant_name }}</td>
                </tr>
                <tr>
                    <th>Foreign Amount</th>
                    <td>{{ $applicationData->applicant_address }}</td>
                </tr>
                <tr>
                    <th>Date of commencement of operation</th>
                    <td>{{ $applicationData->applicant_number }}</td>
                </tr>
                <tr>
                    <th>Number of shifts / day and times</th>
                    <td>{{ $applicationData->applicant_fax }}</td>
                </tr>
                <tr>
                    <th>Number of workers in each shift</th>
                    <td>{{ $applicationData->licence_number }}</td>
                </tr>
                <tr>
                    <th>Land use of the area within five km radius</th>
                    <td>{{ $applicationData->permit_qualifications }}</td>
                </tr>
                <tr>
                    <th>List of existing Industries Institutions / Agricultural Land within 2 km</th>
                    <td>{{ $applicationData->insurance }}</td>
                </tr>
                <tr>
                    <th>Present land use pattern</th>
                    <td>{{ $applicationData->emergency_procedures }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Industry Details</center>
                    </th>
                </tr>
                <tr>
                    <th>List of main manufacturing products and capacities</th>
                    <td>{{ $applicationData->accidents_info }}</td>
                </tr>
                <tr>
                    <th>List of by products</th>
                    <td>{{ $applicationData->workers_health }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Process details</center>
                    </th>
                </tr>
                <tr>
                    <th>Raw materials to be used (State item wise quantity / day at all stages of manufacture)</th>
                    <td>{{ $applicationData->waste_category }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Water requirement</center>
                    </th>
                </tr>
                <tr>
                    <th>Processing (m3/day)</th>
                    <td>{{ $applicationData->waste_handle }}</td>
                </tr>
                <tr>
                    <th>Cooling (m3/day)</th>
                    <td>{{ $applicationData->detail_operation }}</td>
                </tr>
                <tr>
                    <th>Washing (m3/day)
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Domestic (m3/day)
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Source of water
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Total daily discharge and its quality
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Method of discharge
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Final point of discharge of waste water
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>What other specific toxics substances are to be discharged? (Specify nature and concentration e.g.
                        Inorganics and organics including pesticides, organic chlorine compounds, heavy metals, etc.)
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Methods adopted for recording characteristics of waste water before and after treatment
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th> Give details of water re-cycling, if any
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Type and nature of solid wastes
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Total quantity of solid waste - kg / day
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Methods of disposal of solid wastes
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Will there emission to the atmosphere?
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Number of stacks chimneys
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Height of chimney
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Will your industry cause odour problems?
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Will your industry cause noise pollution?
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Will your industry cause odour problems?
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Total energy consumption</center>
                    </th>
                </tr>
                <tr>
                    <th>Will your industry cause odour problems?
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
                <tr>
                    <th>Will your industry cause odour problems?
                    </th>
                    <td>{{ $applicationData->disposal_des }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
