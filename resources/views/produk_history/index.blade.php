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
                                    <th>Total Offer</th>
                                    <th>SQ Type</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th width="10%"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales_quotation as $sq)
                                    @php
                                        $lookup_status = \App\Models\LookupModel::where('lookup_config', 'sls_quotation_status')->where('lookup_code', $sq->status)->first();
                                        $lookup_validity = \App\Models\LookupModel::where('lookup_config', 'offer_validity')->where('lookup_code', 1)->first();
                                        $lookup_sqType = \App\Models\LookupModel::where('lookup_config', 'sq_type')->where('lookup_code', $sq->sq_type)->first();
                                        $sales_inquiry = \App\Models\QuotationItemModel::select('sls_inquiry.*')
                                            ->join('sls_quotation', 'sls_quotation_items_int.sq_id', '=', 'sls_quotation.sq_id')
                                            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                                            ->where('sls_inquiry.inq_id', $sq->inq_id) 
                                            ->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $sq->sq_no }}</td>
                                        <td>{{ $sales_inquiry->inq_no }}</td>
                                        <td>{{ Auth::user()->company_name }}</td>
                                        <td>{{ $sq->created_date }}</td>
                                        <td>{{ $sq->offer_value }}</td>
                                        <td>{{ $lookup_sqType->lookup_name ?? '' }}</td>
                                        <td>{{ $lookup_status->lookup_name }}</td>
                                        <td>{{ $sq->created_by }}</td>
                                        <td>
                                            <a href='#'><i class='fa fa-eye ms-text-primary'></i></a>
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
