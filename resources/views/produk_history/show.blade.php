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
            <h3 class="page-title">{{ __('Product Order History') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Product Order History</li>
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
        <div class="col-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <h4 class="box-title">{{ __('Detail Data Quotation') }}</h4>
                        </div>
                        {{-- <div class="col-lg-6 d-flex justify-content-end mb-0">
                            <div class="btn-group">
                                <a href="{{ route('product-order-history') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div> --}}
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
                    @endphp
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">SQ No</label>
                                <input type="text" class="form-control ps-15" value="{{ old('sq_no', $sales_quotation->sq_no) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control ps-15" value="[ {{ $lookup_status->lookup_name }} ]" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">SQ Date</label>
                                <input type="text" class="form-control ps-15" value="{{ old('created_date', $sales_quotation->created_date) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">SQ Type</label>
                                <input type="text" class="form-control ps-15" value="[ {{ $lookup_sqType->lookup_name ?? '' }} ]" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">SQ Date</label>
                                <input type="text" class="form-control ps-15" value="{{ old('pic_name', $quotation_customer->pic_name) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">USD to IDR Conversion</label>
                                <input type="text" class="form-control ps-15" value="{{ rupiah($sales_quotation->usd_idr_conversion) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Offer Mode</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_sqOffMode->lookup_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Est`d Shipping CW</label>
                                <input type="text" class="form-control ps-15" value="{{ old('est_ship_weight', $sales_quotation->est_ship_weight) }}.00" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Payment Terms</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_sqPayment->lookup_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Payment Mode</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_sqPayMode->lookup_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Delivery Time</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_sqDelTime->lookup_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Delivery Mode</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_sqDelMode->lookup_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Packing</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_sqPacking->lookup_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Certification</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_sqSertif->lookup_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Offer Validity</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_offerVal->lookup_name ?? '' }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Offer Validity</label>
                                <textarea rows="5" class="form-control" name="address" disabled>{{ $sales_quotation->remarks }} </textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <h4 class="box-title">{{ __('Detail Data Inquiry') }}</h4>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end mb-0">
                            <div class="btn-group">
                                <a href="{{ route('product-order-history') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    @php
                        $lookup_stageInquiry = \App\Models\LookupModel::where('lookup_config', 'sls_stage_inquiry')->where('lookup_code', $sales_inquiry->stage_inquiry)->first();
                        $lookup_statusInquiry = \App\Models\LookupModel::where('lookup_config', 'sls_inquiry_status')->where('lookup_code', $sales_inquiry->status)->first();
                        $lookup_companySector = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $sales_customer->company_sector)->first();
                        $lookup_customerType = \App\Models\LookupModel::where('lookup_config', 'sls_customer_type')->where('lookup_code', $sales_customer->cust_type)->first();
                    @endphp
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Customer Inquiry No</label>
                                <input type="text" class="form-control ps-15" value="{{ old('inq_no', $sales_inquiry->inq_no) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Stage of Inquiry</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_stageInquiry->lookup_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Inquiry Date</label>
                                <input type="text" class="form-control ps-15" value="{{ old('created_date', $sales_inquiry->created_date) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control ps-15" value="[ {{ $lookup_statusInquiry->lookup_name }} ]" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">PIC Acknowledge</label>
                                <input type="text" class="form-control ps-15" value="{{ old('created_by', $sales_inquiry->created_by) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Email Datetime</label>
                                <input type="text" class="form-control ps-15" value="{{ old('email_date', $sales_inquiry->email_date) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Closing Date</label>
                                <input type="text" class="form-control ps-15" value="{{ old('closing_date', $sales_inquiry->closing_date) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Subject</label>
                                <input type="text" class="form-control ps-15" value="{{ old('subject', $sales_inquiry->subject) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">PIC Sales</label>
                                <input type="text" class="form-control ps-15" value="{{ old('pic_sales', $sales_customer->user_name) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Remarks</label>
                                <input type="text" class="form-control ps-15" value="{{ old('remarks', $sales_inquiry->remarks) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Customer Name</label>
                                <input type="text" class="form-control ps-15" value="{{ old('cust_name', $sales_customer->cust_name) }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Customer Type</label>
                                <input type="text" class="form-control ps-15" value="{{ $lookup_customerType->lookup_name }}" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">PIC Customer</label>
                                <input type="text" class="form-control ps-15" value="{{ old('pic_name', $quotation_customer->pic_name) }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12" style="margin-bottom: 10px;">
            <fieldset class="scheduler-border">
                <label class="form-label"><b>PRODUCT ORDER HISTORY</b></label>
                <div class="form-group row">
                    <label class="col-form-label col-md-2">Total Offer</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" value="{{ rupiah($sales_quotation->offer_value) }}" disabled>
                    </div>
                    <div class="table-responsive mt-3">
                        <table id="complex_header" class="table table-striped table-bordered display" style="width:100%">
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
</section>
@endsection

@section('js-library')
    {{-- Tempat Ngoding Meletakkan js library --}}

@endsection

@section('js-custom')
    {{-- Tempat Ngoding Meletakkan js custom --}}
@endsection
