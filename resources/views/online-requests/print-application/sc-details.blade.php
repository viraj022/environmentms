@extends('online-requests.print-application.application-print-layout')

@section('attachments')
    <div class="col-lg-4 mx-4 mt-4" id="attachmentCard">
        <div class="card border border-secondary">
            <div class="card-header bg-secondary text-white">
                <strong>Other Attachments</strong>
            </div>
            <div class="card-body">
                @php
                    $attachmentUrl = config('online-request.url');
                @endphp
                @if ($applicationData->sc_type == 'new')
                    @if (isset($applicationData->building_layout_plan))
                        <a href="{{ $attachmentUrl . '/storage/new-attachments/building-layout-plan/' . str_replace('public/', '', $applicationData->building_layout_plan) }}"
                            class="btn btn-sm btn-primary" data-fancybox>View building layout plan</a>
                    @endif
                    @if (isset($applicationData->process_flow_diagram))
                        <a href="{{ $attachmentUrl . '/storage/new-attachments/process-flow-diagram/' . str_replace('public/', '', $applicationData->process_flow_diagram) }}"
                            class="btn btn-sm btn-primary" data-fancybox>View process flow diagram</a>
                    @endif
                @else
                    @if (isset($applicationData->building_layout_plan))
                        <a href="{{ $attachmentUrl . '/storage/renewal-attachments/building-layout-plan/' . str_replace('public/', '', $applicationData->building_layout_plan) }}"
                            class="btn btn-sm btn-primary" data-fancybox>View building layout plan</a>
                    @endif
                    @if (isset($applicationData->process_flow_diagram))
                        <a href="{{ $attachmentUrl . '/storage/renewal-attachments/process-flow-diagram/' . str_replace('public/', '', $applicationData->process_flow_diagram) }}"
                            class="btn btn-sm btn-primary" data-fancybox>View process flow diagram</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
@endsection

