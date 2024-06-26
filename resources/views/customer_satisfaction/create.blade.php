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
                    <form id="form-id" action="{{ route('customer-satisfaction.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Code<span style="color: red">*</span></label>
                                    <input type="text" class="form-control ps-15" value="{{ $data_customer->cust_code }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Name<span style="color: red">*</span></label>
                                    <input type="text" class="form-control ps-15" value="{{ $data_customer->cust_name }}" disabled>
                                </div>    
                            </div>
                            <div class="col-4">
                                @php
                                    $lookup = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $data_customer->company_sector)->first();
                                    $pk_status = \App\Models\LookupModel::where('lookup_config', 'sls_pk_status')->where('lookup_code', $perintah_kerja->status)->first();
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Company Sector<span style="color: red">*</span></label>
                                    <select id="select-companySector" class="form-select select2" name="company_sector" aria-label="Default select example" disabled>
                                        <option value="{{ $data_customer->company_sector }}" selected>{{ $lookup->lookup_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">PK No</label>
                                    <input type="text" class="form-control ps-15" value="{{ $perintah_kerja->pk_no }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">PK Date</label>
                                    <input type="text" class="form-control ps-15" value="{{ $perintah_kerja->pk_date }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">PK Status</label>
                                    <input type="text" class="form-control ps-15" value="{{ $pk_status->lookup_name }}" disabled>
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
                                    <input type="text" class="form-control ps-15" value="{{ $data_pic_sales->user_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">PIC Customer BBN</label>
                                    <input type="text" class="form-control ps-15" value="{{ $data_pic_customer->pic_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">What are your main requirements to improve our service ?</label>
                                    <textarea rows="5" class="form-control" name="address" placeholder="Improvement for our services"></textarea>
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
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2">Description Survey</th>
                                                            <th colspan="10">Category</th>
                                                            <th rowspan="2">Remarks</th>
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
                                                            <td>Telephone Reception</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                            <td rowspan="10">
                                                                <textarea class="form-control dynamic-height" name="remarks" placeholder="Remarks"></textarea>
                                                                {{-- <textarea rows="10" class="form-control" name="remarks" placeholder="Remarks"></textarea> --}}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>Time For Quotation</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>Prices</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>4</td>
                                                            <td>Delivery Document</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>5</td>
                                                            <td>Invoice Document</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>6</td>
                                                            <td>Visit Frequency</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>7</td>
                                                            <td>Information About Product to be delivered</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
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
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2">Description Survey</th>
                                                            <th colspan="10">Category</th>
                                                            <th rowspan="2">Remarks</th>
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
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                            <td rowspan="4">
                                                                <textarea class="form-control dynamic-height" name="remarks" placeholder="Remarks"></textarea>
                                                                {{-- <textarea rows="10" class="form-control" name="remarks" placeholder="Remarks"></textarea> --}}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>Technical Advice</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>Time for answering to technical questions</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>4</td>
                                                            <td>Visit Frequency</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
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
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2">Description Survey</th>
                                                            <th colspan="10">Category</th>
                                                            <th rowspan="2">Remarks</th>
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
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                            <td rowspan="4">
                                                                <textarea class="form-control dynamic-height" name="remarks" placeholder="Remarks"></textarea>
                                                                {{-- <textarea rows="10" class="form-control" name="remarks" placeholder="Remarks"></textarea> --}}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>Emergency delivery capacity</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>Delivery reliability</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>4</td>
                                                            <td>Visit Frequency</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
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
                                                            <th rowspan="2">No</th>
                                                            <th rowspan="2">Description Survey</th>
                                                            <th colspan="10">Category</th>
                                                            <th rowspan="2">Remarks</th>
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
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                            <td rowspan="5">
                                                                <textarea class="form-control dynamic-height" name="remarks" placeholder="Remarks"></textarea>
                                                                {{-- <textarea rows="10" class="form-control" name="remarks" placeholder="Remarks"></textarea> --}}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2</td>
                                                            <td>Non confirmity management</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3</td>
                                                            <td>Time for answering to quality questions</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>4</td>
                                                            <td>Management of your inspection report</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>5</td>
                                                            <td>Time for answering to questions</td>
                                                            <td>
                                                                <input type="checkbox" id="category1" class="filled-in chk-col-info" />
                                                                <label for="category1"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category2" class="filled-in chk-col-info" />
                                                                <label for="category2"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category3" class="filled-in chk-col-info" />
                                                                <label for="category3"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category4" class="filled-in chk-col-info" />
                                                                <label for="category4"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category5" class="filled-in chk-col-info" />
                                                                <label for="category5"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category6" class="filled-in chk-col-info" />
                                                                <label for="category6"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category7" class="filled-in chk-col-info" />
                                                                <label for="category7"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category8" class="filled-in chk-col-info" />
                                                                <label for="category8"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category9" class="filled-in chk-col-info" />
                                                                <label for="category9"></label>
                                                            </td>
                                                            <td>
                                                                <input type="checkbox" id="category10" class="filled-in chk-col-info" />
                                                                <label for="category10"></label>
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
@endsection
