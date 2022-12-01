@extends('online-requests.print-application.application-print-layout')

@section('appheadertitle')
    <h4>
        <center>Identification of Environmental Impacts Construction / Erection of Telecommunication
            Antenna Tower</center>
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
                        <center>Proponent Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of the project proponent</th>
                    <td>{{ $applicationData->name }}</td>
                </tr>
                <tr>
                    <th>Address of the project proponent</th>
                    <td>{{ $applicationData->address }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Contact Person Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Contact Person Name</th>
                    <td>{{ $applicationData->contact_name }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $applicationData->contact_address }}</td>
                </tr>
                <tr>
                    <th>Telephone</th>
                    <td>{{ $applicationData->contact_number }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Information of the land</center>
                    </th>
                </tr>
                <tr>
                    <th>Extent of land</th>
                    <td>{{ $applicationData->extent_of_land }}</td>
                </tr>
                <tr>
                    <th>Land Owner Name</th>
                    <td>{{ $applicationData->land_owner_name }}</td>
                </tr>
                <tr>
                    <th>Land Owner Address</th>
                    <td>{{ $applicationData->land_owner_address }}</td>
                </tr>
                <tr>
                    <th>Land Owner Phone</th>
                    <td>{{ $applicationData->land_owner_phone }}</td>
                </tr>
                <tr>
                    <th>Pradeshiya Sabha</th>
                    <td>{{ $applicationData->pradeshiyaSabha->name }}</td>
                </tr>
                <tr>
                    <th>Address of the location</th>
                    <td>{{ $applicationData->land_address }}</td>
                </tr>
                <tr>
                    <th>Investment capital (Rs)</th>
                    <td>{{ $applicationData->investment_amount }}</td>
                </tr>
                <tr>
                    <th>Tower height (m)</th>
                    <td>{{ $applicationData->tower_height }}</td>
                </tr>
                <tr>
                    <th>Length of the base of the tower</th>
                    <td>{{ $applicationData->tower_length }}</td>
                </tr>
                <tr>
                    <th> Width of the base of the tower</th>
                    <td>{{ $applicationData->tower_width }}</td>
                </tr>
                <tr>
                    <th> power (electricity) requirements</th>
                    <td>{{ $applicationData->power_requirements }}</td>
                </tr>
                <tr>
                    <th>Describe measures adopted to avoid minimize lightening effects</th>
                    <td>{{ $applicationData->des_minimize_lightening }}</td>
                </tr>
                <tr>
                    <th>Monitoring programme to assess the efficiency of above</th>
                    <td>{{ $applicationData->lightening_monitoring }}</td>
                </tr>
                <tr>
                    <th>Distance and name of the nearest religious places/school/office complex or any other public places
                    </th>
                    <td>{{ $applicationData->public_places_distance }}</td>
                </tr>
                <tr>
                    <th>Proposed method of compensation on a catastrophic event</th>
                    <td>{{ $applicationData->catastrophic_event }}</td>
                </tr>
                <tr>
                    <th>Number and the owned company of other telecommunication towers situated within 500m from the
                        proposed tower</th>
                    <td>{{ $applicationData->towers_within_500m }}</td>
                </tr>
                <tr>
                    <th>Distance to the nearest residence (m)</th>
                    <td>{{ $applicationData->nearest_residence_distance }}</td>
                </tr>
                <tr>
                    <th>Number of houses within 50m from the proposed location of the tower</th>
                    <td>{{ $applicationData->houses_within_50m }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
