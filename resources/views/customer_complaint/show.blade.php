@extends('layouts.app')

@section('title', 'Data Users')

@section('css-library')
    {{-- Tempat Ngoding Meletakkan css library --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
@endsection

@section('css-custom')
    {{-- Tempat Ngoding Meletakkan css custom --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }
        .popup h2 {
            margin-top: 0;
        }
        .popup ul {
            list-style-type: none;
            padding: 0;
        }
        .popup li {
            margin-bottom: 10px;
        }
        .popup button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .popup button:hover {
            background-color: #0056b3;
        }
    </style>
    
@endsection

@section('content')
<div class="content-header">
    <div class="d-flex align-items-center">
        <div class="me-auto">
            <h3 class="page-title">{{ __('Customer Complaint') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Customer Complaint') }}</li>
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
                            <h4 class="box-title">{{ __('Detail Data') }}</h4>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end mb-0">
                            <div class="btn-group">
                                <a href="{{ route('customer-complaint') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
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
                    <div class="row">
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
                                <label class="form-label">SQ No</label>
                                <input type="text" class="form-control ps-15" value="{{ $sales_quotation->sq_no }}" disabled>
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
                                                    <td valign="top">{{ $sales_quotation->est_ship_weight }}</td>
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
                                <input type="text" class="form-control ps-15" name="personal_name" value="{{ Auth::user()->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Tel/Fax No.</label>
                                <input type="text" class="form-control ps-15" name="telp_fax" value="{{ Auth::user()->phone }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Mobile No</label>
                                <input type="text" class="form-control ps-15" name="phone" value="{{ Auth::user()->phone }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Email Customer</label>
                                <input type="text" class="form-control ps-15" name="email" value="{{ Auth::user()->email }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <select class="form-control" name="title" aria-label="Default select example" disabled>
                                    <option value="{{ Auth::user()->department }}">{{ Auth::user()->department ?? '' }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Purchase Order No & Date</label>
                                <input type="text" name="po_dan_date" class="form-control ps-15" value="{{ $sales_quotation->sq_no }} & {{ $sales_quotation->created_date }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <fieldset class="scheduler-border" style="padding: 20px;">
                                {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                <legend class="scheduler-border" style="color: green;">Category</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="row">
                                                @foreach ($customer_complaint_category as $cpc)
                                                    <div class="col-md-6">
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_{{ $loop->index + 1 }}_{{ $cpc->id }}" name="category[]" checked disabled>
                                                            <label for="checkbox_{{ $loop->index + 1 }}_{{ $cpc->id }}" class="me-30">{{ $cpc->category_name }}</label>
                                                            @if ($cpc->category_name == 'others')
                                                                <div class="type-form">
                                                                    <div id="type-form-{{ $loop->index + 1 }}">
                                                                        <input type="text" class="form-control ps-15" name="category_other" placeholder="Input Other Category" value="{{ old('category_other') }}" {{ $cpc->checked ? '' : 'disabled' }}>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                            </fieldset>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Description of Non- Conformance (The Issues)</label>
                                <textarea rows="5" class="form-control" name="description" disabled>{{ $customer_complaint->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <fieldset class="scheduler-border" style="padding: 20px;">
                                {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                <legend class="scheduler-border" style="color: green;">File Lampiran</legend>
                                <div class="row">
                                    <div class="col-md-12">
                                        @foreach ($customer_complaint_file as $cpf)
                                        <p>{{ $cpf->file_lampiran }}</p>
                                        @endforeach
                                    </div>
                                </div>                                    
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <h4 class="box-title">{{ __('Complaints Resolved By') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Complain Received by</label>
                                <input type="text" class="form-control ps-15" name="personal_name" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Data Received</label>
                                <input type="text" class="form-control ps-15" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Complaints Resolved By</label>
                                <input type="text" class="form-control ps-15" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control ps-15" disabled>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Action Taken</label>
                                <textarea rows="5" class="form-control" disabled></textarea>
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
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js" integrity="sha384-BVX3EoFmCW85CPbT2U5Fp1a3Rp4zMGH1+Oz5xCv4eDf5Y8Bc4pW4fG1ksw5LUIMh" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

@endsection

@section('js-custom')
    {{-- Tempat Ngoding Meletakkan js custom --}}
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
        // Fungsi untuk menampilkan atau menyembunyikan form berdasarkan status checkbox
        function toggleFormVisibility() {
            const checkbox = document.getElementById('checkbox_678');
            const typeForm = document.getElementById('type-form-1');
    
            if (checkbox.checked) {
                typeForm.style.display = 'block'; // Jika checkbox dicentang, tampilkan form
            } else {
                typeForm.style.display = 'none'; // Jika checkbox tidak dicentang, sembunyikan form
            }
        }
    
        // Tambahkan event listener untuk mendeteksi klik pada checkbox
        document.getElementById('checkbox_678').addEventListener('change', toggleFormVisibility);
    
        // Panggil fungsi toggleFormVisibility() sekali pada awal untuk sinkronisasi tampilan
        toggleFormVisibility();
    </script>
@endsection
