@extends('layouts.app')

@section('title', 'Data Users')

@section('css-library')
    {{-- Tempat Ngoding Meletakkan css library --}}
@endsection

@section('css-custom')
    {{-- Tempat Ngoding Meletakkan css custom --}}
    <style>
        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(34, 41, 47, 0.125);
            border-radius: 0.428rem;
        }
    
        fieldset {
            display: block;
            margin-inline-start: 2px;
            margin-inline-end: 2px;
            padding-block-start: 0.35em;
            padding-inline-start: 0.75em;
            padding-inline-end: 0.75em;
            padding-block-end: 0.625em;
            min-inline-size: min-content;
            border-width: 2px;
            border-style: groove;
            border-color: rgb(192, 192, 192);
            border-image: initial;
            min-width: 0;
            padding: 0;
            margin: 0;
            border: 0;
        }
    
        fieldset.scheduler-border {
            border: 1px solid rgba(11, 81, 166, 0.5);
            padding: 20px;
            margin-bottom: 1.5em;
            border-radius: 10px;
        }
    
        legend.scheduler-border {
            color: green;
            text-decoration: underline;
            font-style: italic;
            width: auto;
            border: none;
            font-size: large;
        }

        .star-checkbox {
            display: none; /* Sembunyikan checkbox */
        }

        .star {
            font-size: 2.5em;
            cursor: pointer;
        }

        .star:hover {
            color: orange; /* Warna saat hover */
        }

        .star.checked {
            color: orange; /* Warna bintang terpilih */
        }
    </style>
    
@endsection

@section('content')
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">{{ __('Customer Satisfaction') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Customer Satisfaction') }}</li>
                        <li class="breadcrumb-item active" aria-current="page">Add Survey</li>
                    </ol>
                </nav>
            </div>
        </div>
        
    </div>
