@extends('layouts.app')

@section('title', 'Detail Customer Satisfaction')

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
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
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
                                <a href="{{ route('customer-satisfaction') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
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
                                <input type="text" class="form-control ps-15" value="{{ isset($customer_satisfaction->status) ? '[Survey Finished]' : '[No Survey Yet]' }}" disabled>
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
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">What are your main requirements to improve our service ?<span class="text-danger">*</span></label>
                                <textarea rows="5" class="form-control" name="remarks" placeholder="Improvement for our services" disabled>{{ $customer_satisfaction->remarks }}</textarea>
                            </div>
                        </div>
                        <div class="col-4">
                            @php
                                $nilai_average = (($customer_satisfaction_dtl->services+$customer_satisfaction_dtl->commercial_aspect+$customer_satisfaction_dtl->delivery_material+$customer_satisfaction_dtl->product_quality)/4)
                            @endphp
                            <div class="form-group">
                                <label class="form-label">Average Satisfaction</label>
                                <input type="text" class="form-control ps-15" value="{{ $nilai_average }}%" disabled>
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
                                                                        <th rowspan="3">Remarks</th>
                                                                    </tr>
                                                                    <tr class="text-center">
                                                                        <th colspan="4" style="background-color: red; color:white">Unsatisfactory</th>
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
                                                                        <td>How was our service/response to the inquiry you sent to PT BBN?</td>
                                                                        @php
                                                                            $services_inquiry_value = $customer_satisfaction_dtl->services_inquiry;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1" name="services_inquiry[]" value="1" class="filled-in chk-col-info" {{ $services_inquiry_value >= 1 ? 'checked disabled' : '' }} disabled  />
                                                                            <label for="category1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2" name="services_inquiry" value="2" class="filled-in chk-col-info" {{ $services_inquiry_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3" name="services_inquiry" value="3" class="filled-in chk-col-info" {{ $services_inquiry_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4" name="services_inquiry" value="4" class="filled-in chk-col-info" {{ $services_inquiry_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5" name="services_inquiry" value="5" class="filled-in chk-col-info" {{ $services_inquiry_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6" name="services_inquiry" value="5" class="filled-in chk-col-info" {{ $services_inquiry_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7" name="services_inquiry" value="7" class="filled-in chk-col-info" {{ $services_inquiry_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8" name="services_inquiry" value="8" class="filled-in chk-col-info" {{ $services_inquiry_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9" name="services_inquiry" value="9" class="filled-in chk-col-info" {{ $services_inquiry_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10" name="services_inquiry" value="10" class="filled-in chk-col-info" {{ $services_inquiry_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10"></label>
                                                                        </td>
                                                                        <td rowspan="3">
                                                                            <textarea class="form-control dynamic-height" name="services_remarks" placeholder="Remarks" disabled>{{ $customer_satisfaction_dtl->services_remarks }}</textarea>
                                                                        </td>
                                                                    </tr>
            
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>How was our service/response to the technical questions/clarifications/explanations you needed?</td>
                                                                        @php
                                                                            $services_technical_value = $customer_satisfaction_dtl->services_technical;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_1" name="services_technical" value="1" class="filled-in chk-col-info" {{ $services_technical_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_1" name="services_technical" value="2" class="filled-in chk-col-info" {{ $services_technical_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_1" name="services_technical" value="3" class="filled-in chk-col-info" {{ $services_technical_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_1" name="services_technical" value="4" class="filled-in chk-col-info" {{ $services_technical_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_1" name="services_technical" value="5" class="filled-in chk-col-info" {{ $services_technical_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_1" name="services_technical" value="6" class="filled-in chk-col-info" {{ $services_technical_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_1" name="services_technical" value="7" class="filled-in chk-col-info" {{ $services_technical_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_1" name="services_technical" value="8" class="filled-in chk-col-info" {{ $services_technical_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_1" name="services_technical" value="9" class="filled-in chk-col-info" {{ $services_technical_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_1"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_1" name="services_technical" value="10" class="filled-in chk-col-info" {{ $services_technical_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_1"></label>
                                                                        </td>
                                                                    </tr>
            
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>What is the level of alignment between the inquiry you sent and the proposal submitted by PT BBN?</td>
                                                                        @php
                                                                            $services_level_alignment_value = $customer_satisfaction_dtl->services_level_alignment;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_2" name="services_level_alignment" value="1" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_2" name="services_level_alignment" value="2" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_2" name="services_level_alignment" value="3" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_2" name="services_level_alignment" value="4" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_2" name="services_level_alignment" value="5" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_2" name="services_level_alignment" value="6" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_2" name="services_level_alignment" value="7" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_2" name="services_level_alignment" value="8" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_2" name="services_level_alignment" value="9" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_2"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_2" name="services_level_alignment" value="10" class="filled-in chk-col-info" {{ $services_level_alignment_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_2"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        @php
                                                                            $nilai_average = ((($customer_satisfaction_dtl->services_inquiry ?? '0')+($customer_satisfaction_dtl->services_technical ?? '0')+($customer_satisfaction_dtl->services_level_alignment ?? '0'))/3)*10
                                                                        @endphp
                                                                        <td colspan="2">
                                                                            <h3 class="text-center">Average Survey</h1>
                                                                        </td>
                                                                        <td colspan="11">
                                                                            <input type="text" class="form-control" value="{{ isset($nilai_average) ? $nilai_average . '%' : '-' }}"  disabled  />
                                                                        </td>
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
                                                                        <th rowspan="3">Remarks</th>
                                                                    </tr>
                                                                    <tr class="text-center">
                                                                        <th colspan="4" style="background-color: red; color:white">Unsatisfactory</th>
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
                                                                        <td>What is the level of alignment between the price we offer and the service and quality of materials we supply?</td>
                                                                        @php
                                                                            $commercial_level_alignment_value = $customer_satisfaction_dtl->commercial_level_alignment;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_3" name="commercial_level_alignment" value="1" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_3" name="commercial_level_alignment" value="2" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_3" name="commercial_level_alignment" value="3" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_3" name="commercial_level_alignment" value="4" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_3" name="commercial_level_alignment" value="5" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_3" name="commercial_level_alignment" value="6" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_3" name="commercial_level_alignment" value="7" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_3" name="commercial_level_alignment" value="8" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_3" name="commercial_level_alignment" value="9" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_3"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_3" name="commercial_level_alignment" value="10" class="filled-in chk-col-info" {{ $commercial_level_alignment_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_3"></label>
                                                                        </td>
                                                                        <td rowspan="3">
                                                                            <textarea class="form-control dynamic-height" name="commercial_aspect_remarks" placeholder="Remarks" disabled>{{ $customer_satisfaction_dtl->commercial_aspect_remarks }}</textarea>
                                                                        </td>
                                                                    </tr>
            
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>What is the level of flexibility in the Terms of Payment provided by PT BBN?</td>
                                                                        @php
                                                                            $commercial_flexibility_value = $customer_satisfaction_dtl->commercial_flexibility;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_4" name="commercial_flexibility" value="1" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_4" name="commercial_flexibility" value="2" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_4" name="commercial_flexibility" value="3" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_4" name="commercial_flexibility" value="4" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_4" name="commercial_flexibility" value="5" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_4" name="commercial_flexibility" value="6" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_4" name="commercial_flexibility" value="7" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_4" name="commercial_flexibility" value="8" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_4" name="commercial_flexibility" value="9" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_4"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_4" name="commercial_flexibility" value="10" class="filled-in chk-col-info" {{ $commercial_flexibility_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_4"></label>
                                                                        </td>
                                                                    </tr>
            
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>How is the compliance and completeness of the supporting documents for the Invoice we submitted?</td>
                                                                        @php
                                                                            $commercial_compliance_value = $customer_satisfaction_dtl->commercial_compliance;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_5" name="commercial_compliance" value="1" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_5" name="commercial_compliance" value="2" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_5" name="commercial_compliance" value="3" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_5" name="commercial_compliance" value="4" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_5" name="commercial_compliance" value="5" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_5" name="commercial_compliance" value="6" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_5" name="commercial_compliance" value="7" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_5" name="commercial_compliance" value="8" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_5" name="commercial_compliance" value="9" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_5"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_5" name="commercial_compliance" value="10" class="filled-in chk-col-info" {{ $commercial_compliance_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_5"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        @php
                                                                            $nilai_average = ((($customer_satisfaction_dtl->commercial_level_alignment ?? '0')+($customer_satisfaction_dtl->commercial_flexibility ?? '0')+($customer_satisfaction_dtl->commercial_compliance ?? '0'))/3)*10
                                                                        @endphp
                                                                        <td colspan="2">
                                                                            <h3 class="text-center">Average Survey</h1>
                                                                        </td>
                                                                        <td colspan="11">
                                                                            <input type="text" class="form-control" value="{{ isset($nilai_average) ? $nilai_average . '%' : '-' }}"  disabled  />
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
                                                                        <th rowspan="3">Remarks</th>
                                                                    </tr>
                                                                    <tr class="text-center">
                                                                        <th colspan="4" style="background-color: red; color:white">Unsatisfactory</th>
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
                                                                        <td>What is the average accuracy of Delivery Material in relation to the due date of the Purchase Order?</td>
                                                                        @php
                                                                            $delivery_average_value = $customer_satisfaction_dtl->delivery_average;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_6" name="delivery_average" value="1" class="filled-in chk-col-info" {{ $delivery_average_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_6" name="delivery_average" value="2" class="filled-in chk-col-info" {{ $delivery_average_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_6" name="delivery_average" value="3" class="filled-in chk-col-info" {{ $delivery_average_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_6" name="delivery_average" value="4" class="filled-in chk-col-info" {{ $delivery_average_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_6" name="delivery_average" value="5" class="filled-in chk-col-info" {{ $delivery_average_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_6" name="delivery_average" value="5" class="filled-in chk-col-info" {{ $delivery_average_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_6" name="delivery_average" value="7" class="filled-in chk-col-info" {{ $delivery_average_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_6" name="delivery_average" value="8" class="filled-in chk-col-info" {{ $delivery_average_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_6" name="delivery_average" value="9" class="filled-in chk-col-info" {{ $delivery_average_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_6"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_6" name="delivery_average" value="10" class="filled-in chk-col-info" {{ $delivery_average_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_6"></label>
                                                                        </td>
                                                                        <td rowspan="3">
                                                                            <textarea class="form-control dynamic-height" name="delivery_material_remarks" placeholder="Remarks" disabled>{{ $customer_satisfaction_dtl->delivery_material_remarks }}</textarea>
                                                                        </td>
                                                                    </tr>
            
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>What is the completeness of the documents provided by PT BBN during the material shipment?</td>
                                                                        @php
                                                                            $delivery_completeness_value = $customer_satisfaction_dtl->delivery_completeness;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_7" name="delivery_completeness" value="1" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_7" name="delivery_completeness" value="2" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_7" name="delivery_completeness" value="3" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_7" name="delivery_completeness" value="4" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_7" name="delivery_completeness" value="5" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_7" name="delivery_completeness" value="6" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_7" name="delivery_completeness" value="7" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_7" name="delivery_completeness" value="8" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_7" name="delivery_completeness" value="9" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_7"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_7" name="delivery_completeness" value="10" class="filled-in chk-col-info" {{ $delivery_completeness_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_7"></label>
                                                                        </td>
                                                                    </tr>
            
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>What is the quality, safety, and neatness of the packing materials that PT BBN has been conducting during material shipments?</td>
                                                                        @php
                                                                            $delivery_packing_value = $customer_satisfaction_dtl->delivery_packing;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_8" name="delivery_packing" value="1" class="filled-in chk-col-info" {{ $delivery_packing_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_8" name="delivery_packing" value="2" class="filled-in chk-col-info" {{ $delivery_packing_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_8" name="delivery_packing" value="3" class="filled-in chk-col-info" {{ $delivery_packing_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_8" name="delivery_packing" value="4" class="filled-in chk-col-info" {{ $delivery_packing_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_8" name="delivery_packing" value="5" class="filled-in chk-col-info" {{ $delivery_packing_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_8" name="delivery_packing" value="6" class="filled-in chk-col-info" {{ $delivery_packing_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_8" name="delivery_packing" value="7" class="filled-in chk-col-info" {{ $delivery_packing_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_8" name="delivery_packing" value="8" class="filled-in chk-col-info" {{ $delivery_packing_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_8" name="delivery_packing" value="9" class="filled-in chk-col-info" {{ $delivery_packing_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_8"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_8" name="delivery_packing" value="10" class="filled-in chk-col-info" {{ $delivery_packing_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_8"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        @php
                                                                            $nilai_average = ((($customer_satisfaction_dtl->delivery_average ?? '0')+($customer_satisfaction_dtl->delivery_completeness ?? '0')+($customer_satisfaction_dtl->delivery_packing ?? '0'))/3)*10
                                                                        @endphp
                                                                        <td colspan="2">
                                                                            <h3 class="text-center">Average Survey</h1>
                                                                        </td>
                                                                        <td colspan="11">
                                                                            <input type="text" class="form-control" value="{{ isset($nilai_average) ? $nilai_average . '%' : '-' }}"  disabled  />
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
                                                                        <th rowspan="3">Remarks</th>
                                                                    </tr>
                                                                    <tr class="text-center">
                                                                        <th colspan="4" style="background-color: red; color:white">Unsatisfactory</th>
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
                                                                        <td>How compliant are the Materials sent with the PO specifications?</td>
                                                                        @php
                                                                            $product_compliant_value = $customer_satisfaction_dtl->product_compliant;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_9" name="product_compliant" value="1" class="filled-in chk-col-info" {{ $product_compliant_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_9" name="product_compliant" value="2" class="filled-in chk-col-info" {{ $product_compliant_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_9" name="product_compliant" value="3" class="filled-in chk-col-info" {{ $product_compliant_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_9" name="product_compliant" value="4" class="filled-in chk-col-info" {{ $product_compliant_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_9" name="product_compliant" value="5" class="filled-in chk-col-info" {{ $product_compliant_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_9" name="product_compliant" value="5" class="filled-in chk-col-info" {{ $product_compliant_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_9" name="product_compliant" value="7" class="filled-in chk-col-info" {{ $product_compliant_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_9" name="product_compliant" value="8" class="filled-in chk-col-info" {{ $product_compliant_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_9" name="product_compliant" value="9" class="filled-in chk-col-info" {{ $product_compliant_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_9"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_9" name="product_compliant" value="10" class="filled-in chk-col-info" {{ $product_compliant_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_9"></label>
                                                                        </td>
                                                                        <td rowspan="3">
                                                                            <textarea class="form-control dynamic-height" name="product_quality_remarks" placeholder="Remarks" disabled>{{ $customer_satisfaction_dtl->product_quality_remarks }}</textarea>
                                                                        </td>
                                                                    </tr>
            
                                                                    <tr>
                                                                        <td>2</td>
                                                                        <td>How complete/compliant are the Certificate documents and other supporting documents provided by BBN in relation to the PO requirements?</td>
                                                                        @php
                                                                            $product_certificate_value = $customer_satisfaction_dtl->product_certificate;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_10" name="product_certificate" value="1" class="filled-in chk-col-info" {{ $product_certificate_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_10" name="product_certificate" value="2" class="filled-in chk-col-info" {{ $product_certificate_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_10" name="product_certificate" value="3" class="filled-in chk-col-info" {{ $product_certificate_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_10" name="product_certificate" value="4" class="filled-in chk-col-info" {{ $product_certificate_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_10" name="product_certificate" value="5" class="filled-in chk-col-info" {{ $product_certificate_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_10" name="product_certificate" value="6" class="filled-in chk-col-info" {{ $product_certificate_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_10" name="product_certificate" value="7" class="filled-in chk-col-info" {{ $product_certificate_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_10" name="product_certificate" value="8" class="filled-in chk-col-info" {{ $product_certificate_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_10" name="product_certificate" value="9" class="filled-in chk-col-info" {{ $product_certificate_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_10"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_10" name="product_certificate" value="10" class="filled-in chk-col-info" {{ $product_certificate_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_10"></label>
                                                                        </td>
                                                                    </tr>
            
                                                                    <tr>
                                                                        <td>3</td>
                                                                        <td>Is the response and/or resolution action we have taken regarding complaints of nonconformity, both in terms of documents and materials, satisfactory?</td>
                                                                        @php
                                                                            $product_response_value = $customer_satisfaction_dtl->product_response;
                                                                        @endphp
                                                                        <td>
                                                                            <input type="checkbox" id="category1_11" name="product_response" value="1" class="filled-in chk-col-info" {{ $product_response_value >= 1 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category1_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category2_11" name="product_response" value="2" class="filled-in chk-col-info" {{ $product_response_value >= 2 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category2_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category3_11" name="product_response" value="3" class="filled-in chk-col-info" {{ $product_response_value >= 3 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category3_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category4_11" name="product_response" value="4" class="filled-in chk-col-info" {{ $product_response_value >= 4 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category4_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category5_11" name="product_response" value="5" class="filled-in chk-col-info" {{ $product_response_value >= 5 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category5_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category6_11" name="product_response" value="6" class="filled-in chk-col-info" {{ $product_response_value >= 6 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category6_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category7_11" name="product_response" value="7" class="filled-in chk-col-info" {{ $product_response_value >= 7 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category7_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category8_11" name="product_response" value="8" class="filled-in chk-col-info" {{ $product_response_value >= 8 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category8_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category9_11" name="product_response" value="9" class="filled-in chk-col-info" {{ $product_response_value >= 9 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category9_11"></label>
                                                                        </td>
                                                                        <td>
                                                                            <input type="checkbox" id="category10_11" name="product_response" value="10" class="filled-in chk-col-info" {{ $product_response_value >= 10 ? 'checked disabled' : '' }} disabled/>
                                                                            <label for="category10_11"></label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        @php
                                                                            $nilai_average = ((($customer_satisfaction_dtl->product_compliant ?? '0')+($customer_satisfaction_dtl->product_certificate ?? '0')+($customer_satisfaction_dtl->product_response ?? '0'))/3)*10
                                                                        @endphp
                                                                        <td colspan="2">
                                                                            <h3 class="text-center">Average Survey</h1>
                                                                        </td>
                                                                        <td colspan="11">
                                                                            <input type="text" class="form-control" value="{{ isset($nilai_average) ? $nilai_average . '%' : '-' }}"  disabled  />
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
                                </div>
                            </div>
                        </div>
                    </div>
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
