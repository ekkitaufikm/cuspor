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
        },
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
                        <li class="breadcrumb-item" aria-current="page">Settings</li>
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
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Company Code<span style="color: red">*</span></label>
                                    <input type="text" class="form-control ps-15" value="{{ $sales_customer->cust_code }}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Company Name<span style="color: red">*</span></label>
                                    <input type="text" class="form-control ps-15" value="{{ $sales_customer->cust_name }}" disabled>
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
                                            $lookup_stageInquiry = \App\Models\LookupModel::where('lookup_config', 'sls_stage_inquiry')->where('lookup_code', $sales_inquiry->stage_inquiry)->first();
                                            $lookup_statusInquiry = \App\Models\LookupModel::where('lookup_config', 'sls_inquiry_status')->where('lookup_code', $sales_inquiry->status)->first();
                                            $lookup_companySector = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $sales_customer->company_sector)->first();
                                            $lookup_customerType = \App\Models\LookupModel::where('lookup_config', 'sls_customer_type')->where('lookup_code', $sales_customer->cust_type)->first();
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
                                                                <td valign="top">{{ $sales_customer->user_name }}</td>
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
                                                <label class="col-form-label col-md-2">Total Offer</label>
                                                <div class="col-md-10">
                                                    <input class="form-control" type="text" value="{{ rupiah($sales_quotation->offer_value) }}" disabled>
                                                </div>
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
                                                                <th>Unit Prices</th>
                                                                <th>Amount</th>
                                                                <th>@Kg</th>
                                                                <th>Total Kg</th>
                                                                <th>Level</th>
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
                                                                    <td>{{ rupiah($qit->unit_price) }}</td>
                                                                    <td>{{ rupiah($qit->amount) }}</td>
                                                                    <td>{{ $qit->weight_per_item }}</td>
                                                                    <td>{{ $qit->weight_total }}</td>
                                                                    <td>{{ $qit->level }}</td>
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
                                    <label class="form-label">Survey Status</label>
                                    <input type="text" class="form-control ps-15" value="{{ isset($cp_satisfaction->status) ? '[Survey Finished]' : '[No Survey Yet]' }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">PIC Sales BBN</label>
                                    <input type="text" class="form-control ps-15" value="{{ $sales_customer->user_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">PIC Customer BBN</label>
                                    <input type="text" class="form-control ps-15" value="{{ $sales_customer->pic_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">What are your main requirements to improve our service ?</label>
                                    <textarea rows="5" class="form-control" name="remarks" placeholder="Improvement for our services"></textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <h4 class="text-center" style="color: #0790E8">PERFORMANCE EVALUATION FOR OUR COMPANY</h4>
                                </div>
                            </div>

                            {{-- COMMERCIAL ASPECT --}}
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <fieldset class="scheduler-border">
                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                    <label class="form-label"><b>SURVEY POINT : COMMERCIAL ASPECT</b></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="complex_header" class="table table-striped table-bordered display">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th rowspan="3">No</th>
                                                            <th rowspan="3">Description Survey</th>
                                                            <th colspan="10">Category</th>
                                                            <th rowspan="3">Remarks</th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th colspan="4" style="background-color: red; color:white">Poor</th>
                                                            <th colspan="2" style="background-color: yellow; color:black">Fair</th>
                                                            <th colspan="2" style="background-color: blue; color:white">Good</th>
                                                            <th colspan="2" style="background-color: green; color:white">Excelent</th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <!-- Kolom Category -->
                                                            <th>1</th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                            <th>4</th>
                                                            <th>5</th>
                                                            <th>6</th>
                                                            <th>7</th>
                                                            <th>8</th>
                                                            <th>9</th>
                                                            <th>10</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Telephone Reception</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" name="telephone_reception" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" name="telephone_reception" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" name="telephone_reception" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" name="telephone_reception" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" name="telephone_reception" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" name="telephone_reception" value="5" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" name="telephone_reception" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" name="telephone_reception" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" name="telephone_reception" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" name="telephone_reception" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                            <td rowspan="10">
                                                                <textarea class="form-control dynamic-height" name="commercial_aspect_remarks" placeholder="Remarks"></textarea>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>Time For Quotation</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_1" name="time_for_quotation" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_1" name="time_for_quotation" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_1" name="time_for_quotation" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_1" name="time_for_quotation" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_1" name="time_for_quotation" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_1" name="time_for_quotation" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_1" name="time_for_quotation" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_1" name="time_for_quotation" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_1" name="time_for_quotation" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_1" name="time_for_quotation" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_1"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>Prices</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_2" name="prices" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_2" name="prices" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_2" name="prices" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_2" name="prices" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_2" name="prices" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_2" name="prices" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_2" name="prices" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_2" name="prices" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_2" name="prices" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_2" name="prices" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_2"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>4</td>
                                                            <td>Delivery Document</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_3" name="delivery_document" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_3" name="delivery_document" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_3" name="delivery_document" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_3" name="delivery_document" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_3" name="delivery_document" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_3" name="delivery_document" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_3" name="delivery_document" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_3" name="delivery_document" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_3" name="delivery_document" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_3" name="delivery_document" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_3"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>5</td>
                                                            <td>Invoice Document</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_4" name="invoice_document" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_4" name="invoice_document" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_4" name="invoice_document" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_4" name="invoice_document" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_4" name="invoice_document" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_4" name="invoice_document" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_4" name="invoice_document" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_4" name="invoice_document" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_4" name="invoice_document" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_4" name="invoice_document" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_4"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>6</td>
                                                            <td>Visit Frequency</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_5" name="visit_frequency_ca" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_5" name="visit_frequency_ca" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_5" name="visit_frequency_ca" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_5" name="visit_frequency_ca" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_5" name="visit_frequency_ca" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_5" name="visit_frequency_ca" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_5" name="visit_frequency_ca" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_5" name="visit_frequency_ca" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_5" name="visit_frequency_ca" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_5" name="visit_frequency_ca" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_5"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>7</td>
                                                            <td>Information About Product to be delivered</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_6" name="information_product" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_6" name="information_product" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_6" name="information_product" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_6" name="information_product" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_6" name="information_product" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_6" name="information_product" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_6" name="information_product" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_6" name="information_product" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_6" name="information_product" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_6" name="information_product" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_6"></label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>                        
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            
                            {{-- TECHNICAL ASPECT --}}
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <fieldset class="scheduler-border">
                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                    <label class="form-label"><b>SURVEY POINT : TECHNICAL ASPECT</b></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="complex_header" class="table table-striped table-bordered display">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th rowspan="3">No</th>
                                                            <th rowspan="3">Description Survey</th>
                                                            <th colspan="10">Category</th>
                                                            <th rowspan="3">Remarks</th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th colspan="4" style="background-color: red; color:white">Poor</th>
                                                            <th colspan="2" style="background-color: yellow; color:black">Fair</th>
                                                            <th colspan="2" style="background-color: blue; color:white">Good</th>
                                                            <th colspan="2" style="background-color: green; color:white">Excelent</th>
                                                        </tr>
                                                        <tr>
                                                            <!-- Kolom Category -->
                                                            <th>1</th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                            <th>4</th>
                                                            <th>5</th>
                                                            <th>6</th>
                                                            <th>7</th>
                                                            <th>8</th>
                                                            <th>9</th>
                                                            <th>10</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>General Information</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_1_1" name="general_information" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_1_1" name="general_information" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_1_1" name="general_information" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_1_1" name="general_information" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_1_1" name="general_information" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_1_1" name="general_information" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_1_1" name="general_information" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_1_1" name="general_information" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_1_1" name="general_information" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_1_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_1_1" name="general_information" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_1_1"></label>
                                                            </td>
                                                            <td rowspan="4">
                                                                <textarea class="form-control dynamic-height" name="technical_aspect_remarks" placeholder="Remarks"></textarea>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>Technical Advice</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_1_2" name="technical_advice" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_1_2" name="technical_advice" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_1_2" name="technical_advice" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_1_2" name="technical_advice" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_1_2" name="technical_advice" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_1_2" name="technical_advice" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_1_2" name="technical_advice" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_1_2" name="technical_advice" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_1_2" name="technical_advice" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_1_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_1_2" name="technical_advice" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_1_2"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>Time for answering to technical questions</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_1_3" name="time_answer_tq" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_1_3" name="time_answer_tq" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_1_3" name="time_answer_tq" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_1_3" name="time_answer_tq" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_1_3" name="time_answer_tq" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_1_3" name="time_answer_tq" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_1_3" name="time_answer_tq" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_1_3" name="time_answer_tq" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_1_3" name="time_answer_tq" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_1_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_1_3" name="time_answer_tq" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_1_3"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>4</td>
                                                            <td>Visit Frequency</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_1_4" name="visit_frequency_ta" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_1_4" name="visit_frequency_ta" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_1_4" name="visit_frequency_ta" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_1_4" name="visit_frequency_ta" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_1_4" name="visit_frequency_ta" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_1_4" name="visit_frequency_ta" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_1_4" name="visit_frequency_ta" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_1_4" name="visit_frequency_ta" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_1_4" name="visit_frequency_ta" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_1_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_1_4" name="visit_frequency_ta" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_1_4"></label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>                        
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            {{-- LOGISTICS --}}
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <fieldset class="scheduler-border">
                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                    <label class="form-label"><b>SURVEY POINT : LOGISTICS</b></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="complex_header" class="table table-striped table-bordered display">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th rowspan="3">No</th>
                                                            <th rowspan="3">Description Survey</th>
                                                            <th colspan="10">Category</th>
                                                            <th rowspan="3">Remarks</th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th colspan="4" style="background-color: red; color:white">Poor</th>
                                                            <th colspan="2" style="background-color: yellow; color:black">Fair</th>
                                                            <th colspan="2" style="background-color: blue; color:white">Good</th>
                                                            <th colspan="2" style="background-color: green; color:white">Excelent</th>
                                                        </tr>
                                                        <tr>
                                                            <!-- Kolom Category -->
                                                            <th>1</th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                            <th>4</th>
                                                            <th>5</th>
                                                            <th>6</th>
                                                            <th>7</th>
                                                            <th>8</th>
                                                            <th>9</th>
                                                            <th>10</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Average time for delivery</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_2_1" name="average_time" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_2_1" name="average_time" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_2_1" name="average_time" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_2_1" name="average_time" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_2_1" name="average_time" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_2_1" name="average_time" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_2_1" name="average_time" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_2_1" name="average_time" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_2_1" name="average_time" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_2_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_2_1" name="average_time" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_2_1"></label>
                                                            </td>
                                                            <td rowspan="4">
                                                                <textarea class="form-control dynamic-height" name="logistics_remarks" placeholder="Remarks"></textarea>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>Emergency delivery capacity</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_2_2" name="emergency_delivery" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_2_2" name="emergency_delivery" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_2_2" name="emergency_delivery" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_2_2" name="emergency_delivery" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_2_2" name="emergency_delivery" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_2_2" name="emergency_delivery" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_2_2" name="emergency_delivery" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_2_2" name="emergency_delivery" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_2_2" name="emergency_delivery" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_2_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_2_2" name="emergency_delivery" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_2_2"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>Delivery reliability</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_2_3" name="delivery_reliability" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_2_3" name="delivery_reliability" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_2_3" name="delivery_reliability" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_2_3" name="delivery_reliability" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_2_3" name="delivery_reliability" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_2_3" name="delivery_reliability" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_2_3" name="delivery_reliability" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_2_3" name="delivery_reliability" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_2_3" name="delivery_reliability" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_2_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_2_3" name="delivery_reliability" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_2_3"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>4</td>
                                                            <td>Visit Frequency</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_2_4" name="visit_frequency_log" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_2_4" name="visit_frequency_log" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_2_4" name="visit_frequency_log" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_2_4" name="visit_frequency_log" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_2_4" name="visit_frequency_log" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_2_4" name="visit_frequency_log" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_2_4" name="visit_frequency_log" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_2_4" name="visit_frequency_log" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_2_4" name="visit_frequency_log" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_2_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_2_4" name="visit_frequency_log" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_2_4"></label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>                        
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            {{-- QUALITY --}}
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <fieldset class="scheduler-border">
                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                    <label class="form-label"><b>SURVEY POINT : QUALITY</b></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="complex_header" class="table table-striped table-bordered display">
                                                    <thead>
                                                        <tr class="text-center">
                                                            <th rowspan="3">No</th>
                                                            <th rowspan="3">Description Survey</th>
                                                            <th colspan="10">Category</th>
                                                            <th rowspan="3">Remarks</th>
                                                        </tr>
                                                        <tr class="text-center">
                                                            <th colspan="4" style="background-color: red; color:white">Poor</th>
                                                            <th colspan="2" style="background-color: yellow; color:black">Fair</th>
                                                            <th colspan="2" style="background-color: blue; color:white">Good</th>
                                                            <th colspan="2" style="background-color: green; color:white">Excelent</th>
                                                        </tr>
                                                        <tr>
                                                            <!-- Kolom Category -->
                                                            <th>1</th>
                                                            <th>2</th>
                                                            <th>3</th>
                                                            <th>4</th>
                                                            <th>5</th>
                                                            <th>6</th>
                                                            <th>7</th>
                                                            <th>8</th>
                                                            <th>9</th>
                                                            <th>10</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Product quality</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_3_1" name="product_quality" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_3_1" name="product_quality" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_3_1" name="product_quality" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_3_1" name="product_quality" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_3_1" name="product_quality" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_3_1" name="product_quality" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_3_1" name="product_quality" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_3_1" name="product_quality" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_3_1" name="product_quality" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_3_1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_3_1" name="product_quality" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_3_1"></label>
                                                            </td>
                                                            <td rowspan="5">
                                                                <textarea class="form-control dynamic-height" name="quality_remarks" placeholder="Remarks"></textarea>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>Non confirmity management</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_3_2" name="non_confirmity" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_3_2" name="non_confirmity" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_3_2" name="non_confirmity" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_3_2" name="non_confirmity" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_3_2" name="non_confirmity" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_3_2" name="non_confirmity" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_3_2" name="non_confirmity" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_3_2" name="non_confirmity" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_3_2" name="non_confirmity" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_3_2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_3_2" name="non_confirmity" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_3_2"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>Time for answering to quality questions</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_3_3" name="time_answer_qq" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_3_3" name="time_answer_qq" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_3_3" name="time_answer_qq" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_3_3" name="time_answer_qq" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_3_3" name="time_answer_qq" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_3_3" name="time_answer_qq" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_3_3" name="time_answer_qq" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_3_3" name="time_answer_qq" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_3_3" name="time_answer_qq" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_3_3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_3_3" name="time_answer_qq" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_3_3"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>4</td>
                                                            <td>Management of your inspection report</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_3_4" name="management_inspection" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_3_4" name="management_inspection" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_3_4" name="management_inspection" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_3_4" name="management_inspection" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_3_4" name="management_inspection" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_3_4" name="management_inspection" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_3_4" name="management_inspection" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_3_4" name="management_inspection" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_3_4" name="management_inspection" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_3_4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_3_4" name="management_inspection" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_3_4"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>5</td>
                                                            <td>Time for answering to questions</td>
                                                            <td>
                                                                <input type="checkbox" id="category1_3_5" name="time_anser_quotation" value="1" class="filled-in chk-col-info" />
                                                                <label for="category1_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2_3_5" name="time_anser_quotation" value="2" class="filled-in chk-col-info" />
                                                                <label for="category2_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3_3_5" name="time_anser_quotation" value="3" class="filled-in chk-col-info" />
                                                                <label for="category3_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4_3_5" name="time_anser_quotation" value="4" class="filled-in chk-col-info" />
                                                                <label for="category4_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5_3_5" name="time_anser_quotation" value="5" class="filled-in chk-col-info" />
                                                                <label for="category5_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6_3_5" name="time_anser_quotation" value="6" class="filled-in chk-col-info" />
                                                                <label for="category6_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7_3_5" name="time_anser_quotation" value="7" class="filled-in chk-col-info" />
                                                                <label for="category7_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8_3_5" name="time_anser_quotation" value="8" class="filled-in chk-col-info" />
                                                                <label for="category8_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9_3_5" name="time_anser_quotation" value="9" class="filled-in chk-col-info" />
                                                                <label for="category9_3_5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10_3_5" name="time_anser_quotation" value="10" class="filled-in chk-col-info" />
                                                                <label for="category10_3_5"></label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>                        
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
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
@endsection
