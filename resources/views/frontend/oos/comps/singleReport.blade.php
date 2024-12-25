<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VidyaGxP - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
    }

    .w-25 {
        width: 25%;
    }

    .w-30 {
        width: 30%;
    }

    .w-40 {
        width: 40%;
    }

    .w-50 {
        width: 50%;
    }

    .w-60 {
        width: 60%;
    }

    .w-70 {
        width: 70%;
    }

    .w-80 {
        width: 80%;
    }

    .w-90 {
        width: 90%;
    }

    .w-100 {
        width: 100%;
    }

    .h-100 {
        height: 100%;
    }

    header table,
    header th,
    header td,
    footer table,
    footer th,
    footer td,
    .border-table table,
    .border-table th,
    .border-table td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    table {
        width: 100%;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    footer .head,
    header .head {
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    @page {
        size: A4;
        margin-top: 160px;
        margin-bottom: 60px;
    }

    header {
        position: fixed;
        top: -140px;
        left: 0;
        width: 100%;
        display: block;
    }

    footer {
        width: 100%;
        position: fixed;
        display: block;
        bottom: -40px;
        left: 0;
        font-size: 0.9rem;
    }

    footer td {
        text-align: center;
    }

    .inner-block {
        padding: 10px;
    }

    .inner-block tr {
        font-size: 0.8rem;
    }

    .inner-block .block {
        margin-bottom: 30px;
    }

    .inner-block .block-head {
        font-weight: bold;
        font-size: 1.1rem;
        padding-bottom: 5px;
        border-bottom: 2px solid #4274da;
        margin-bottom: 10px;
        color: #4274da;
    }

    .inner-block th,
    .inner-block td {
        vertical-align: baseline;
    }

    .table_bg {
        background: #4274da57;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                    OOS/OOT Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://navin.mydemosoftware.com/public/user/images/logo.png" alt=""
                            class="w-100">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong> OOS/OOT No.</strong>
                </td>
                <td class="w-40">
                {{-- {{ Helpers::getDivisionName($data->division_id) }}/{{ $data->Form_type }}/{{ Helpers::year($data->created_at) }}/{{ $data->record_number ? str_pad($data->record_number, 4, '0', STR_PAD_LEFT) : '1' }} --}}

                  {{ Helpers::getDivisionName(session()->get('division')) }}/OOS/{{ date('Y') }}/{{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>
    @php
    $lab_inv_questions = array(
            "Aliquot and standard solutions preserved",
            "Visual examination (solid and solution) reveals normal or abnormal appearance",
            "The analyst is trained on the method.",
            "Correct test procedure followed e.g. Current Version of standard testing procedure has been used in testing.",
            "Current Validated analytical Method has been used and the data of analytical method validation has been reviewed and found satisfactory.",
            "Correct sample(s) tested.",
            "Sample Integrity maintained, correct container is used in testing.",
            "Assessment of the possibility that the sample contamination (sample left open to air or unattended) has occurred during the testing/ re-testing procedure",
            "All equipment used in the testing is within calibration due period.",
            "Equipment log book has been reviewed and no any failure or malfunction has been reviewed.",
            "Any malfunctioning and / or out of calibration analytical instruments (including glassware) is used.",
            "Whether reference standard / working standard is correct (in terms of appearance, purity, LOD/water content & its storage) and assay values are determined correctly.",
            "Whether test solution / volumetric solution used are properly prepared & standardized.",
            "Review RSD, resolution factor and other parameters required for the suitability of the test system. Check if any out of limit parameters is included in the chromatographic analysis, correctness of the column used previous use of the column.",
            "In the raw data, including chromatograms and spectra; any anomalous or suspect peaks or data has been observed.",
            "Any such type of observation has been observed previously (Assay, Dissolution etc.).",
            "Any unusual or unexpected response observed with standard or test preparations (e.g. whether contamination of equipment by previous sample observed).",
            "System suitability conditions met (those before analysis and during analysis).",
            "Correct and clean pipette / volumetric flasks volumes, glassware used as per recommendation.",
            "Other potentially interfering testing/activities occurring at the time of the test which might lead to OOS.",
            "Review of other data for other batches performed within the same analysis set and any nonconformance observed.",
            "Consideration of any other OOS results obtained on the batch of material under test and any non-conformance observed.",
            "Media/Reagents prepared according to procedure.",
            "All the materials are within the due period of expiry.",
            "Whether, analysis was performed by any other alternate validated procedure",
            "Whether environmental condition is suitable to perform the test.",
            "Interview with analyst to assess knowledge of the correct procedure"
        );
@endphp

@php
    use Carbon\Carbon;

    $phase_two_inv_questions = array(
        "Is correct batch manufacturing record used?",
        "Correct quantities of correct ingredients were used in manufacturing?",
        "Balances used in dispensing / verification were calibrated using valid standard weights?",
        "Equipment used in the manufacturing is as per batch manufacturing record?",
        "Processing steps followed in correct sequence as per the BMR?",
        "Whether material used in the batch had any OOS result?",
        "All the processing parameters were within the range specified in BMR?",
        "Environmental conditions during manufacturing are as per BMR?",
        "Whether there was any deviation observed during manufacturing?",
        "The yields at different stages were within the acceptable range as per BMR?",
        "All the equipment’s used during manufacturing are calibrated?",
        "Whether there is malfunctioning or breakdown of equipment during manufacturing?",
        "Whether the processing equipment was maintained as per preventive maintenance schedule?",
        "All the in-process checks were carried out as per the frequency given in BMR & the results were within acceptance limit?",
        "Whether there were any failures of utilities (like Power, Compressed air, steam etc.) during manufacturing?",
        "Whether other batches/products impacted?",
        "Any Other"
    );

@endphp
    <div class="inner-block">
        <div class="content-table">
            <!-- start block -->
            <div class="block">
                <div class="block-head">General Information</div>
                <table>
                    <tr>
                        <th class="w-20">OOS Number</th>
                        <td class="w-30">
                            {{-- {{ Helpers::getDivisionName($data->division_id) }}/{{ $data->Form_type }}/{{ Helpers::year($data->created_at) }}/{{ $data->record_number ? str_pad($data->record_number, 4, '0', STR_PAD_LEFT) : '1' }} --}}
                            {{ Helpers::getDivisionName(session()->get('division')) }}/OOS/{{ date('Y') }}/{{ str_pad($data->record_number, 4, '0', STR_PAD_LEFT) }}

                        </td>
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30">{{ Helpers::getDivisionName($data->division_id) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Type</th>
                        <td class="w-30">{{ $data->Form_type }}</td>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Date of Initiation</th>
                        <td class="w-30">{{ $data->intiation_date }}</td>
                        <th class="w-20">Due Date</th>
                        <td class="w-30">
                            @if($data->due_date)
                                {{ $data->due_date }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                    </tr>
                </table>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Short Description</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->description_gi ){{ $data->description_gi  }} @else Not Applicable @endif</span>
                </div>
                    <div class="block">
                    <table>
                    <tr>
                        <th class="w-20">Date Of OOS Occurrence</th>
                        <td class="w-30">
                            @if(Helpers::getFullDepartmentName($data->initiator_group))
                                {{ Helpers::getFullDepartmentName($data->initiator_group) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">Date Of OOS reporting</th>
                        <td class="w-80">@if($data->initiator_group_code){{ $data->initiator_group_code }}@else Not Applicable @endif</td>
                    </tr>
                    {{-- <tr>
                        <th class="w-20">If Others</th>
                        <td class="w-80">@if($data->if_others_gi){{ $data->if_others_gi }}@else Not Applicable @endif</td>
                        <th class="w-20">Is Repeat</th>
                        <td class="w-80">@if($data->is_repeat_gi){{ $data->is_repeat_gi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Repeat Nature</th>
                        <td class="w-80">@if($data->repeat_nature){{ $data->repeat_nature }}@else Not Applicable @endif</td>
                        <th class="w-20">Source Document Type</th>
                        <td class="w-80">@if($data->source_document_type_gi){{ $data->source_document_type_gi }}@else Not Applicable @endif</td>
                    </tr> --}}
                    </table>
                    <!-- <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Reference System Document</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->reference_system_document_gi ){{ $data->reference_system_document_gi  }} @else Not Applicable @endif</span>
                    </div> -->

                    <div class="block">
                    <table>
                    <tr>
                        <th class="w-20">OOS/OOT Occurred On</th>
                        <td class="w-30">
                            @if($data->deviation_occured_on_gi)
                                {{ Helpers::getdateFormat($data->deviation_occured_on_gi) }}
                            @else
                                Not Applicable
                            @endif
                        </td>
                        <th class="w-20">OOS/OOT Observed On</th>
                        <td class="w-80">@if($data->oos_observed_on){{ $data->oos_observed_on }}@else Not Applicable @endif</td>
                    </tr>
                    </table>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Delay Justification</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->delay_justification ){{ $data->delay_justification }} @else Not Applicable @endif</span>
                    </div>
                    <div class="block">
                    <table>
                    <tr>
                        <th class="w-20">OOS/OOT Reported On</th>
                        <td class="w-30">@if($data->oos_reported_date){{ Helpers::getdateFormat($data->oos_reported_date) }}@else Not Applicable @endif </td>
                        <th></th>
                        <td></td>
                    </tr>
                </table>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Immediate Action</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->immediate_action ){{ $data->immediate_action  }} @else Not Applicable @endif</span>
                </div>
                <div class="block-head">Preliminary Information</div>
                <!-- <table>
                    <tr>
                        <th class="w-20">Sample Type</th>
                        <td class="w-80">@if($data->sample_type_gi){{ Helpers::recordFormat($data->sample_type_gi) }}@else Not Applicable @endif</td>
                        <th class="w-20">Product / Material Name</th>
                        <td class="w-80">@if($data->product_material_name_gi){{ Helpers::recordFormat($data->product_material_name_gi) }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Market</th>
                        <td class="w-80">@if($data->market_gi){{ $data->market_gi }}@else Not Applicable @endif</td>
                        <th class="w-20">Customer</th>
                        <td class="w-80">@if($data->customer_gi){{ $data->customer_gi }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Specification Details</th>
                        <td class="w-80">@if($data->specification_details){{ Helpers::recordFormat($data->specification_details) }}@else Not Applicable @endif</td>
                        <th class="w-20">STP Details</th>
                        <td class="w-80">@if($data->STP_details){{ Helpers::recordFormat($data->STP_details) }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Manufacture/Vendor</th>
                        <td class="w-80">@if($data->manufacture_vendor){{ Helpers::recordFormat($data->manufacture_vendor) }}@else Not Applicable @endif</td>
                    </tr>
                </table> -->
            </div>

            <!-- Allgrid -->
            <!-- Info. On Product/ Material -->

            <div class="block">
                      <!-- <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">File </th>
                            </tr>
                            @if ($data->initial_attachment_gi)
                            @foreach ($data->initial_attachment_gi as $key => $file)
                                 <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-80"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-80">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div> -->

                      
                <h2 class="block-head">Product/ Material Name (with Grade)</h2>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 4%">Row#</th>
                            <th style="width: 10%">Batch No*.</th>
                            <th style="width: 8%"> AR No.</th>
                            <th style="width: 8%"> Stage</th>
                            <th style="width: 8%">Reference Specification No.</th>
                            <th style="width: 8%">Test</th>
                            <th style="width: 8%">Results Obtained</th>
                            <th style="width: 8%">Specification limit</th>
                        </tr>
                        @if($data->info_product_materials && is_array($data->info_product_materials->data))
                            @foreach ($data->info_product_materials->data as $key => $datagridI)
                                <tr>
                                    <td class="w-15">{{ $datagridI ? $key + 1  : "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_batch_no'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_ar_no'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_stage'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_reference_specification_no'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_test'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_results_obtained'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_specification_limit'] ?? "Not Applicable" }}</td>

                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                </div>
            </div>
            <!-- <div class="block">
                <div class="block-head"> Info. On Product/ Material</div>
                   <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 4%">Row#</th>
                            <th style="width: 8%">Analyst Name</th>
                            <th style="width: 10%">Others (Specify)</th>
                            <th style="width: 10%"> In- Process Sample Stage.</th>
                            <th style="width: 12% pt-3">Packing Material Type</th>
                            <th style="width: 16% pt-2"> Stability for</th>
                        </tr>
                        @if(isset($data->info_product_materials) && isset($data->info_product_materials->data) && is_array($data->info_product_materials->data))
                            @foreach ($data->info_product_materials->data as $key => $datagridI)
                                <tr>
                                    <td class="w-15">{{ $datagridI ? $key + 1 : "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_analyst_name'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_others_specify'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_process_sample_stage'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_packing_material_type'] ?? "Not Applicable" }}</td>
                                    <td class="w-15">{{ $datagridI['info_stability_for'] ?? "Not Applicable" }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                                <td>Not Applicable</td>
                            </tr>
                        @endif

                    </table>
                 </div>
                </div>
            </div> -->
            <!--  Details of Stability Study -->
            <!-- <div class="block">
                <div class="block-head"> Details of Stability Study</div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                               <th style="width: 4%">Row#</th>
                                <th style="width: 8%">AR Number</th>
                                <th style="width: 12%">Condition: Temperature & RH</th>
                                <th style="width: 12%">Interval</th>
                                <th style="width: 16%">Orientation</th>
                        </tr>
                        @if(($data->details_stabilities) && is_array($data->details_stabilities->data))
                        @foreach ($data->details_stabilities->data as $key => $datagridII)
                        <tr>
                            {{-- <td class="w-15">{{ $datagridII ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $datagridII['stability_study_arnumber'] ?  $datagridII['stability_study_arnumber']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridII['stability_study_condition_temprature_rh'] ?  $datagridII['stability_study_condition_temprature_rh']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridII['stability_study_Interval'] ?  $datagridII['stability_study_Interval']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridII['stability_study_orientation'] ?  $datagridII['stability_study_orientation']: "Not Applicable"}}</td> --}}
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head"> Details of Stability Study</div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                               <th style="width: 4%">Row#</th>
                                <th style="width: 16%">Pack Details (if any)</th>
                                <th style="width: 16%">Specification No.</th>
                                <th style="width: 16%">Sample Description</th>
                        </tr>
                        @if(($data->details_stabilities) && is_array($data->details_stabilities->data))
                        @foreach ($data->details_stabilities->data as $key => $datagridII)
                        <tr>
                            {{-- <td class="w-15">{{ $datagridII ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $datagridII['stability_study_pack_details'] ?  $datagridII['stability_study_pack_details']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridII['stability_study_specification_no'] ?  $datagridII['stability_study_specification_no']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridII['stability_study_sample_description'] ?  $datagridII['stability_study_sample_description']: "Not Applicable"}}</td>
                             </tr> --}}
                        @endforeach
                        @else
                        <tr>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div> -->
             <!-- OOS Details  -->
            <!-- <div class="block">
                <div class="block-head"> OOS/OOT Details</div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                        <th style="width: 4%">Row#</th>
                                <th style="width: 8%">AR Number.</th>
                                <th style="width: 8%">Test Name of OOS/OOT</th>
                                <th style="width: 12%">Results Obtained</th>
                                <th style="width: 16%">Specification Limit</th>
                                <th style="width: 16%">File Attachment</th>
                                <th style="width: 16%">Submit On</th>
                                <th style="width: 16%">Submit By</th>
                        </tr>
                        @if(($data->oos_details) && is_array($data->oos_details->data))
                        @foreach ($data->oos_details->data as $key => $datagridIII)
                        <tr>
                            {{-- <td class="w-15">{{ $datagridIII ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $datagridIII['oos_arnumber'] ?  $datagridIII['oos_arnumber']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridIII['oos_test_name'] ?  $datagridIII['oos_test_name']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridIII['oos_results_obtained'] ?  $datagridIII['oos_results_obtained']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $datagridIII['oos_specification_limit'] ?  $datagridIII['oos_specification_limit']: "Not Applicable"}}</td>
                            <td class="w-15">
                                {{ isset($datagridIII['oos_file_attachment']) && is_array($datagridIII['oos_file_attachment']) 
                                    ? implode(', ', $datagridIII['oos_file_attachment']) 
                                    : ($datagridIII['oos_file_attachment'] ?? "Not Applicable") 
                                }}
                            </td>

                            <td class="w-15">{{ $datagridIII['oos_submit_on'] ?  Helpers::getdateFormat($datagridIII['oos_submit_on'] ?? ''): "Not Applicable" }}
                            </td>
                            <td class="w-15">{{ $datagridIII['oos_submit_by'] ?  Helpers::getInitiatorName($datagridIII['oos_submit_by'] ?? ''): "Not Applicable" }}
                            </td> --}}
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class="block">
                <div class="block-head"> Instrument details </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 4%">Row#</th>
                            <th style="width: 8%"> Name of instrument</th>
                            <th style="width: 8%"> Instrument Id Number</th>
                            <th style="width: 8%"> Calibrated On</th>
                            <th style="width: 8%">Calibrated Due Date</th>
                        </tr>

                        @if(($instrument_details) && is_array($instrument_details->data))
                        @foreach ($instrument_details->data as $key => $instrument_detail)
                        <tr>
                            <td class="w-15">{{ $instrument_detail ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $instrument_detail['instrument_name'] ?  $instrument_detail['instrument_name']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['instrument_id_number'] ?  $instrument_detail['instrument_id_number']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['calibrated_on'] ?  Helpers::getdateFormat($instrument_detail['calibrated_on']): "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['calibratedduedate_on'] ?  Helpers::getdateFormat($instrument_detail['calibratedduedate_on']): "Not Applicable"}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>1</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div> -->
           <!-- grid close -->

           <div class="block">
            <div class="block-head">Preliminary Lab. Investigation</div>
            <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Summary Of Discussion with Analyst :</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->description_summary ){!! $data->description_summary !!} @else Not Applicable @endif</span>
            </div>

            <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Discussion Points :</label>
                <span style="font-size:0.3rem; margin-left:10px">
                    @if($data->Discussion_points )
                    {!! $data->Discussion_points !!} 
                    @else Not Applicable @endif</span>
            </div>

            <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Remark Of QC investigator</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Remark_qc_investigator ){!! $data->Remark_qc_investigator !!} @else Not Applicable @endif</span>
            </div>

            <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Conclusion On Preliminary Investigation Response :</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->preliminary_investigation_response ){!! $data->preliminary_investigation_response !!} @else Not Applicable @endif</span>
            </div>

            <div class = "inner-block">
                <label class="summer" style="font-weight: bold; 1remfont-size:1rem; display:inline;">Results Of Sample Analyzed in the same sequence :</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->simple_analyzed ){!! $data->simple_analyzed !!} @else Not Applicable @endif</span>
            </div>
            
            <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Investigator :</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->investigator ){!! $data->investigator !!} @else Not Applicable @endif</span>
            </div>

            <br>
            <div class="block">
                <div class="block-head">Details Of Previous history Of Similar type (Same product, Same test) Of OOS Observed</div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 4%">Row#</th>
                            <th style="width: 8%"> Summary Of Previous OOS history</th>
                            <th style="width: 8%"> CAPA taken for OOS</th>
                        </tr>

                        @if(($data) && is_array($data->data))
                        @foreach ($data->data as $key => $instrument_detail)
                        <tr>
                            <td class="w-15">{{ $instrument_detail ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $instrument_detail['summary_of_previous_oos'] ?  $instrument_detail['summary_of_previous_oos']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['capa_taken_for_oos'] ?  $instrument_detail['capa_taken_for_oos']: "Not Applicable"}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>1</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Comment Of Robustnes Of Previously Recommended CAPA :</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->review_comments_plir ){!! $data->review_comments_plir !!} @else Not Applicable @endif</span>
            </div>


           </div>
            <div class="block">
                <div class="block-head">PHASE -1(A) in case OBVIOUS ERROR is identified</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Root Cause</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->root_cause_identified_plic ){{ $data->root_cause_identified_plic }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Correct the Obvious error/cause and document:</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->summary_of_prelim_investiga_plic ){!! $data->summary_of_prelim_investiga_plic !!} @else Not Applicable @endif</span>
                </div> 

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Impact assessment :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->re_sampling_ref_no_piii ){!! $data->re_sampling_ref_no_piii !!} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Corrective Action :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->corrective_action ){!! $data->corrective_action !!} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Preventive Action </label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->preventive_action1A ){!! $data->preventive_action1A !!} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Evaluation By Head Quality</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->evaluation_by_head_quality ){{ $data->evaluation_by_head_quality }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Outcome Of Phase I(A) Investigation</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->outcome_phase_i_investigation ){{ $data->outcome_phase_i_investigation }} @else Not Applicable @endif</span>
                </div>
            </div>
            <!-- <div class="block">
                <div class="block-head">PHASE II INVESTIGATION (Extended laboratory Investigation)</div>
                      <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->QA_Head_primary_attachment1)
                            @foreach ($data->QA_Head_primary_attachment1 as $key => $file)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div>
            </div> -->
           <!-- Preliminary Lab. Investigation TapII -->
            <div class="block">
                <div class="block-head">PHASE II INVESTIGATION (Extended laboratory Investigation)</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Hypothesis Analysis :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->hypothesis_analysis ){{ $data->hypothesis_analysis }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Results of Hypothesis :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->results_hypothesis ){{ $data->results_hypothesis }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Evaluation Of Hypothesis & Comments :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->evaluation_of_hypothesis_comments ){{ $data->evaluation_of_hypothesis_comments }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Hypothesis Root Cause :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->hypothesis_root_cause ){{ $data->hypothesis_root_cause }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Impact assessment/Risk assessment :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->impact_assessment_risk ){{ $data->impact_assessment_risk }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Preventive action :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->preventive_action_phase1b ){{ $data->preventive_action_phase1b }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Evaluation By Head Quality / Designee :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->evaluation_by_head_quality ){{ $data->evaluation_by_head_quality }} @else Not Applicable @endif</span>
                </div>

                {{-- <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Outcome Of Phase II Extended Laboratory Investigation :</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->outcome_phase_ib_investigation2 ){{ $data->outcome_phase_ib_investigation2 }} @else Not Applicable @endif</span>
                </div> --}}


                <!-- <div class="inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Checklists</label>
                    <span style="font-size:0.8rem; margin-left:10px">
                        @if($data->checklists)
                            {{ is_array($data->checklists) ? implode(', ', $data->checklists) : $data->checklists }}
                        @else
                            Not Applicable
                        @endif
                    </span>
                </div> -->



                <!-- <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Checklist Outcome</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->justify_if_no_field_alert_pli ){{ $data->justify_if_no_field_alert_pli }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Immediate action taken</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->root_comment ){{ $data->root_comment }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Delay Justification For Investigation</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->justify_if_no_analyst_int_pli ){{ $data->justify_if_no_analyst_int_pli }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Analyst Interview Details</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->analyst_interview_pli ){{ $data->analyst_interview_pli }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Any Other Cause/Suspected Cause</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->Any_other_cause ){{ $data->Any_other_cause }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Any Other Batches Analyzed</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->Any_other_batches ){{ $data->Any_other_batches }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Details Of Trend</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->details_of_trend ){{ $data->details_of_trend }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Assignable Cause And Rational For Assignable Cause</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->rational_for_assingnable ){{ $data->rational_for_assingnable }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Summary of Investigation</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->summary_of_prelim_investiga_plic ){{ $data->summary_of_prelim_investiga_plic }} @else Not Applicable @endif</span>
                </div> -->
            </div>
            <div class="block">
            <div class="block-head">PHASE II INVESTIGATION (Manufacturing Investigation)</div>


            </div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Brief Summary of Phase II Investigation</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->phase_ii_investigation ){! $data->phase_ii_investigation !} @else Not Applicable @endif</span>
                    </div>

                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Brief Summary of Root Cause</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->brief_summary_root_cause ){! $data->brief_summary_root_cause !} @else Not Applicable @endif</span>
                    </div>


                    <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Brief Summary of Action taken/planned</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->brief_summary_taken_planned ){!$data->brief_summary_taken_planned !} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Comment Of Head Quality/Designee</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->comment_of_head_qualiry ){! $data->comment_of_head_qualiry !} @else Not Applicable @endif</span>
                </div>

                {{-- <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Recommendation for Batch Disposition</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->recommendation_for_batch ){{ $data->recommendation_for_batch }} @else Not Applicable @endif</span>
                </div> --}}
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Test Results</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->phaseiii_results ){{ $data->phaseiii_results }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Limit</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->phaseiii_limit ){{ $data->phaseiii_limit }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Conclusion</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->conclusion ){{ $data->conclusion }} @else Not Applicable @endif</span>
                </div>
                
               

                <!-- <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Impact Assessment</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->impact_assesment_pia ){{ $data->impact_assesment_pia }} @else Not Applicable @endif</span>
                </div> -->

                <!-- <div class="block-head">Analyst Interview Attachment</div>
                      <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->file_attachments_pli)
                            @foreach ($data->file_attachments_pli as $key => $file)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div> -->

                <!-- <div class="block-head">Supporting Attachments</div>
                <div class="border-table">
                  <table>
                      <tr class="table_bg">
                          <th class="w-20">S.N.</th>
                          <th class="w-80">File </th>
                      </tr>
                      @if ($data->supporting_attachments_plir)
                      @foreach ($data->supporting_attachments_plir as $key => $file)
                           <tr>
                              <td class="w-20">{{ $key + 1 }}</td>
                              <td class="w-80"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                          </tr>
                      @endforeach
                      @else
                          <tr>
                              <td class="w-20">1</td>
                              <td class="w-20">Not Applicable</td>
                          </tr>
                      @endif
                  </table>
                </div> -->



            </div>

              <div class="block">
                <div class="block-head">Material Re-Sampling Authorization</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Reason/Justification for re-sampling</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->reason_justification ){{ $data->reason_justification }} @else Not Applicable @endif</span>
                </div>
               </div>
               {{-- <div class="block">
                <div class="block-head">Phase IA HOD Attachment</div>
                      <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->hod_attachment2)
                            @foreach ($data->hod_attachment2 as $key => $file)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div>
               </div> --}}

            <div class="block">
                <div class="block-head">Instrument Details</div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 4%">Row#</th>
                            <th style="width: 8%">Batch No.</th>
                            <th style="width: 8%">AR No.</th>
                            <th style="width: 8%">Stage of Investigation</th>
                            <th style="width: 8%">Quantity</th>
                            <th style="width: 8%">Authorized By/ Head Quality</th>
                            <th style="width: 8%">Sampled By</th>
                        </tr>

                        @if(($instrument_details) && is_array($instrument_details->data))
                        @foreach ($instrument_details->data as $key => $instrument_detail)
                        <tr>
                            <td class="w-15">{{ $instrument_detail ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $instrument_detail['grid_batch_no'] ?  $instrument_detail['grid_batch_no']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['grid_arnumber'] ?  $instrument_detail['grid_arnumber']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['grid_stage_investigation'] ?  $instrument_detail['grid_stage_investigation']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['grid_quantity'] ?  $instrument_detail['grid_quantity']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['grid_authorized_by'] ?  $instrument_detail['grid_authorized_by']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $instrument_detail['grid_sampled_by'] ?  $instrument_detail['grid_sampled_by']: "Not Applicable"}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>1</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
               </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Material Re-Sampling Results</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->material_results ){{ $data->material_results }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Material Re-Sampling Conclusion</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->material_conclusion ){{ $data->material_conclusion }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Material Re-Sampling Evaluation by Quality Head/Designee</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->evaluation_by_quality_designee ){{ $data->evaluation_by_quality_designee }} @else Not Applicable @endif</span>
                </div>
               </div>
               <div class="block">
                <div class="block-head">PHASE -III - INVESTIGATION</div>
                <p>Results from Analyst-2</p>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 4%">Row#</th>
                            <th style="width: 8%">Set-I</th>
                            <th style="width: 8%">Set-II</th>
                            <th style="width: 8%">Set-III</th>
                        </tr>

                        @if(($data) && is_array($data->data))
                        @foreach ($data->data as $key => $phase_iii_result)
                        <tr>
                            <td class="w-15">{{ $phase_iii_result ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $phase_iii_result['phase_iii_result_set_1'] ?  $phase_iii_result['phase_iii_result_set_1']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $phase_iii_result['phase_iii_result_set_2'] ?  $phase_iii_result['phase_iii_result_set_2']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $phase_iii_result['phase_iii_result_set_3'] ?  $phase_iii_result['phase_iii_result_set_3']: "Not Applicable"}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>1</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Phase-III Investigator</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->phase_iii_investigator ){{ $data->phase_iii_investigator }} @else Not Applicable @endif</span>
                </div>

                <p>Results from Analyst-1</p>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 4%">Row#</th>
                            <th style="width: 8%">Set-I</th>
                            <th style="width: 8%">Set-II</th>
                            <th style="width: 8%">Set-III</th>
                        </tr>

                        @if(($data) && is_array($data->data))
                        @foreach ($data->data as $key => $phase_iii_result_i)
                        <tr>
                            <td class="w-15">{{ $phase_iii_result_i ? $key + 1  : "Not Applicable" }}</td>
                            <td class="w-15">{{ $phase_iii_result_i['phase_iii_result_i_set_1'] ?  $phase_iii_result_i['phase_iii_result_i_set_1']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $phase_iii_result_i['phase_iii_result_i_set_2'] ?  $phase_iii_result_i['phase_iii_result_i_set_2']: "Not Applicable"}}</td>
                            <td class="w-15">{{ $phase_iii_result_i['phase_iii_result_i_set_3'] ?  $phase_iii_result_i['phase_iii_result_i_set_3']: "Not Applicable"}}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>1</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Average of all six test results:</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->average_all_six_result ){! $data->average_all_six_result !} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Investigator</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->phase_iii_investigator_result1 ){{ $data->phase_iii_investigator_result1 }} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Conclusion By Head QC</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->conclusion_by_qc_head ){{ $data->conclusion_by_qc_head }} @else Not Applicable @endif</span>
                </div>

               </div>

            <div class="block">
                <div class="block-head">PHASE -III (ADDITIONAL INVESTIGATION)</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Impact assessment on other batches or product</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->impact_assessment_on_batches ){! $data->impact_assessment_on_batches !} @else Not Applicable @endif</span>
                </div>


                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Corrective Action</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->phase_iii_corrective ){! $data->phase_iii_corrective !} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Preventive Action</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->phase_iii_preventive ){! $data->phase_iii_preventive !} @else Not Applicable @endif</span>
                </div>

                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Evaluation by Head Quality/Designee</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->phase_iii_evaluation ){! $data->phase_iii_evaluation !} @else Not Applicable @endif</span>
                </div>

                <!-- <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">OutCome Of Phase III (additional) Investigation</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->assign_cause_found ){{ $data->assign_cause_found }} @else Not Applicable @endif</span>
                </div> -->
            </div>


              <!-- <div class="block">
                <div class="block-head">Preventive Action</div>
                <div class="border-table">
                  <table>
                      <tr class="table_bg">
                          <th class="w-20">S.N.</th>
                          <th class="w-80">File </th>
                      </tr>
                      @if ($data->QA_Head_primary_attachment2)
                      @foreach ($data->QA_Head_primary_attachment2 as $key => $file)
                           <tr>
                              <td>{{ $key + 1 }}</td>
                              <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                          </tr>
                      @endforeach
                      @else
                          <tr>
                              <td class="w-20">1</td>
                              <td class="w-20">Not Applicable</td>
                          </tr>
                      @endif
                  </table>
                </div>
              </div> -->

              <div class="block">
                <div class="block-head">JUSTIFICATION FOR DELAY IN CLOSING</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">OOS No. Product/Material</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->justification_delay_no ){{ $data->justification_delay_no }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Target closure date</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->justification_closure_date ){{ $data->justification_closure_date }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Extended date for closure</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->justification_extended_date ){{ $data->justification_extended_date }} @else Not Applicable @endif</span>
                </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:1rem; display:inline;">Justification</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->justification_text ){{ $data->justification_text }} @else Not Applicable @endif</span>
                </div>
              </div>
              <!-- <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Any Other Comments/ Probable Cause Evidence</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Any_other_Comments ){{ $data->Any_other_Comments }} @else Not Applicable @endif</span>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Proposal For Hypothesis Testing To Confirm Probable Cause Identified</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Proposal_for_Hypothesis ){{ $data->Proposal_for_Hypothesis }} @else Not Applicable @endif</span>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Summary Of Hypothesis</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Summary_of_Hypothesis ){{ $data->Summary_of_Hypothesis }} @else Not Applicable @endif</span>
              </div>
              <div class="block">
                <table>
                  <tr>
                    <th class="w-20">Assignable Cause</th>
                    <td class="w-80">{{ $data->Assignable_Cause ? $data->Assignable_Cause : 'Not Applicable' }}</td>
                    <th class="w-20">Types Of Assignable Cause</th>
                    <td class="w-80">{{ $data->Types_of_assignable ? $data->Types_of_assignable : 'Not Applicable' }}</td>
                  </tr>
               </table>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Others</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Types_of_assignable_others ){{ $data->Types_of_assignable_others }} @else Not Applicable @endif</span>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Evaluation Of Phase IB Investigation Timeline</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Evaluation_Timeline ){{ $data->Evaluation_Timeline }} @else Not Applicable @endif</span>
              </div>
              <div class="block">
                <table>
                  <tr>
                    <th class="w-20">Is Phase IB Investigation Timeline Met</th>
                    <td class="w-80">{{ $data->timeline_met ? $data->timeline_met : 'Not Applicable' }}</td>
                  </tr>
               </table>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">If No, Justify For Timeline Extension</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->timeline_extension ){{ $data->timeline_extension }} @else Not Applicable @endif</span>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">CAPA Applicable</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->CAPA_applicable ){{ $data->CAPA_applicable }} @else Not Applicable @endif</span>
              </div>
              <div class="block">
                <table>
                  <tr>
                    <th class="w-20">Resampling Required</th>
                    <td class="w-80">{{ $data->resampling_required_ib ? $data->resampling_required_ib : 'Not Applicable' }}</td>
                    <th class="w-20">Repeat Testing Required</th>
                    <td class="w-80">{{ $data->repeat_testing_ib ? $data->repeat_testing_ib : 'Not Applicable' }}</td> 
                  </tr>
               </table>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Repeat Testing Plan</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Repeat_testing_plan ){{ $data->Repeat_testing_plan }} @else Not Applicable @endif</span>
              </div>
              <div class="block">
                <table>
                    <tr>
                        <th class="w-20">Phase II Investigation Required</th>
                        <td class="w-80">{{ $data->phase_ii_inv_req_ib ? $data->phase_ii_inv_req_ib : 'Not Applicable' }}</td>
                        <th class="w-20">Production Person</th>
                        <td class="w-80">{{ Helpers::getInitiatorName($data->production_person_ib) ? Helpers::getInitiatorName($data->production_person_ib) : 'Not Applicable' }}</td>
                    </tr>
               </table>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Repeat Analysis Method/Resampling</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Repeat_analysis_method ){{ $data->Repeat_analysis_method }} @else Not Applicable @endif</span>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Details Of Repeat Analysis</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Details_repeat_analysis ){{ $data->Details_repeat_analysis }} @else Not Applicable @endif</span>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Impact Assessment</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Impact_assessment1 ){{ $data->Impact_assessment1 }} @else Not Applicable @endif</span>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Conclusion</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->Conclusion1 ){{ $data->Conclusion1 }} @else Not Applicable @endif</span>
              </div>
              </div>

              <div class="block">
                <div class="block-head">File Attachment</div>
                      <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->file_attachment_IB_Inv)
                                @foreach ($data->file_attachment_IB_Inv as $key => $file)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div>
              </div> -->

               {{-- <!-- Phase IB HOD Primary --> ~Aditya Rajput --}}

               <!-- <div class="block">
                <div class="block-head">Phase IB HOD Review</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Phase IB HOD Remark</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->hod_remark3 ){{ $data->hod_remark3 }} @else Not Applicable @endif</span>
                </div>
              </div>
              <div class="block">
                <div class="block-head">Phase IB HOD Attachment</div>
                      <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->hod_attachment3)
                            @foreach ($data->hod_attachment3 as $key => $file)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div>
              </div> -->

               {{-- <!-- Phase IB CQA/QA  --> ~Aditya Rajput --}}

               <!-- <div class="block">
                <div class="block-head">Phase IB CQA/QA Review</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Phase IB CQA/QA Remark</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->QA_Head_remark3 ){{ $data->QA_Head_remark3 }} @else Not Applicable @endif</span>
                </div>
              </div>
              <div class="block">
                <div class="block-head">Phase IB CQA/QA Attachment</div>
                <div class="border-table">
                  <table>
                      <tr class="table_bg">
                          <th class="w-20">S.N.</th>
                          <th class="w-80">File </th>
                      </tr>
                      @if ($data->QA_Head_attachment3)
                      @foreach ($data->QA_Head_attachment3 as $key => $file)
                           <tr>
                              <td>{{ $key + 1 }}</td>
                              <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                          </tr>
                      @endforeach
                      @else
                          <tr>
                              <td class="w-20">1</td>
                              <td class="w-20">Not Applicable</td>
                          </tr>
                      @endif
                  </table>
                </div>
              </div> -->

               {{-- <!-- P-IB CQAH/QAH --> ~Aditya Rajput --}}

               <!-- <div class="block">
                <div class="block-head">Phase IB CQAH/QAH Review</div>
                <table>
                    <tr>
                        <th class="w-20">Escalation required</th>
                        <td class="w-80">{{ $data->escalation_required ? $data->escalation_required : 'Not Applicable' }}</td>
                    </tr>
                 </table>
              </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">If Yes, Notification</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->notification_ib ){{ $data->notification_ib }} @else Not Applicable @endif</span>
            </div>
            <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">If No, Justification</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->justification_ib ){{ $data->justification_ib }} @else Not Applicable @endif</span>
            </div>
              <div class = "inner-block">
                <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">P-IB CQAH/QAH Remark</label>
                <span style="font-size:0.8rem; margin-left:10px">@if($data->QA_Head_primary_remark3 ){{ $data->QA_Head_primary_remark3 }} @else Not Applicable @endif</span>
            </div>
              <div class="block">
                <div class="block-head">Phase IB CQAH/QAH Attachment</div>
                <div class="border-table">
                  <table>
                      <tr class="table_bg">
                          <th class="w-20">S.N.</th>
                          <th class="w-80">File </th>
                      </tr>
                      @if ($data->QA_Head_primary_attachment3)
                      @foreach ($data->QA_Head_primary_attachment3 as $key => $file)
                           <tr>
                              <td>{{ $key + 1 }}</td>
                              <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                          </tr>
                      @endforeach
                      @else
                          <tr>
                              <td class="w-20">1</td>
                              <td class="w-20">Not Applicable</td>
                          </tr>
                      @endif
                  </table>
                </div>
              </div> -->

            {{-- @include('frontend.OOS.comps.allchecklistSingleReport') --}}

            <!-- <div class="block">
                <div class="block-head"> Phase II A Investigation </div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Checklist Outcome</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->checklist_outcome_iia ){{ $data->checklist_outcome_iia }} @else Not Applicable @endif</span>
                </div>
                <div class="block">
                    <table>
                        <tr>
                            <th class="w-20">Production Head Person</th>
                            <td class="w-30">{{ Helpers::getInitiatorName($data->production_head_person) ? Helpers::getInitiatorName($data->production_head_person) : 'Not Applicable' }}</td>
                        </tr>
                   </table>
                  </div>
                  <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Immediate Action Taken</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->qa_approver_comments_piii ){{ $data->qa_approver_comments_piii }} @else Not Applicable @endif</span>
                  </div>
                  <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Delay Justification For Investigation</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->reason_manufacturing_delay ){{ $data->reason_manufacturing_delay }} @else Not Applicable @endif</span>
                  </div>
                  <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Any Other Cause/Suspected Cause</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->audit_comments_piii ){{ $data->audit_comments_piii }} @else Not Applicable @endif</span>
                  </div>
                  <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Summary Investigation</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->hypo_exp_reference_piii ){{ $data->hypo_exp_reference_piii }} @else Not Applicable @endif</span>
                  </div>
                  <div class="block">
                    <table>
                        <tr>
                        <th class="w-20">OOS/OOT Cause Identified II A</th>
                        <td class="w-30">{{ $data->manufact_invest_required_piii ? $data->manufact_invest_required_piii : 'Not Applicable' }}</td>
                        <th class="w-20">OOS/OOT Category II A</th>
                        <td class="w-80">{{ $data->hypo_exp_required_piii ? $data->hypo_exp_required_piii : 'Not Applicable' }}</td>
                        </tr>
                   </table>
                  </div>
                  <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">OOS/OOT Category If Others</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->if_others_oos_category ){{ $data->if_others_oos_category }} @else Not Applicable @endif</span>
                  </div>
                  <div class="block">
                    <table>
                        <tr>
                            <th class="w-20">CAPA Required</th>
                            <td class="w-80">{{ $data->capa_required_iia ? $data->capa_required_iia : 'Not Applicable' }}</td>
                        </tr>
                   </table>
                  </div>
                  <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Reference CAPA No.</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->reference_capa_no_iia ){{ $data->reference_capa_no_iia }} @else Not Applicable @endif</span>
                  </div>
                  <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">OOS/OOT Review For Similar Nature II A</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->OOS_review_similar ){{ $data->OOS_review_similar }} @else Not Applicable @endif</span>
                  </div>
                  <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Impact Assessment</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->impact_assessment_IIA ){{ $data->impact_assessment_IIA }} @else Not Applicable @endif</span>
                  </div>
                  <div class="block">
                    <table>
                        <tr>
                            <th class="w-20">Phase IIB Inv. Required?</th>
                            <td class="w-80">{{ $data->phase_iib_inv_required_plir ? $data->phase_iib_inv_required_plir : 'Not Applicable' }}</td>
                        </tr>
                   </table>
                  </div>
                <div class="block-head">Manufacturing Operater Interview Details</div>
                    <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->file_attachments_pII)
                            @foreach ($data->file_attachments_pII as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-80"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                    </div>
            </div> -->
            {{-- <div class="block">
                <div class="block-head"> CheckList - Phase II Investigation</div>
                  <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th style="width: 5%;">Sr.No.</th>
                            <th style="width: 40%;">Question</th>
                            <th style="width: 20%;">Response</th>
                            <th>Remarks</th>
                        </tr>
                        @if ($phase_two_invss)
                        @foreach ($phase_two_inv_questions as $phase_two_inv_question)
                        <tr>
                            <td class="w-15">{{ $loop->index+1 }}</td>
                            <td class="w-15">{{ $phase_two_inv_question }}</td>
                            <td>{{ Helpers::getArrayKey($phase_two_invss->data[$loop->index], 'response') }} </td>
                            <td class="w-15">{{ Helpers::getArrayKey($phase_two_invss->data[$loop->index], 'remarks') }}</td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                            <td>Not Applicable</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div> --}}
            <!-- <div class="block">
                <table>
                  <div class="block-head">II A Inv. Supporting Attachments</div>
                      <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->attachments_piiqcr)
                            @foreach ($data->attachments_piiqcr as $key => $file)
                                 <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-80"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div>
                </table>
            </div> -->

               {{-- <!-- Phase II A HOD Primary --> ~Aditya Rajput --}}

               <!-- <div class="block">
                <div class="block-head">Phase II A HOD Review</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Phase II A HOD Remark</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->hod_remark4 ){{ $data->hod_remark4 }} @else Not Applicable @endif</span>
                </div>
              </div>
              <div class="block">
                <div class="block-head">Phase II A HOD Attachment</div>
                <div class="border-table">
                  <table>
                      <tr class="table_bg">
                          <th class="w-20">S.N.</th>
                          <th class="w-80">File </th>
                      </tr>
                      @if ($data->hod_attachment4)
                      @foreach ($data->hod_attachment4 as $key => $file)
                           <tr>
                              <td>{{ $key + 1 }}</td>
                              <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                          </tr>
                      @endforeach
                      @else
                          <tr>
                              <td class="w-20">1</td>
                              <td class="w-20">Not Applicable</td>
                          </tr>
                      @endif
                  </table>
                </div>
              </div> -->


               {{-- <!-- Phase II A CQA/QA --> ~Aditya Rajput --}}

               <!-- <div class="block">
                <div class="block-head">Phase II A CQA/QA Review</div>
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Phase II A CQA/QA Remark</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->QA_Head_remark4 ){{ $data->QA_Head_remark4 }} @else Not Applicable @endif</span>
                </div>
              </div>
              <div class="block">
                <div class="block-head">Phase II A CQA/QA Attachment</div>
                      <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->QA_Head_attachment4)
                            @foreach ($data->QA_Head_attachment4 as $key => $file)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div>
              </div> -->

               {{-- <!-- P-II A QAH/CQAH --> ~Aditya Rajput --}}

               <!-- <div class="block">
                <div class="block-head">P-II A QAH/CQAH Review</div>
                
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Phase II A Assinable Cause Found</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->phase_ii_a_assi_cause ){{ $data->phase_ii_a_assi_cause }} @else Not Applicable @endif</span>
                </div>
                
                <div class = "inner-block">
                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">P-II A QAH/CQAH Remark</label>
                    <span style="font-size:0.8rem; margin-left:10px">@if($data->QA_Head_primary_remark4 ){{ $data->QA_Head_primary_remark4 }} @else Not Applicable @endif</span>
                </div>
              </div>
              <div class="block">
                <div class="block-head">P-II A QAH/CQAH Attachment</div>
                      <div class="border-table">
                        <table>
                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-80">File </th>
                            </tr>
                            @if ($data->QA_Head_primary_attachment4)
                            @foreach ($data->QA_Head_primary_attachment4 as $key => $file)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                            @endif
                        </table>
                      </div>
              </div> -->

                {{-- <!-- Phase IIB Investigation --> ~Aditya Rajput --}}

                <!-- <div class="block">
                    <div class="block-head">Phase II B Investigation</div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Summary Of Investigation</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->Summary_Of_Inv_IIB ){{ $data->Summary_Of_Inv_IIB }} @else Not Applicable @endif</span>
                    </div>
                    <div class="block">
                        <table>
                            <tr>
                                <th class="w-20">CAPA Required</th>
                                <td class="w-80">{{ $data->capa_required_IIB ? $data->capa_required_IIB : 'Not Applicable' }}</td>
                            </tr>
                       </table>
                    </div>
                      <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Reference CAPA No.</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->reference_capa_IIB ){{ $data->reference_capa_IIB }} @else Not Applicable @endif</span>
                    </div>
                    <div class="block">
                        <table>
                            <tr>
                                <th class="w-20">Resampling Required IIB Inv.</th>
                                <td class="w-80">{{ $data->resampling_req_IIB ? $data->resampling_req_IIB : 'Not Applicable' }}</td>
                                <th class="w-20">Repeat Testing Required IIB Inv.</th>
                                <td class="w-80">{{ $data->Repeat_testing_IIB ? $data->Repeat_testing_IIB : 'Not Applicable' }}</td>
                            </tr>
                       </table>
                    </div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Results Of Repeat Testing IIB Inv.</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->result_of_rep_test_IIB ){{ $data->result_of_rep_test_IIB }} @else Not Applicable @endif</span>
                    </div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Laboratory Investigation Hypothesis Details</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->Laboratory_Investigation_Hypothesis ){{ $data->Laboratory_Investigation_Hypothesis }} @else Not Applicable @endif</span>
                    </div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Outcome Of Laboratory Investigation</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->Outcome_of_Laboratory ){{ $data->Outcome_of_Laboratory }} @else Not Applicable @endif</span>
                    </div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Evaluation</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->Evaluation_IIB ){{ $data->Evaluation_IIB }} @else Not Applicable @endif</span>
                    </div>
                    <div class="block">
                        <table>
                            <tr>
                                <th class="w-20">Assignable Cause</th>
                                <td class="w-80">{{ $data->Assignable_Cause111 ? $data->Assignable_Cause111 : 'Not Applicable' }}</td>
                            </tr>
                       </table>
                    </div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">If Assignable Cause Identified Perform Re-testing</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->If_assignable_cause ){{ $data->If_assignable_cause }} @else Not Applicable @endif</span>
                    </div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">If Assignable Cause Is Not Identified Proceed As Per Phase III Investigation</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->If_assignable_error ){{ $data->If_assignable_error }} @else Not Applicable @endif</span>
                    </div>
                </div> -->


               {{-- <!-- Phase II B HOD Primary --> ~Aditya Rajput --}}

                <!-- <div class="block">
                    <div class="block-head">Phase II B HOD Review</div>
                    <div class = "inner-block">
                        <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Phase II B HOD Remark</label>
                        <span style="font-size:0.8rem; margin-left:10px">@if($data->hod_remark5 ){{ $data->hod_remark5 }} @else Not Applicable @endif</span>
                    </div>
                </div>
                <div class="block">
                    <div class="block-head">Phase II B HOD Attachment</div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-80">File </th>
                                </tr>
                                @if ($data->hod_attachment5)
                                @foreach ($data->hod_attachment5 as $key => $file)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td class="w-20">1</td>
                                        <td class="w-20">Not Applicable</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                </div> -->

                    {{-- <!-- Phase II B CQA/QA --> ~Aditya Rajput --}}

                    <!-- <div class="block">
                        <div class="block-head">Phase II B CQA/QA Review</div>
                        <div class = "inner-block">
                            <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Phase II B CQA/QA Remark</label>
                            <span style="font-size:0.8rem; margin-left:10px">@if($data->QA_Head_remark5 ){{ $data->QA_Head_remark5 }} @else Not Applicable @endif</span>
                        </div>
                    </div>
                    <div class="block">
                        <div class="block-head">Phase II B CQA/QA Attachment</div>
                            <div class="border-table">
                                <table>
                                    <tr class="table_bg">
                                        <th class="w-20">S.N.</th>
                                        <th class="w-80">File </th>
                                    </tr>
                                    @if ($data->QA_Head_attachment5)
                                    @foreach ($data->QA_Head_attachment5 as $key => $file)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td class="w-20">1</td>
                                            <td class="w-20">Not Applicable</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                    </div> -->

                 {{-- <!-- P-II A QAH/CQAH --> ~Aditya Rajput --}}

                            <!-- <div class="block">
                                <div class="block-head">P-II A QAH/CQAH Review</div>
                                <div class = "inner-block">
                                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">P-II A QAH/CQAH Remark</label>
                                    <span style="font-size:0.8rem; margin-left:10px">@if($data->QA_Head_primary_remark4 ){{ $data->QA_Head_primary_remark4 }} @else Not Applicable @endif</span>
                                </div>
                            </div>
                            <div class="block">
                                <div class="block-head">P-II A QAH/CQAH Attachment</div>
                                <div class="border-table">
                                    <table>
                                        <tr class="table_bg">
                                            <th class="w-20">S.N.</th>
                                            <th class="w-80">File </th>
                                        </tr>
                                        @if ($data->QA_Head_primary_attachment4)
                                        @foreach ($data->QA_Head_primary_attachment4 as $key => $file)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                            </tr>
                                        @endforeach
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            <div class="block">
                                <div class="block-head">Phase II B QAH/CQAH Review</div>
                                <div class = "inner-block">
                                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Approval Comment</label>
                                    <span style="font-size:0.8rem; margin-left:10px">@if($data->reopen_approval_comments_uaa ){{ $data->reopen_approval_comments_uaa }} @else Not Applicable @endif</span>
                                </div>
                                <div class="block">
                                    <div class="block-head"> Approval Attachment</div>
                                    <div class="border-table">
                                        <table>
                                            <tr class="table_bg">
                                                <th class="w-20">S.N.</th>
                                                <th class="w-80">File </th>
                                            </tr>
                                            @if ($data->addendum_attachment_uaa)
                             
                                            @else
                                                <tr>
                                                    <td class="w-20">1</td>
                                                    <td class="w-20">Not Applicable</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                                <div class="block">
                                    <table>
                                        <tr>
                                            <th class="w-20">OOS/OOT Category</th>
                                            <td class="w-80">{{ $data->oos_category_bd ? $data->oos_category_bd : 'Not Applicable' }}</td>
                                            <th class="w-20">Material/Batch Release</th>
                                            <td class="w-80">{{ $data->material_batch_release_bd ? $data->material_batch_release_bd : 'Not Applicable' }}</td>
                                        </tr>
                                   </table>
                                </div>
                                <div class = "inner-block">
                                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Other's</label>
                                    <span style="font-size:0.8rem; margin-left:10px">@if($data->others_bd ){{ $data->others_bd }} @else Not Applicable @endif</span>
                                </div>
                                <div class = "inner-block">
                                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Other Action (Specify)</label>
                                    <span style="font-size:0.8rem; margin-left:10px">@if($data->other_action_bd ){{ $data->other_action_bd }} @else Not Applicable @endif</span>
                                </div>
                                <div class = "inner-block">
                                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Other Parameters Results</label>
                                    <span style="font-size:0.8rem; margin-left:10px">@if($data->other_parameters_results_bd ){{ $data->other_parameters_results_bd }} @else Not Applicable @endif</span>
                                </div>
                                <div class = "inner-block">
                                    <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Justify for Delay in Activity</label>
                                    <span style="font-size:0.8rem; margin-left:10px">@if($data->justify_for_delay_in_activity_bd ){{ $data->justify_for_delay_in_activity_bd }} @else Not Applicable @endif</span>
                                </div>
                                    <table>
                                    <div class="block-head"> Disposition Attachment</div>
                                    <div class="border-table">
                                    <table>
                                        <tr class="table_bg">
                                            <th class="w-20">S.N.</th>
                                            <th class="w-80">File </th>
                                        </tr>
                                        @if ($data->disposition_attachment_bd)
               
                                        @else
                                            <tr>
                                                <td class="w-20">1</td>
                                                <td class="w-20">Not Applicable</td>
                                            </tr>
                                        @endif
                                    </table>
                                    </div>


                                </table>
                            </div> -->

                                    {{-- <div class="block">
                                        <div class="block-head"> Additional Testing Proposal by QA </div>
                                        <table>
                                            <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                                                <th class="w-20">Review Comment</th>
                                                <td class="w-30">{{ $data->review_comment_atp ? $data->review_comment_atp : 'Not Applicable' }}</td>
                                                <th class="w-20">Additional Test Proposal</th>
                                                <td class="w-30">{{ $data->additional_test_proposal_atp ? $data->additional_test_proposal_atp : 'Not Applicable' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="w-20">Additional Test Comment</th>
                                                <td class="w-80">{{ $data->additional_test_reference_atp ? $data->additional_test_reference_atp : 'Not Applicable' }}</td>
                                            </tr>
                                            <tr>
                                                <th class="w-20">Any Other Actions Required </th>
                                                <td class="w-80">{{ $data->any_other_actions_required_atp ? $data->any_other_actions_required_atp : 'Not Applicable' }}</td>
                                            </tr>

                                        <div class="block-head"> Additional Testing Attachment</div>
                                            <div class="border-table">
                                                <table>
                                                    <tr class="table_bg">
                                                        <th class="w-20">S.N.</th>
                                                        <th class="w-80">File </th>
                                                    </tr>
                                                    @if ($data->additional_testing_attachment_atp)
                                                    @foreach ($data->additional_testing_attachment_atp as $key => $file)
                                                        <tr>
                                                            <td class="w-20">{{ $key + 1 }}</td>
                                                            <td class="w-80"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                                        </tr>
                                                    @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="w-20">1</td>
                                                            <td class="w-20">Not Applicable</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </table>
                                    </div> --}}
                                    <!-- <div class="block">
                                        <div class="block-head"> OOS/OOT Conclusion </div>
                                        <div class = "inner-block">
                                            <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Conclusion Comments</label>
                                            <span style="font-size:0.8rem; margin-left:10px">@if($data->conclusion_comments_oosc ){{ $data->conclusion_comments_oosc }} @else Not Applicable @endif</span>
                                        </div>
                                        <div class = "inner-block">
                                            <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Specification Limit</label>
                                            <span style="font-size:0.8rem; margin-left:10px">@if($data->specification_limit_oosc ){{ $data->specification_limit_oosc }} @else Not Applicable @endif</span>
                                        </div>
                                        <div class="block">
                                            <table>
                                                <tr>
                                                    <th class="w-20">Results to be Reported</th>
                                                    <td class="w-80">{{ $data->results_to_be_reported_oosc ? $data->results_to_be_reported_oosc : 'Not Applicable' }}</td>
                                                </tr> 
                                           </table>
                                        </div>
                                        <div class = "inner-block">
                                            <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Final Reportable Results</label>
                                            <span style="font-size:0.8rem; margin-left:10px">@if($data->final_reportable_results_oosc ){{ $data->final_reportable_results_oosc }} @else Not Applicable @endif</span>
                                        </div>
                                        <div class = "inner-block">
                                            <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Justifi. for Averaging Results</label>
                                            <span style="font-size:0.8rem; margin-left:10px">@if($data->justifi_for_averaging_results_oosc ){{ $data->justifi_for_averaging_results_oosc }} @else Not Applicable @endif</span>
                                        </div>
                                        <div class="block">
                                            <table>
                                                <tr>
                                                    <th class="w-20">OOS/OOT Stands</th>
                                                    <td class="w-80">{{ $data->oos_stands_oosc ? $data->oos_stands_oosc : 'Not Applicable' }}</td>
                                                    <th class="w-20">CAPA Req.</th>
                                                    <td class="w-80">{{ $data->capa_req_oosc ? $data->capa_req_oosc : 'Not Applicable' }}</td>
                                                </tr>
                                           </table>
                                        </div>
                                        <div class="block">
                                            <table>
                                                <tr>
                                                    <th class="w-20">CAPA Ref No.</th>
                                                    <td class="w-80">{{ $data->capa_ref_no_oosc ? $data->capa_ref_no_oosc : 'Not Applicable' }}</td>
                                                </tr>
                                           </table>
                                        </div>
                                        <div class = "inner-block">
                                            <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Justify If CAPA Not Required</label>
                                            <span style="font-size:0.8rem; margin-left:10px">@if($data->justify_if_capa_not_required_oosc ){{ $data->justify_if_capa_not_required_oosc }} @else Not Applicable @endif</span>
                                        </div> -->
                                            {{-- <div class="block">
                                                <div class="block-head"> Summary of OOS Test Results </div>
                                                <div class="border-table">
                                                <table>
                                                        <tr class="table_bg">
                                                            <th style="width: 4%">Row#</th>
                                                                <th style="width: 14%">Analysis Detials</th>
                                                                <th style="width: 10%">Hypo./Exp./Add.Test PR No.</th>
                                                                <th style="width: 10%">Results</th>
                                                                <th style="width: 10%">Analyst Name.</th>
                                                                <th style="width: 16%">Remarks</th>
                                                        </tr>
                                                        @if ($oos_conclusion)
                                                        @foreach ($oos_conclusion->data as $key => $oos_conclusion)
                                                        <tr>
                                                            <td style="width: 8%">{{$loop->index + 1 }}</td>
                                                            <td style="width: 8%">{{ Helpers::getArrayKey($oos_conclusion, 'summary_results_analysis_detials') }}</td>
                                                            <td style="width: 8%">{{ Helpers::getArrayKey($oos_conclusion, 'summary_results_hypothesis_experimentation_test_pr_no') }}</td>
                                                            <td style="width: 8%">{{ Helpers::getArrayKey($oos_conclusion, 'summary_results') }}</td>
                                                            <td style="width: 8%">{{ Helpers::getArrayKey($oos_conclusion, 'summary_results_analyst_name') }}</td>
                                                            <td style="width: 8%">{{ Helpers::getArrayKey($oos_conclusion, 'summary_results_remarks') }}</td>
                                                        </tr>

                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td>Not Applicable</td>
                                                            <td>Not Applicable</td>
                                                            <td>Not Applicable</td>
                                                            <td>Not Applicable</td>
                                                        </tr>
                                                        @endif
                                                    </table>
                                                </div>
                                            </div> --}}
                                            <!-- <div class="block-head"> Attachments if Any </div>
                                            <div class="border-table">
                                                <table>
                                                    <tr class="table_bg">
                                                        <th class="w-20">S.N.</th>
                                                        <th class="w-80">File </th>
                                                    </tr>
                                                    @if ($data->file_attachments_if_any_ooscattach)
                                                    @foreach ($data->file_attachments_if_any_ooscattach as $key => $file)
                                                        <tr>
                                                            <td class="w-20">{{ $key + 1 }}</td>
                                                            <td class="w-80"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                                        </tr>
                                                    @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="w-20">1</td>
                                                            <td class="w-20">Not Applicable</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </table>
                                    </div>
                                    <div class="block">
                                        <div class="block-head"> Conclusion Review Comments </div>
                                        <div class = "inner-block">
                                            <label class="summer" style="font-weight: bold; font-size:13px; display:inline;">Action On Affected Batches</label>
                                            <span style="font-size:0.8rem; margin-left:10px">@if($data->action_on_affected_batch ){{ $data->action_on_affected_batch }} @else Not Applicable @endif</span>
                                        </div>
                                        <table>
                                            <div class="block-head">Conclusion Attachment </div>
                                            <div class="border-table">
                                                <table>
                                                    <tr class="table_bg">
                                                        <th class="w-20">S.N.</th>
                                                        <th class="w-80">File </th>
                                                    </tr>
                                                    @if ($data->conclusion_attachment_ocr)
                              
                                                    @else
                                                        <tr>
                                                            <td class="w-20">1</td>
                                                            <td class="w-20">Not Applicable</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </table>
                                    </div> -->
                                    {{-- <div class="block">
                                        <div class="block-head"> OOS QA Review </div>
                                        <table>
                                            <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                                                <th class="w-20">CQ Review Comments</th>
                                                <td class="w-30">{{ $data->cq_review_comments_ocqr ? $data->cq_review_comments_ocqr : 'Not Applicable' }}</td>
                                            </tr>

                                        <div class="block-head"> CQ Attachment</div>
                                            <div class="border-table">
                                                <table>
                                                    <tr class="table_bg">
                                                        <th class="w-20">S.N.</th>
                                                        <th class="w-80">File </th>
                                                    </tr>
                                                    @if ($data->cq_attachment_ocqr)
                                                    @foreach ($data->cq_attachment_ocqr as $key => $file)
                                                        <tr>
                                                            <td class="w-20">{{ $key + 1 }}</td>
                                                            <td class="w-80"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                                        </tr>
                                                    @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="w-20">1</td>
                                                            <td class="w-20">Not Applicable</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </table>
                                    </div> --}}

                                    {{-- <div class="block">
                                        <div class="block-head">  QA Head/designee Approval </div>
                                        <table>
                                            <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                                                <th class="w-20">Approval Comment</th>
                                                <td class="w-30">{{ $data->reopen_approval_comments_uaa ? $data->reopen_approval_comments_uaa : 'Not Applicable' }}</td>
                                            </tr>

                                        <div class="block-head"> Approval Attachment</div>
                                            <div class="border-table">
                                                <table>
                                                    <tr class="table_bg">
                                                        <th class="w-20">S.N.</th>
                                                        <th class="w-80">File </th>
                                                    </tr>
                                                    @if ($data->addendum_attachment_uaa)
                                                    @foreach ($data->addendum_attachment_uaa as $key => $file)
                                                        <tr>
                                                            <td class="w-20">{{ $key + 1 }}</td>
                                                            <td class="w-80"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                                        </tr>
                                                    @endforeach
                                                    @else
                                                        <tr>
                                                            <td class="w-20">1</td>
                                                            <td class="w-20">Not Applicable</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </table>
                                    </div> --}}
                            <!-- close block -->
                                </div>
          </div>


    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>
</body>

</html>
