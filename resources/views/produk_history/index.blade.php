@extends('layouts.app')

@section('title', 'Data Users')

@section('css-library')
    {{-- Tempat Ngoding Meletakkan css library --}}
@endsection

@section('css-custom')
    {{-- Tempat Ngoding Meletakkan css custom --}}
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
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Product Order History') }}</li>
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
                <div class="box-header">						
                    {{-- <h4 class="box-title">Complex headers (rowspan and colspan)</h4> --}}
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <h4 class="box-title">{{ __('List Data') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="complex_header" class="table table-striped table-bordered display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>SQ No</th>
                                    <th>INQ No</th>
                                    <th>Customer</th>
                                    <th>SQ Date</th>
                                    <th>Offer Validity</th>
                                    <th>Total Offer</th>
                                    <th>SQ Type</th>
                                    <th>Project Name</th>
                                    <th>SQ PIC Customer</th>
                                    <th>Status</th>
                                    <th>Sales By</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales_quotation as $sq)
                                    @php
                                        $lookup_status = \App\Models\LookupModel::where('lookup_config', 'sls_quotation_status')->where('lookup_code', $sq->status)->first();
                                        $lookup_sqType = \App\Models\LookupModel::where('lookup_config', 'sq_type')->where('lookup_code', $sq->sq_type)->first();
                                        $lookup_offerVal = \App\Models\LookupModel::where('lookup_config', 'offer_validity')->where('lookup_code', $sq->oﬀer_validity)->first();
                                        $sales_inquiry = \App\Models\QuotationItemModel::select('sls_inquiry.*')
                                                            ->join('sls_quotation', 'sls_quotation_items_int.sq_id', '=', 'sls_quotation.sq_id')
                                                            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                                                            ->where('sls_inquiry.inq_id', $sq->inq_id)
                                                            ->first();
                                        $sales_customer = \App\Models\SalesQuotationModel::select('sls_customer.*', 'sls_customer_pic.*', 'erp_user.*')
                                                        ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                                                        ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
                                                        ->leftJoin('sls_customer_pic', 'sls_customer.cust_id', '=', 'sls_customer_pic.cust_id')
                                                        ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
                                                        ->where('sls_quotation.sq_no', $sq->sq_no)
                                                        ->first();
                                        $status_text = '';
                                        $status_color = '';
                            
                                        switch ($sq->status) {
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
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sq->sq_no }}</td>
                                        <td>{{ $sales_inquiry->inq_no }}</td>
                                        <td>{{ Auth::user()->company_name }}</td>
                                        <td>{{ $sq->created_date }}</td>
                                        <td>{{ $lookup_offerVal->lookup_name }}</td>
                                        <td>{{ rupiah($sq->offer_value) }}</td>
                                        <td>{{ $lookup_sqType->lookup_name ?? '' }}</td>
                                        <td>{{ $sales_inquiry->project_name }}</td>
                                        <td>{{ $sales_customer->pic_name }}</td>
                                        <td><span class="btn btn-sm btn-outline {{ $status_color }}">{{ $status_text }}</span></td>
                                        <td>{{ $sq->created_by }}</td>
                                        <td>
                                            <div class="btn-group mb-5">
                                                <a class="btn btn-sm btn-info" type="button" href='{{ route('product-order-history.show', ['id' => Crypt::encrypt($sq->id)]) }}'>Detail</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>                            
                        </table>
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
@endsection
