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
                @if (isset($applicationData->process_flow_diagram))
                    <a href="{{ $attachmentUrl . '/storage/new-attachments/process-flow-diagram/' . str_replace('public/', '', $applicationData->process_flow_diagram) }}"
                        class="btn btn-sm btn-primary" data-fancybox>View Process flow diagram</a>
                @endif
                @if (isset($applicationData->water_treatment_process))
                    <a href="{{ $attachmentUrl . '/storage/new-attachments/water-treatment-process/' . str_replace('public/', '', $applicationData->water_treatment_process) }}"
                        class="btn btn-sm btn-primary" data-fancybox>View treatment method of waste
                        water</a>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('appheadertitle')
    <h4>
        <center>Environmental Protection Licence Application</center>
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
                    <th>Business registration number</th>
                    <td>{{ $applicationData->industry_br }}</td>
                </tr>
                <tr>
                    <th>Identity Card Number</th>
                    <td>{{ $applicationData->nic }}</td>
                </tr>
                <tr>
                    <th>Type of Industry</th>
                    <td>{{ $applicationData->industry_type }} <br>
                        @if ($applicationData->other_industry_type)
                            {{ $applicationData->other_industry_type }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Name of applicant</th>
                    <td>{{ $applicationData->applicant_name }}</td>
                </tr>
                <tr>
                    <th>Applicant postal address</th>
                    <td>{{ $applicationData->applicant_address }}</td>
                </tr>
                <tr>
                    <th>Applicant telephone number</th>
                    <td>{{ $applicationData->applicant_telephone }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>General Description Of Industry</center>
                    </th>
                </tr>
                <tr>
                    <th>Nature of industry</th>
                    <td>{{ $applicationData->industry_nature }}</td>
                </tr>
                <tr>
                    <th>GPS</th>
                    <td>{{ $applicationData->industry_GPS }}</td>
                </tr>
                <tr>
                    <th>Telephone Number</th>
                    <td>{{ $applicationData->telephone_Number }}</td>
                </tr>
                <tr>
                    <th>Postal Address</th>
                    <td>{{ $applicationData->location_address }}</td>
                </tr>
                <tr>
                    <th>Pradeshiya Sabha</th>
                    <td>{{ $applicationData->pradeshiyaSabha->name }}</td>
                </tr>
                <tr>
                    <th>Is the site within an approved industrial zone?</th>
                    <td>{{ ucwords($applicationData->approval_industrial_zone) }}</td>
                </tr>
                <tr>
                    <th>Number of acre’s in industrial zone</th>
                    <td>{{ ucwords($applicationData->industrial_zone2) }}</td>
                </tr>
                <tr>
                    <th>Land ownership</th>
                    <td>{{ ucwords($applicationData->industrial_zone3) }}</td>
                </tr>
                <tr>
                    <th>Deed number</th>
                    <td>{{ ucwords($applicationData->industrial_zone4) }}</td>
                </tr>
                <tr>
                    <th>Survey plan number</th>
                    <td>{{ ucwords($applicationData->industrial_zone5) }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Amount of capital investment</center>
                    </th>
                </tr>
                <tr>
                    <th>Value of Land</th>
                    <td>{{ $applicationData->land_amount }}</td>
                </tr>
                <tr>
                    <th>Value of Buildings</th>
                    <td>{{ $applicationData->buildings_amount }}</td>
                </tr>
                <tr>
                    <th>Value of Machinery</th>
                    <td>{{ $applicationData->machinery_amount }}</td>
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
                    <th>A list of permits obtained from local or state authorities permitting the establishment and
                        operation of the industry</th>
                    <td>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Date of Issue</th>
                                <th>Date of Expire</th>
                            </tr>
                            @foreach (json_decode($applicationData->permits, true) as $key => $value)
                                <tr>
                                    <td>{{ $value['permits_name'] }}</td>
                                    <td>{{ $value['permit_issue_date'] }}</td>
                                    <td>{{ $value['permit_expire_date'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Land use of the area within 05 km radius</th>
                    <td>
                        @foreach (json_decode($applicationData->within5km, true) as $key => $value)
                            @if ($value == 'Other')
                                {{ $value }} <br>
                                {{ $applicationData->other5km }}
                            @endif
                            {{ $value }}
                            <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Other area within 05 km</th>
                    <td>
                        {{ $applicationData->other5km }}
                    </td>
                </tr>
                <tr>
                    <th>List of existing industries / institutions / agricultural land within 2 km radius</th>
                    <td>
                        {{ $applicationData->list_existing_industries }}
                    </td>
                </tr>
                <tr>
                    <th>Land available for treatment plant</th>
                    <td>
                        {{ $applicationData->land_for_treatment_plant }}
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Manufacturing Process</center>
                    </th>
                </tr>
                <tr>
                    <th>List of main manufacturing products and capacities</th>
                    <td>{{ $applicationData->manufacturing_products }}</td>
                </tr>
                <tr>
                    <th>List of by-products</th>
                    <td>{{ $applicationData->by_products_list }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Process details</center>
                    </th>
                </tr>
                <tr>
                    <th>Process flow description</th>
                    <td>{{ $applicationData->process_description }}</td>
                </tr>
                <tr>
                    <th>Raw materials used</th>
                    <td>
                        {{ $applicationData->raw_materials }}
                    </td>
                </tr>
                <tr>
                    <th>Chemicals used</th>
                    <td>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <th>Trade Name</th>
                                <th>Quantity day(in kg)</th>
                                <th>Used Purpose</th>
                            </tr>
                            @foreach (json_decode($applicationData->chemicals, true) as $key => $value)
                                <tr>
                                    <td>{{ $value['chemical_name'] }}</td>
                                    <td>{{ $value['chem_trade_name'] }}</td>
                                    <td>{{ $value['chem_quantity'] }}</td>
                                    <td>{{ $value['chem_used'] }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Precautionary measures adopted in the transport and handling of any hazardous / toxic/ flammable /
                        explosive material</th>
                    <td>{{ $applicationData->precautionary_measures }}</td>
                </tr>
                <tr>
                    <th>Storage facilities for hazardous / toxic / flammable / explosive materials</th>
                    <td>{{ $applicationData->storage_facilities }}</td>
                </tr>
                <tr>
                    <th>Do you have adequate fire fighting equipment?</th>
                    <td>{{ $applicationData->fire_equipment_details }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Water</center>
                    </th>
                </tr>
                <tr>
                    <th>Water requirement</th>
                    <td>
                        Processing (m3/day)- {{ $applicationData->processing_requirement }} <br>
                        Cooling (m3/day)- {{ $applicationData->cooling_requirement }} <br>
                        Washing (m3/day)- {{ $applicationData->washing_requirement }} <br>
                        Domestic (m3/day)- {{ $applicationData->demestic_requirement }} <br>
                    </td>
                </tr>
                <tr>
                    <th>Source of water</th>
                    <td>
                        @foreach (json_decode($applicationData->waterSource, true) as $key => $value)
                            {{ $value }} <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Total daily discharge (m3/day)</th>
                    <td>{{ $applicationData->daily_tot_discharge }}</td>
                </tr>
                <tr>
                    <th>Method of discharge</th>
                    <td>
                        @foreach (json_decode($applicationData->waterDischargeMethod, true) as $key => $value)
                            {{ $value }} <br>
                            <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Final point of discharge of waste water</th>
                    <td>
                        @foreach (json_decode($applicationData->waterDischargeFinalPoint, true) as $key => $value)
                            {{ $value }} <br>
                            <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>What other specific toxics substances are to be discharged?(specify nature and concentration - eg.
                        Inorganic and organics including pesticides, organic chlorine compounds, heavy metals, etc.)</th>
                    <td>{{ $applicationData->discharge_toxics_substances }}</td>
                </tr>
                <tr>
                    <th>Methods adopted for recording characteristics of waste water before and after treatment</th>
                    <td>{{ $applicationData->characteristics_of_water }}</td>
                </tr>
                <tr>
                    <th>Give details of water re-cycling, if any</th>
                    <td>{{ $applicationData->water_recycling }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Solid Waste</center>
                    </th>
                </tr>
                <tr>
                    <th>Type and nature of solid wastes</th>
                    <td>{{ $applicationData->solid_waste_type }}</td>
                </tr>
                <tr>
                    <th>Total quantity of solid waste - kg / day</th>
                    <td>{{ $applicationData->solid_waste_quantity }}</td>
                </tr>
                <tr>
                    <th>Methods of disposal of solid wastes</th>
                    <td>
                        @foreach (json_decode($applicationData->disposalMethods, true) as $key => $value)
                            {{ $value }} <br>
                            <br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Atmospheric Emissions</center>
                    </th>
                </tr>
                <tr>
                    <th>Is there emission to the atmosphere? Possible emissions</th>
                    <td>
                        Oxides of Nitrogen- {{ $applicationData->nitrogen }} <br>
                        Oxides of Sulphur- {{ $applicationData->sulphur }}<br>
                        Dust and Shoot- {{ $applicationData->dust }}<br>
                        Other- {{ $applicationData->other_emissions }}
                    </td>
                </tr>
                <tr>
                    <th>Number of stacks / chimneys</th>
                    <td>{{ $applicationData->number_of_chimneys }}</td>
                </tr>
                <tr>
                    <th>Height of chimney</th>
                    <td>{{ $applicationData->chimney_height }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Odour Problems</center>
                    </th>
                </tr>
                <tr>
                    <th>Does Your Industry Cause Odour Problems?</th>
                    <td>{{ $applicationData->odour_abatement }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Noise Pollution</center>
                    </th>
                </tr>
                <tr>
                    <th>Does your industry cause noise pollution?</th>
                    <td>{{ $applicationData->noise_abatement }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Energy Requirements</center>
                    </th>
                </tr>
                <tr>
                    <th>Total energy consumption</th>
                    <td>
                        In-plant generation(in kw/h)- {{ $applicationData->tot_inplant_gen }} <br>
                        Public supply(in kw/h)- {{ $applicationData->tot_inplant_gen }}
                    </td>
                </tr>
                <tr>
                    <th>Details of machinery used in the industry and their horse power ratings</th>
                    <td>
                        Type- {{ $applicationData->machine_type }}
                        Horse power rating- {{ $applicationData->machine_horse_power }}
                        Number of units- {{ $applicationData->machine_units }}
                    </td>
                </tr>
                <tr>
                    <th>Types of fuels to be used
                    </th>
                    <td>
                        Purpose- {{ $applicationData->fuel_use }} <br>
                        Daily consumption- {{ $applicationData->fuel_daily_consumption }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Recycling / Reuse</center>
                    </th>
                </tr>
                <tr>
                    <th>Possible salvage of any material for re-use
                    </th>
                    <td>{{ $applicationData->recycling }}</td>
                </tr>
                <tr>
                    <th colspan="2">
                        <center>Expansion Of Industry</center>
                    </th>
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
