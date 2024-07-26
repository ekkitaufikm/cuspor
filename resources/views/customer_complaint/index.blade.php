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
        <div class="col-12">
            <div class="box">
                <div class="box-header">						
                    {{-- <h4 class="box-title">Complex headers (rowspan and colspan)</h4> --}}
                    <div class="row">
                        <div class="col-lg-12 mt-2">
                            <h4 class="box-title">{{ __('Search Parameter') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <form id="searchForm" action="{{ url('customer-complaint') }}" method="GET">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">SQ No</label>
                                    <input type="text" class="form-control ps-15" name="sq_no" placeholder="SQ No" value="{{ request('sq_no') }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">INQ No</label>
                                    <input type="text" class="form-control ps-15" name="inq_no" placeholder="INQ No" value="{{ request('inq_no') }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">SQ Date</label>
                                    <input type="date" class="form-control ps-15" name="sq_date" placeholder="SQ Date" value="{{ request('sq_date') }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Project Name</label>
                                    <input type="text" class="form-control ps-15" name="project_name" placeholder="Project Name" value="{{ request('project_name') }}">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary" onclick="submitForm()">
                                        Search
                                    </button>
                                    <button type="button" class="btn btn-warning me-1" onclick="resetForm()">
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
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
                                    <th>Complaint No</th>
                                    <th>SQ No</th>
                                    <th>INQ No</th>
                                    <th>Customer</th>
                                    <th>SQ Date</th>
                                    <th>Project Name</th>
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
                                        <td>{{ $cp->complaint_no }}</td>
                                        <td>{{ $sales_quotation->sq_no }}</td>
                                        <td>{{ $sales_inquiry->inq_no }}</td>
                                        <td>{{ $sales_customer->cust_name }}</td>
                                        <td>{{ $sales_quotation->created_date }}</td>
                                        <td>{{ $sales_inquiry->project_name }}</td>
                                        <td>
                                            @if (isset($cp->status) == 1)
                                                <div class="w-100"><span class="badge badge-success">Survey Finished</span></div>
                                            @else
                                                <div class="w-100"><span class="badge badge-danger">No Survey Yet</span></div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group mb-5">
                                                <a class="btn btn-sm btn-info" type="button" href='{{ route('customer-complaint.detail', ['id' => Crypt::encrypt($cp->id)]) }}'>Detail</a>
                                                <a class="btn btn-sm btn-secondary" type="button" href='{{ route('customer-complaint.print', ['id' => Crypt::encrypt($cp->id)]) }}' target="__blank">Print</a>
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
    <script>
        function resetForm() {
            // Dapatkan referensi ke form berdasarkan ID
            var form = document.getElementById('searchForm');
            
            // Reset form
            form.reset();
        }
        
        function submitForm() {
            // Dapatkan referensi ke form berdasarkan ID
            var form = document.getElementById('searchForm');
            
            // Submit form
            form.submit();
        }
    </script>
@endsection