@section('appheadertitle')
    <h4>
        <center>Environmental Impact Identification</center>
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
                    <td>{{ $applicationData->industry_name }}</td>
                </tr>
                <tr>
                    <th>Type of Industry</th>
                    <td>{{ $applicationData->industry_type }}</td>
                </tr>
                <tr>
                    <th>Other Industry Type</th>
                    <td>{{ $applicationData->other_industry_type }}</td>
                </tr>
                <tr>
                    <th>Industry Address</th>
                    <td>{{ $applicationData->industry_address }}</td>
                </tr>
                <tr>
                    <th>Pradeshiya Sabha</th>
                    <td>{{ $applicationData->pradeshiyaSabha->name }}</td>
                </tr>
                <tr>
                    <th>Divisional Secretariat Division</th>
                    <td>{{ $applicationData->divisional_secretariat_division }}</td>
                </tr>
                <tr>
                    <th>Is the site within an approval industrial zone?</th>
                    <td>{{ ucwords($applicationData->approval_industrial_zone) }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Applicant Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of the applicant</th>
                    <td>{{ $applicationData->applicant_name }}</td>
                </tr>
                <tr>
                    <th>Address of the applicant</th>
                    <td>{{ $applicationData->applicant_address }}</td>
                </tr>
                <tr>
                    <th>Applicant telephone number</th>
                    <td>{{ $applicationData->applicant_number }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Contact Person Details</center>
                    </th>
                </tr>
                <tr>
                    <th>Name of the contact person</th>
                    <td>{{ $applicationData->contact_person_name }}</td>
                </tr>
                <tr>
                    <th>Contact Person Designation</th>
                    <td>{{ $applicationData->contact_person_designation }}</td>
                </tr>
                <tr>
                    <th>Contact Person Address</th>
                    <td>{{ $applicationData->contact_person_address }}</td>
                </tr>
                <tr>
                    <th>Contact Person Telephone number</th>
                    <td>{{ $applicationData->contact_person_number }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Amount of capital investment</center>
                    </th>
                </tr>
                <tr>
                    <th>Local Amount</th>
                    <td>{{ $applicationData->local_amount }}</td>
                </tr>
                <tr>
                    <th>Foreign Amount</th>
                    <td>{{ $applicationData->foreign_amount }}</td>
                </tr>
                <tr>
                    <th>Date of commencement of operation</th>
                    <td>{{ $applicationData->commencement_date }}</td>
                </tr>
                <tr>
                    <th>Number of shifts / day and times</th>
                    <td>{{ $applicationData->number_of_shifts }}</td>
                </tr>
                <tr>
                    <th>Number of workers in each shift</th>
                    <td>{{ $applicationData->number_of_workers }}</td>
                </tr>
                <tr>
                    <th>Land use of the area within five km radius</th>
                    <td>
                        @foreach (json_decode($applicationData->within5km, true) as $key => $value)
                            {{ $value }} <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>List of existing Industries Institutions / Agricultural Land within 2 km</th>
                    <td>{{ $applicationData->list_existing_industries }}</td>
                </tr>
                <tr>
                    <th>Present land use pattern</th>
                    <td>{{ $applicationData->land_use_pattern }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Industry Details</center>
                    </th>
                </tr>
                <tr>
                    <th>List of main manufacturing products and capacities</th>
                    <td>{{ $applicationData->manufacturing_products }}</td>
                </tr>
                <tr>
                    <th>List of by products</th>
                    <td>{{ $applicationData->products_list }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Process details</center>
                    </th>
                </tr>
                <tr>
                    <th>Raw materials to be used (State item wise quantity / day at all stages of manufacture)</th>
                    <td>{{ $applicationData->raw_materials }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Water requirement</center>
                    </th>
                </tr>
                <tr>
                    <th>Processing (m3/day)</th>
                    <td>{{ $applicationData->processing_requirement }}</td>
                </tr>
                <tr>
                    <th>Cooling (m3/day)</th>
                    <td>{{ $applicationData->cooling_requirement }}</td>
                </tr>
                <tr>
                    <th>Washing (m3/day)
                    </th>
                    <td>{{ $applicationData->washing_requirement }}</td>
                </tr>
                <tr>
                    <th>Domestic (m3/day)
                    </th>
                    <td>{{ $applicationData->demestic_requirement }}</td>
                </tr>
                <tr>
                    <th>Source of water
                    </th>
                    <td>
                        @foreach (json_decode($applicationData->waterSource, true) as $key => $value)
                            {{ $value }} <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Total daily discharge and its quality
                    </th>
                    <td>{{ $applicationData->daily_tot_discharge }}</td>
                </tr>
                <tr>
                    <th>Method of discharge
                    </th>
                    <td>
                        @foreach (json_decode($applicationData->waterDischargeMethod, true) as $key => $value)
                            {{ $value }} <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Final point of discharge of waste water
                    </th>
                    <td>{{ $applicationData->water_discharge_final_point }}</td>
                </tr>
                <tr>
                    <th>What other specific toxics substances are to be discharged? (Specify nature and concentration e.g.
                        Inorganics and organics including pesticides, organic chlorine compounds, heavy metals, etc.)
                    </th>
                    <td>{{ $applicationData->discharge_toxics_substances }}</td>
                </tr>
                <tr>
                    <th>Methods adopted for recording characteristics of waste water before and after treatment
                    </th>
                    <td>{{ $applicationData->characteristics_of_water }}</td>
                </tr>
                <tr>
                    <th> Give details of water re-cycling, if any
                    </th>
                    <td>{{ $applicationData->water_recycling }}</td>
                </tr>
                <tr>
                    <th>Type and nature of solid wastes
                    </th>
                    <td>{{ $applicationData->solid_waste_type }}</td>
                </tr>
                <tr>
                    <th>Total quantity of solid waste - kg / day
                    </th>
                    <td>{{ $applicationData->solid_waste_quantity }}</td>
                </tr>
                <tr>
                    <th>Methods of disposal of solid wastes
                    </th>
                    <td>
                        @foreach (json_decode($applicationData->disposalMethods, true) as $key => $value)
                            {{ $value }} <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Will there emission to the atmosphere? Possible emissions
                    </th>
                    <td>
                        <table>
                            <tr>
                                <th>Oxides of nitrogen</th>
                                <td>{{ $applicationData->nitrogen }}</td>
                            </tr>
                            <tr>
                                <th>Oxides of sulphur</th>
                                <td>{{ $applicationData->nitrogen }}</td>
                            </tr>
                            <tr>
                                <th>Dust and shoot</th>
                                <td>{{ $applicationData->dust }}</td>
                            </tr>
                            <tr>
                                <th>Other</th>
                                <td>{{ $applicationData->other_emissions }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Number of stacks chimneys
                    </th>
                    <td>{{ $applicationData->number_of_chimneys }}</td>
                </tr>
                <tr>
                    <th>Height of chimney
                    </th>
                    <td>{{ $applicationData->chimney_height }}</td>
                </tr>
                <tr>
                    <th>Will your industry cause odour problems?
                    </th>
                    <td>{{ $applicationData->odour_abatement }}</td>
                </tr>
                <tr>
                    <th>Will your industry cause noise pollution?
                    </th>
                    <td>{{ $applicationData->noise_abatement }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Total energy consumption</center>
                    </th>
                </tr>
                <tr>
                    <th>In-plant generation(in kw/h)
                    </th>
                    <td>{{ $applicationData->tot_inplant_gen }}</td>
                </tr>
                <tr>
                    <th>Public supply(in kw/h)
                    </th>
                    <td>{{ $applicationData->tot_public_supply }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Details of machinery used in the industry and their horse power ratings</center>
                    </th>
                </tr>
                <tr>
                    <th>Type
                    </th>
                    <td>{{ $applicationData->machine_type }}</td>
                </tr>
                <tr>
                    <th>Horse power rating
                    </th>
                    <td>{{ $applicationData->machine_horse_power }}</td>
                </tr>
                <tr>
                    <th>Number of units
                    </th>
                    <td>{{ $applicationData->machine_units }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Types of fuels to be used</center>
                    </th>
                </tr>
                <tr>
                    <th>Purpose
                    </th>
                    <td>{{ $applicationData->fuel_use }}</td>
                </tr>
                <tr>
                    <th>Daily consumption
                    </th>
                    <td>{{ $applicationData->fuel_daily_consumption }}</td>
                </tr>
                <tr>
                    <th>Recycling / Re-use (possible salvage of any material for re-use)
                    </th>
                    <td>{{ $applicationData->recycling }}</td>
                </tr>
                <tr>
                    <th>Describe your plans for future expansion of the proposed industry. State whether proposed expansion
                        will alter the manufacturing process, raw material usage and finished products.
                    </th>
                    <td>{{ $applicationData->plan_description }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
