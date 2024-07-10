@extends('layouts.app')

@section('title', 'Customer Complaint')

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
            <h3 class="page-title">{{ __('Customer Complaint') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Customer Complaint') }}</li>
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
                        <div class="col-lg-6 mt-2">
                            <h4 class="box-title">{{ __('List Data') }}</h4>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end mb-0">
                            @if(Helpers::hasPrivilege('complaintc'))
                                <div class="btn-group">
                                    <a href="{{ route('customer-complaint.create') }}" type="button" class="btn bg-gradient-secondary">
                                        <i class="fa fa-plus"> Add New</i>
                                    </a>
                                </div>
                                <div class="btn-group">&nbsp;</div>
                            @endif
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
                                    <th>Status</th> 
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customer_complaint as $cp)
                                    @php
                                        $sales_quotation = App\Models\SalesQuotationModel::select('sls_quotation.*')
                                            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                                            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
                                            ->where('sls_quotation.sq_id', $cp->sq_id)
                                            ->where('sls_quotation.status', 8)
                                            ->where('sls_customer.cust_name', Auth::user()->company_name)
                                            ->orderBy('sls_quotation.created_date', 'desc')
                                            ->first();
                                        $sales_inquiry = App\Models\SalesQuotationModel::select('sls_inquiry.*')
                                            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                                            ->where('sls_inquiry.inq_id', $sales_quotation->inq_id)
                                            ->first();
                                        $sales_customer = App\Models\SalesQuotationModel::select('sls_customer.*', 'sls_customer_pic.*', 'erp_user.*')
                                            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                                            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
                                            ->leftJoin('sls_customer_pic', 'sls_customer.cust_id', '=', 'sls_customer_pic.cust_id')
                                            ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
                                            ->where('sls_quotation.sq_no', $sales_quotation->sq_no)
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sales_quotation->sq_no }}</td>
                                        <td>{{ $sales_inquiry->inq_no }}</td>
                                        <td>{{ $sales_customer->cust_name }}</td>
                                        <td>{{ $sales_quotation->created_date }}</td>
                                        <td>
                                            @if (isset($cp->status) == 1)
                                                <div class="w-100"><span class="badge badge-success">Survey Finished</span></div>
                                            @else
                                                <div class="w-100"><span class="badge badge-danger">No Survey Yet</span></div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group mb-5">
                                                <button type="button" class="waves-effect waves-light btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown"></button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href='{{ route('customer-complaint.detail', ['id' => Crypt::encrypt($cp->id)]) }}'>Detail</a>
                                                    <a class="dropdown-item" href='{{ route('customer-complaint.print', ['id' => Crypt::encrypt($cp->sq_no)]) }}'>Print</a>
                                                </div>
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