</div>
<section class="content">
    <div class="row">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="col-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <h4 class="box-title">{{ __('') }}</h4>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end mb-0">
                            <div class="btn-group">
                                <button id="btn-submit" type="submit" class="btn btn-outline btn-success" style="margin-right: 10px;">Save</button>
                                <a href="{{ route('customer-satisfaction') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <form id="form-id" action="{{ route('customer-satisfaction.store', ['id' => Crypt::encrypt($sales_quotation->sq_no)]) }}" method="POST">
                        @csrf
                        <div class="row">
                            @php
                                $lookup_status = \App\Models\LookupModel::where('lookup_config', 'sls_quotation_status')->where('lookup_code', $sales_quotation->status)->first();
                                $lookup_sqType = \App\Models\LookupModel::where('lookup_config', 'sq_type')->where('lookup_code', $sales_quotation->sq_type)->first();
                                $lookup_sqOffMode = \App\Models\LookupModel::where('lookup_config', 'offer_mode')->where('lookup_code', $sales_quotation->oﬀer_mode)->first();
                                $lookup_sqPayment = \App\Models\LookupModel::where('lookup_config', 'payment_terms')->where('lookup_code', $sales_quotation->payment_term)->first();
                                $lookup_sqPayMode = \App\Models\LookupModel::where('lookup_config', 'payment_mode')->where('lookup_code', $sales_quotation->payment_mode)->first();
                                $lookup_sqDelTime = \App\Models\LookupModel::where('lookup_config', 'delivery_times')->where('lookup_code', $sales_quotation->delivery_times)->first();
                                $lookup_sqDelMode = \App\Models\LookupModel::where('lookup_config', 'delivery_mode')->where('lookup_code', $sales_quotation->delivery_mode)->first();
                                $lookup_sqPacking = \App\Models\LookupModel::where('lookup_config', 'packing')->where('lookup_code', $sales_quotation->packing)->first();
                                $lookup_sqSertif = \App\Models\LookupModel::where('lookup_config', 'certification')->where('lookup_code', $sales_quotation->certﬁcate)->first();
                                $lookup_offerVal = \App\Models\LookupModel::where('lookup_config', 'offer_validity')->where('lookup_code', $sales_quotation->oﬀer_validity)->first();
                                $status_text = '';
                                $status_color = '';
                    
                                switch ($sales_quotation->status) {
                                    case "2":
                                    case "8":
                                        $status_text = $lookup_status->lookup_name;
                                        $status_color = 'btn-info';
                                        break;
                                    case "3":
                                    case "9":
                                        $status_text = $lookup_status->lookup_name;
                                        $status_color = 'btn-danger';
                                        break;
                                    case "4":
                                    case "5":
                                    case "10":
                                    case "11":
                                        $status_text = $lookup_status->lookup_name;
                                        $status_color = 'btn-warning';
                                        break;
                                    case "6":
                                    case "7":
                                        $status_text = $lookup_status->lookup_name;
                                        $status_color = 'btn-success';
                                        break;
                                    default:
                                        $status_text = $lookup_status->lookup_name;
                                        $status_color = 'btn-secondary';
                                }
                            @endphp
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Code<span style="color: red">*</span></label>
                                    <input type="text" class="form-control ps-15" value="{{ $sales_customer->cust_code }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Name<span style="color: red">*</span></label>
                                    <input type="text" class="form-control ps-15" value="{{ $sales_customer->cust_name }}" disabled>
                                </div>    
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Survey Status</label>
                                    <input type="text" class="form-control ps-15" value="{{ isset($cp_satisfaction->status) ? '[Survey Finished]' : '[No Survey Yet]' }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 10px;margin-top:20px;">
								<fieldset class="scheduler-border" style="padding: 20px;">
									<legend class="scheduler-border" style="color: green;">SQ Information</legend>
									<div class="row mt-2" style="padding-left: 2.5rem; padding-right: 2.5rem;">
										<div class="col-xl-4 p-0">
											<table style="padding: 20px;">
												<tbody>
													<tr>
														<td class="pr-1" valign="top">SQ No</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $sales_quotation->sq_no }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">INQ No</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $sales_inquiry->inq_no }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">SQ Date</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $sales_quotation->created_date }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Status</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_status->lookup_name }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Offer Mode</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_sqOffMode->lookup_name }}</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-xl-4 p-0">
											<table>
												<tbody>
													<tr>
														<td class="pr-1" valign="top">Est`d Shipping CW</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ rupiah( $sales_quotation->est_ship_weight) }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Payment Term</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_sqPayment->lookup_name }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Payment Mode</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_sqPayMode->lookup_name }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Delivery Time</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_sqDelTime->lookup_name }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Technical Abbreviation/Remarks</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $sales_quotation->send_remarks }}</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-xl-4 p-0">
											<table>
												<tbody>
													<tr>
														<td class="pr-1" valign="top">Delivery Mode</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_sqDelMode->lookup_name }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Packing</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_sqPacking->lookup_name }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Certification</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_sqSertif->lookup_name }}</td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Offer Validity</td>
														<td style="width: 10px;" valign="top">: </td>
														<td valign="top">{{ $lookup_offerVal->lookup_name }}</td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="row" style="margin-bottom: -20px">
										<div class="col-12 d-flex flex-sm-row flex-column" style="justify-content: right;margin-bottom: 20px">
											<a href="javascript:void(0)" onclick="myFunction()">
												<h5 class="show-hide text-info">VIEW MORE SQ DETAIL</h5>
											</a>
										</div>
									</div>

								</fieldset>
							</div>
                            <div id="myDiv" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 10px;margin-top:20px;">
                                        @php
                                            $lookup_stageInquiry    = \App\Models\LookupModel::where('lookup_config', 'sls_stage_inquiry')->where('lookup_code', $sales_inquiry->stage_inquiry)->first();
                                            $lookup_statusInquiry   = \App\Models\LookupModel::where('lookup_config', 'sls_inquiry_status')->where('lookup_code', $sales_inquiry->status)->first();
                                            $lookup_companySector   = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $sales_customer->company_sector)->first();
                                            $lookup_customerType    = \App\Models\LookupModel::where('lookup_config', 'sls_customer_type')->where('lookup_code', $sales_customer->cust_type)->first();
                                            $users                  = \App\Models\User::where('id', Auth::user()->id)->first();
                                        @endphp
                                        <fieldset class="scheduler-border" style="padding: 20px;">
                                            <legend class="scheduler-border" style="color: green;">Inquiry Information</legend>
                                            <div class="row mt-2" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                                                <div class="col-xl-4 p-0">
                                                    <table style="padding: 20px;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Customer Inquiry No</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_inquiry->inq_no }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Stage of Inquiry</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $lookup_stageInquiry->lookup_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Inquiry Date</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_inquiry->created_date }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Status</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $lookup_statusInquiry->lookup_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">PIC Acknowledge</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_inquiry->created_by }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-xl-4 p-0">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Email Datetime</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_inquiry->email_date }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Closing Date</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_inquiry->closing_date }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Subject</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_inquiry->subject }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">PIC Sales</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_customer->user_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Remarks</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_inquiry->remarks }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-xl-4 p-0">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Customer Name</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_customer->cust_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Customer Type</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $lookup_customerType->lookup_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">PIC Customer</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td valign="top">{{ $sales_customer->pic_name }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12" style="margin-bottom: 10px;margin-top:20px;">
                                        <fieldset class="scheduler-border" style="padding: 20px;">
                                            <legend class="scheduler-border" style="color: green;">PRODUCT ORDER HISTORY</legend>
                                            <div class="form-group row">
                                                <div class="table-responsive mt-3">
                                                    <table class="table table-striped table-bordered display" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Customer Material No</th>
                                                                <th>Coating</th>
                                                                <th>Type</th>
                                                                <th>Spec</th>
                                                                <th>Grade</th>
                                                                <th>QTY (Nut)</th>
                                                                <th>Nut (Type)</th>
                                                                <th>Spec</th>
                                                                <th>Grade</th>
                                                                <th>QTY (Washer)</th>
                                                                <th>Washer (Type)</th>
                                                                <th>Diameter</th>
                                                                <th>Length</th>
                                                                <th>Satuan</th>
                                                                <th>QTY Sets</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($quotation_items as $qit)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $qit->cust_mat_code }}</td>
                                                                    <td>{{ $qit->coating }}</td>
                                                                    <td>{{ $qit->type }}</td>
                                                                    <td>{{ $qit->spec }}</td>
                                                                    <td>{{ $qit->grade }}</td>
                                                                    <td>{{ $qit->qty_nut }}</td>
                                                                    <td>{{ $qit->nut }}</td>
                                                                    <td>{{ $qit->spec_nut }}</td>
                                                                    <td>{{ $qit->grade_nut }}</td>
                                                                    <td>{{ $qit->qty_washer }}</td>
                                                                    <td>{{ $qit->washer_type }}</td>
                                                                    <td>{{ $qit->diameter }}</td>
                                                                    <td>{{ $qit->length }}</td>
                                                                    <td>{{ $qit->length_unit }}</td>
                                                                    <td>{{ $qit->qty_sets }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>                            
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Personal Name</label>
                                    <input type="text" class="form-control ps-15" value="{{ $users->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Email Customer</label>
                                    <input type="text" class="form-control ps-15" value="{{ $users->email }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Division / Department</label>
                                    <select id="divisi-customer" class="form-select select2" name="department" aria-label="Default select example" disabled>
                                        <option value="{{ $users->department }}">{{ $users->department ?? '' }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">What are your main requirements to improve our service ?<span class="text-danger">*</span></label>
                                    <textarea rows="5" class="form-control" name="remarks" placeholder="Improvement for our services" required></textarea>
                                </div>
                            </div>
                            <div class="type-form">
                                <div id="type-form-1">
                                    <div class="col-12 mt-3">
                                        <div class="form-group">
                                            <h4 class="text-center" style="color: #0790E8">PERFORMANCE EVALUATION FOR OUR COMPANY</h4>
                                        </div>
                                    </div>
                                    <div id="text-1">
                                        <div class="form-row">
                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                <fieldset class="scheduler-border">
                                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                                    <label class="form-label"><b>Please provide an evaluation of our SERVICES based on the following points</b></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table id="complex_header" class="table table-striped table-bordered display">
                                                                    <thead>
                                                                        <tr class="text-center">
                                                                            <th rowspan="3">No</th>
                                                                            <th rowspan="3">Description Survey</th>
                                                                            <th colspan="10">Category</th>
                                                                            <th rowspan="3">Remarks<span class="text-danger">*</span></th>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            <th colspan="4" style="background-color: red; color:white">Unsatisfactory</th>
                                                                            <th colspan="2" style="background-color: yellow; color:black">Fair</th>
                                                                            <th colspan="2" style="background-color: blue; color:white">Good</th>
                                                                            <th colspan="2" style="background-color: green; color:white">Excelent</th>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            <!-- Kolom Category -->
                                                                            @foreach (range(1, 10) as $value)
                                                                                <th>{{ $value }}</th>
                                                                            @endforeach
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>How was our service/response to the inquiry you sent to PT BBN?</td>
                                                                            @php
                                                                                $services_inquiry_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category1_{{ $value }}" name="services_inquiry" value="{{ $value }}" class="star-checkbox {{ $services_inquiry_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $services_inquiry_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                            <td rowspan="3">
                                                                                <textarea class="form-control dynamic-height" name="services_remarks" placeholder="Remarks"></textarea>
                                                                            </td>
                                                                        </tr>
                
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>How was our service/response to the technical questions/clarifications/explanations you needed?</td>
                                                                            @php
                                                                                $services_technical_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category2_{{ $value }}" name="services_technical" value="{{ $value }}" class="star-checkbox {{ $services_technical_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $services_technical_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td>What is the level of alignment between the inquiry you sent and the proposal submitted by PT BBN?</td>
                                                                            @php
                                                                                $services_level_alignment_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category3_{{ $value }}" name="services_level_alignment" value="{{ $value }}" class="star-checkbox {{ $services_level_alignment_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $services_level_alignment_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    </tbody>
                                                                </table>                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                <fieldset class="scheduler-border">
                                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                                    <label class="form-label"><b>Please provide an evaluation of the COMMERCIAL aspects of the proposal submitted by PT BBN, based on the following points</b></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table id="complex_header" class="table table-striped table-bordered display">
                                                                    <thead>
                                                                        <tr class="text-center">
                                                                            <th rowspan="3">No</th>
                                                                            <th rowspan="3">Description Survey</th>
                                                                            <th colspan="10">Category</th>
                                                                            <th rowspan="3">Remarks<span class="text-danger">*</span></th>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            <th colspan="4" style="background-color: red; color:white">Unsatisfactory</th>
                                                                            <th colspan="2" style="background-color: yellow; color:black">Fair</th>
                                                                            <th colspan="2" style="background-color: blue; color:white">Good</th>
                                                                            <th colspan="2" style="background-color: green; color:white">Excelent</th>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            <!-- Kolom Category -->
                                                                            @foreach (range(1, 10) as $value)
                                                                                <th>{{ $value }}</th>
                                                                            @endforeach
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>What is the level of alignment between the price we offer and the service and quality of materials we supply?</td>
                                                                            @php
                                                                                $commercial_level_alignment_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category4_{{ $value }}" name="commercial_level_alignment" value="{{ $value }}" class="star-checkbox {{ $commercial_level_alignment_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $commercial_level_alignment_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                            <td rowspan="3">
                                                                                <textarea class="form-control dynamic-height" name="commercial_aspect_remarks" placeholder="Remarks"></textarea>
                                                                            </td>
                                                                        </tr>
                
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>What is the level of flexibility in the Terms of Payment provided by PT BBN?</td>
                                                                            @php
                                                                                $commercial_flexibility_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category5_{{ $value }}" name="commercial_flexibility" value="{{ $value }}" class="star-checkbox {{ $commercial_flexibility_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $commercial_flexibility_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td>How is the compliance and completeness of the supporting documents for the Invoice we submitted?</td>
                                                                            @php
                                                                                $commercial_compliance_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category6_{{ $value }}" name="commercial_compliance" value="{{ $value }}" class="star-checkbox {{ $commercial_compliance_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $commercial_compliance_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    </tbody>
                                                                </table>                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="text-2">
                                        <div class="form-row">
                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                <fieldset class="scheduler-border">
                                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                                    <label class="form-label"><b>Please provide an evaluation of the DELIVERY MATERIAL aspect that we have carried out based on the following points</b></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table id="complex_header" class="table table-striped table-bordered display">
                                                                    <thead>
                                                                        <tr class="text-center">
                                                                            <th rowspan="3">No</th>
                                                                            <th rowspan="3">Description Survey</th>
                                                                            <th colspan="10">Category</th>
                                                                            <th rowspan="3">Remarks<span class="text-danger">*</span></th>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            <th colspan="4" style="background-color: red; color:white">Unsatisfactory</th>
                                                                            <th colspan="2" style="background-color: yellow; color:black">Fair</th>
                                                                            <th colspan="2" style="background-color: blue; color:white">Good</th>
                                                                            <th colspan="2" style="background-color: green; color:white">Excelent</th>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            <!-- Kolom Category -->
                                                                            @foreach (range(1, 10) as $value)
                                                                                <th>{{ $value }}</th>
                                                                            @endforeach
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>What is the average accuracy of Delivery Material in relation to the due date of the Purchase Order?</td>
                                                                            @php
                                                                                $delivery_average_value = 7; // Default value
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category7_{{ $value }}" name="delivery_average" value="{{ $value }}" class="star-checkbox {{ $delivery_average_value >= $value ? 'checked' : '' }}" {{ $delivery_average_value >= $value ? 'checked' : '' }}>
                                                                                    <span class="star {{ $delivery_average_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                            <td rowspan="3">
                                                                                <textarea class="form-control dynamic-height" name="delivery_material_remarks" placeholder="Remarks"></textarea>
                                                                            </td>
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>What is the completeness of the documents provided by PT BBN during the material shipment?</td>
                                                                            @php
                                                                                $delivery_completeness_value = 7; // Default value
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category8_{{ $value }}" name="delivery_completeness" value="{{ $value }}" class="star-checkbox {{ $delivery_completeness_value >= $value ? 'checked' : '' }}" {{ $delivery_completeness_value >= $value ? 'checked' : '' }}>
                                                                                    <span class="star {{ $delivery_completeness_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                        
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td>What is the quality, safety, and neatness of the packing materials that PT BBN has been conducting during material shipments?</td>
                                                                            @php
                                                                                $delivery_packing_value = 7; // Default value
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category9_{{ $value }}" name="delivery_packing" value="{{ $value }}" class="star-checkbox {{ $delivery_packing_value >= $value ? 'checked' : '' }}" {{ $delivery_packing_value >= $value ? 'checked' : '' }}>
                                                                                    <span class="star {{ $delivery_packing_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    </tbody>
                                                                </table>                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="text-3">
                                        <div class="form-row">
                                            <div class="col-md-12" style="margin-bottom: 10px;">
                                                <fieldset class="scheduler-border">
                                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                                    <label class="form-label"><b>Please provide an evaluation of the PRODUCT QUALITY aspect of the supplies we provide based on the following points</b></label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive">
                                                                <table id="complex_header" class="table table-striped table-bordered display">
                                                                    <thead>
                                                                        <tr class="text-center">
                                                                            <th rowspan="3">No</th>
                                                                            <th rowspan="3">Description Survey</th>
                                                                            <th colspan="10">Category</th>
                                                                            <th rowspan="3">Remarks<span class="text-danger">*</span></th>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            <th colspan="4" style="background-color: red; color:white">Unsatisfactory</th>
                                                                            <th colspan="2" style="background-color: yellow; color:black">Fair</th>
                                                                            <th colspan="2" style="background-color: blue; color:white">Good</th>
                                                                            <th colspan="2" style="background-color: green; color:white">Excelent</th>
                                                                        </tr>
                                                                        <tr class="text-center">
                                                                            <!-- Kolom Category -->
                                                                            @foreach (range(1, 10) as $value)
                                                                                <th>{{ $value }}</th>
                                                                            @endforeach
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>1</td>
                                                                            <td>How compliant are the Materials sent with the PO specifications?</td>
                                                                            @php
                                                                                $product_compliant_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category10_{{ $value }}" name="product_compliant" value="{{ $value }}" class="star-checkbox {{ $product_compliant_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $product_compliant_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                            <td rowspan="3">
                                                                                <textarea class="form-control dynamic-height" name="product_quality_remarks" placeholder="Remarks"></textarea>
                                                                            </td>
                                                                        </tr>
                
                                                                        <tr>
                                                                            <td>2</td>
                                                                            <td>How complete/compliant are the Certificate documents and other supporting documents provided by BBN in relation to the PO requirements?</td>
                                                                            @php
                                                                                $product_certificate_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category11_{{ $value }}" name="product_certificate" value="{{ $value }}" class="star-checkbox {{ $product_certificate_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $product_certificate_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                
                                                                        <tr>
                                                                            <td>3</td>
                                                                            <td>Is the response and/or resolution action we have taken regarding complaints of nonconformity, both in terms of documents and materials, satisfactory?</td>
                                                                            @php
                                                                                $product_response_value = 7;
                                                                            @endphp
                                                                            @foreach (range(1, 10) as $value)
                                                                                <td>
                                                                                    <input type="checkbox" id="category12_{{ $value }}" name="product_response" value="{{ $value }}" class="star-checkbox {{ $product_response_value >= $value ? 'checked' : '' }}" />
                                                                                    <span class="star {{ $product_response_value >= $value ? 'checked' : '' }}">&#9733;</span>            
                                                                                </td>
                                                                            @endforeach
                                                                        </tr>
                                                                    </tbody>
                                                                </table>                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js-library')
    {{-- Tempat Ngoding Meletakkan js library --}}

@endsection

@section('js-custom')
    {{-- Tempat Ngoding Meletakkan js custom --}}
    <script>
        // Tambahkan event listener untuk setiap span dengan kelas 'star'
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const checkbox = this.previousElementSibling;
                    checkbox.checked = !checkbox.checked; // Toggle nilai checkbox
                    this.classList.toggle('checked'); // Toggle kelas 'checked' pada span
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Fungsi untuk mengatur tinggi textarea sesuai tinggi tabel
            function setTextareaHeight() {
                var tableHeight = $('#complex_header').outerHeight();
                $('.dynamic-height').css('height', tableHeight + 'px');
            }

            // Panggil fungsi saat dokumen dimuat dan saat ukuran window berubah
            setTextareaHeight();
            $(window).resize(setTextareaHeight);
        });
        
        $(document).ready(function() {
            $('.select-companySector').select2({ placeholder: "--Choose Options--" });

            // SUBMIT FORM
            $("#btn-submit").on('click', function(e) {
                e.preventDefault();
                $('#btn-submit').prop('disabled', true);
                
                let formUrl = $('#form-id').attr('action');
                let form_data = $('#form-id').serialize();

                $.ajax({
                    url: formUrl,
                    method: "POST",
                    dataType: "JSON",
                    data: form_data,
                    timeout: 30000,
                    error: function(xmlhttprequest, textstatus, message) {
                        var res = (textstatus === "timeout") ? "Request timeout!" : textstatus;
                        Swal.fire({
                            title: "Error",
                            html: res,
                            icon: "warning"
                        }).then(function() {
                            $('#btn-submit').prop('disabled', false);
                        });
                    },
                    success: function(response) {
                        let alert_text = "";
                        if ($.isArray(response.message)) {
                            $.each(response.message, function(i, message) {
                                alert_text += message + "<br>";
                            });
                        } else if (typeof response.message === 'object') {
                            $.each(response.message, function(key, messages) {
                                alert_text += messages[0] + "<br>";
                            });
                        } else {
                            alert_text = response.message;
                        }

                        if (response.status == true) {
                            Swal.fire({
                                title: "Success",
                                text: response.message,
                                icon: "success",
                                timer: 1500
                            }).then(function() {
                                window.location.href = response.url;
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                html: alert_text,
                                icon: "warning"
                            }).then(function() {
                                $('#btn-submit').prop('disabled', false);
                            });
                        }
                    }
                });
            });
        });
    </script>
    
    <script>
        function myFunction() {
            var myDiv = $('#myDiv');
            var buttonText = $('.show-hide');
    
            if (myDiv.is(':visible')) {
                myDiv.hide();
                buttonText.text('VIEW MORE SQ DETAIL');
                buttonText.removeClass('text-warning');
            } else {
                myDiv.show();
                buttonText.text('HIDE SQ DETAIL');
                buttonText.addClass('text-warning');
            }
        }
    </script>
    
    <script>
        $(function() {
            $('.type-form').hide(); // Semua elemen dengan kelas .type-form disembunyikan secara default
    
            // Fungsi untuk menampilkan elemen berdasarkan nilai yang dipilih saat halaman dimuat
            function showElementsBasedOnValue(value) {
                $('.type-form').show(); // Tampilkan semua elemen .type-form terlebih dahulu
    
                if (value == '' || value == null) {
                    $('.type-form').hide(); // Jika tidak ada yang dipilih, sembunyikan semua .type-form
                } else if (value == 'Procurement / Buyer') {
                    $('#text-1').show();
                    $('#text-2').hide();
                    $('#text-3').hide();
                } else if (value == 'Inventory Control / SCM / Receiving') {
                    $('#text-1').hide();
                    $('#text-2').show();
                    $('#text-3').hide();
                } else if (value == 'QC/QA') {
                    $('#text-1').hide();
                    $('#text-2').hide();
                    $('#text-3').show();
                }
            }
    
            // Panggil fungsi pertama kali saat halaman dimuat
            var initialValue = $('#divisi-customer').val();
            showElementsBasedOnValue(initialValue);
        });
    </script>
    
@endsection
