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
                                    <th>Status</th> 
                                    <th>Survey</th>
                                    <th>Survey Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales_quotation as $sq)
                                    @php
                                        $lookup_status = \App\Models\LookupModel::where('lookup_config', 'sls_quotation_status')->where('lookup_code', $sq->status)->first();
                                        $cp_complaint = $customer_complaint->where('sq_id', $sq->sq_id)->first();
                                        $sales_inquiry = \App\Models\QuotationItemModel::select('sls_inquiry.*')
                                                            ->join('sls_quotation', 'sls_quotation_items_int.sq_id', '=', 'sls_quotation.sq_id')
                                                            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                                                            ->where('sls_inquiry.inq_id', $sq->inq_id)
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
                                        <td><span class="btn btn-sm btn-outline {{ $status_color }}">{{ $status_text }}</span></td>
                                        <td>
                                            @if (isset($cp_complaint->status) == null)
                                                @if ($sq->status == 8)
                                                    <div class="btn-group">
                                                        <a href='{{ route('customer-complaint.create', ['id' => Crypt::encrypt($sq->sq_no)]) }}' type="button" class="btn btn-rounded btn-sm bg-gradient-secondary w-100">
                                                            Add Survey
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="btn-group">
                                                        <a type="button" class="btn btn-rounded btn-sm btn-secondary w-100">
                                                            Add Survey
                                                        </a>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($cp_complaint->status) == null)
                                                <div class="w-100"><span class="badge badge-danger">No Survey Yet</span></div>
                                            @else
                                                <div class="w-100"><span class="badge badge-success">Survey Finished</span></div>
                                            @endif
                                        </td>
                                        <td>
                                            @if (isset($cp_complaint->status) != null)
                                                <div class="btn-group mb-5">
                                                    <button class="waves-effect waves-light btn btn-sm btn-info dropdown-toggle" data-bs-toggle="dropdown"></button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href='{{ route('customer-complaint.show', ['id' => Crypt::encrypt($sq->sq_no)]) }}'>Detail</a>
                                                        <a class="dropdown-item" href='{{ route('customer-complaint.print', ['id' => Crypt::encrypt($sq->sq_no)]) }}'>Print</a>
                                                    </div>
                                                </div>
                                            @endif
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
