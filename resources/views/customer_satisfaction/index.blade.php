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
            <h3 class="page-title">{{ __('Customer Satisfaction') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('Customer Satisfaction') }}</li>
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
                    <form id="searchForm" action="{{ url('customer-satisfaction') }}" method="GET">
                        <div class="row">
                            @php
                                $data_status = \App\Models\LookupModel::where('lookup_config', 'sls_quotation_status')->get();
                            @endphp
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
                                    <label class="form-label">Customer</label>
                                    <input type="text" class="form-control ps-15" name="customer" placeholder="Customer" value="{{ request('customer') }}">
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
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Status</label>
                                    <select id="divisi-customer" class="form-select select2" name="status" aria-label="Default select example">
                                        <option value="" disabled>--Choose Option --</option>
                                        @foreach ($data_status as $ds)
                                            <option value="{{ $ds->lookup_code }}" {{ old('status', request('status')) == $ds->lookup_code ? 'selected' : '' }}>{{ $ds->lookup_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            {{-- <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Services</label>
                                    <div class="input-group my-colorpicker2">
                                        <input type="text" class="form-control" name="services" placeholder="Services" value="{{ request('services') }}">
                  
                                        <div class="input-group-addon">
                                          %
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Commercial</label>
                                    <div class="input-group my-colorpicker2">
                                        <input type="text" class="form-control" name="commercial" placeholder="Commercial" value="{{ request('commercial') }}">
                  
                                        <div class="input-group-addon">
                                          %
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Delivery Material</label>
                                    <div class="input-group my-colorpicker2">
                                        <input type="text" class="form-control" name="delivery_material" placeholder="Delivery Material" value="{{ request('delivery_material') }}">
                  
                                        <div class="input-group-addon">
                                          %
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Product Quality</label>
                                    <div class="input-group my-colorpicker2">
                                        <input type="text" class="form-control" name="product_quality" placeholder="Product Quality" value="{{ request('product_quality') }}">
                  
                                        <div class="input-group-addon">
                                          %
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Average Satisfaction</label>
                                    <div class="input-group my-colorpicker2">
                                        <input type="text" class="form-control" name="average_satisfaction" placeholder="Average Satisfaction" value="{{ request('average_satisfaction') }}">
                  
                                        <div class="input-group-addon">
                                          %
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
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
                                    <th style="width:30%;">Project Name</th>
                                    <th>Status</th>
                                    <th>Services</th>
                                    <th>Commercial</th>
                                    <th>Delivery Material</th>
                                    <th>Product Quality</th>    
                                    <th>Average Satisfaction</th> 
                                    <th>Survey</th>
                                    <th>Survey Status</th>
                                    <th>SQ PIC Customer</th>
                                    <th>Sales By</th>
                                    <th>Satisfaction Date</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales_quotation as $sq)
                                    @php
                                        $lookup_status = \App\Models\LookupModel::where('lookup_config', 'sls_quotation_status')->where('lookup_code', $sq->status)->first();
                                        $cp_satisfaction = $customer_satisfaction->where('sq_id', $sq->sq_id)->first();
                                        $cp_satisfaction_dtl = $customer_satisfaction_dtl->where('customer_satisfaction_id', $cp_satisfaction->id ?? '')->first();
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
                                        <td>{{ $sales_inquiry->project_name }}</td>
                                        <td><span class="btn btn-sm btn-outline {{ $status_color }}">{{ $status_text }}</span></td>
                                        <td class="text-center">{{ isset($cp_satisfaction_dtl->services) ? $cp_satisfaction_dtl->services . '%' : '-' }}</td>
                                        <td class="text-center">{{ isset($cp_satisfaction_dtl->commercial_aspect) ? $cp_satisfaction_dtl->commercial_aspect . '%' : '-' }}</td>
                                        <td class="text-center">{{ isset($cp_satisfaction_dtl->delivery_material) ? $cp_satisfaction_dtl->delivery_material . '%' : '-' }}</td>
                                        <td class="text-center">{{ isset($cp_satisfaction_dtl->product_quality) ? $cp_satisfaction_dtl->product_quality . '%' : '-' }}</td>
                                        @php
                                            $nilai_average = (($cp_satisfaction_dtl->services ?? '0') + ($cp_satisfaction_dtl->commercial_aspect ?? '0') + ($cp_satisfaction_dtl->delivery_material ?? '0') + ($cp_satisfaction_dtl->product_quality ?? '0')) / 4;
                                        @endphp
                                        <td class="text-center">{{ isset($nilai_average) ? $nilai_average . '%' : '-' }}</td>
                                        <td>
                                            @if (isset($cp_satisfaction->status) == null)
                                                @if ($sq->status == 8)
                                                    <div class="btn-group">
                                                        <a href='{{ route('customer-satisfaction.create', ['id' => Crypt::encrypt($sq->sq_no)]) }}' type="button" class="btn btn-rounded btn-sm bg-gradient-secondary w-100">
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
                                            @if (isset($cp_satisfaction->status) == null)
                                                <div class="w-100"><span class="badge badge-danger">No Survey Yet</span></div>
                                            @else
                                                <div class="w-100"><span class="badge badge-success">Survey Finished</span></div>
                                            @endif
                                        </td>
                                        <td>{{ $sales_customer->pic_name ?? '-' }}</td>
                                        <td>{{ ucwords(strtolower($sales_customer->user_name ?? '-')) }}</td>
                                        <td>{{ $cp_satisfaction->created_at ?? '-' }}</td>
                                        <td>
                                            @if (isset($cp_satisfaction->status) != null)
                                                <div class="btn-group mb-5">
                                                    <a class="btn btn-sm btn-info" type="button" href='{{ route('customer-satisfaction.show', ['id' => Crypt::encrypt($sq->sq_no)]) }}'>Detail</a>
                                                    <a class="btn btn-sm btn-secondary" type="button" href='{{ route('customer-satisfaction.print', ['id' => Crypt::encrypt($sq->sq_no)]) }}' target="__blank">Print</a>
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
