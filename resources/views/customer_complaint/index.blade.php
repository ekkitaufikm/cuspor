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
                                    <th>Customer Name</th>
                                    <th>PK No</th>
                                    <th>PK Date</th>
                                    <th>PK Status</th>
                                    <th>Commercial Aspect</th>
                                    <th>Technical Aspect</th>
                                    <th>Logistics</th>
                                    <th>Quality</th>   
                                    <th>Survey</th>
                                    <th>Survey Status</th>
                                    <th width="10%"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perintah_kerja as $pk)
                                    @php
                                        $lookup = \App\Models\LookupModel::where('lookup_config', 'sls_pk_status')->where('lookup_code', $pk->status)->first();
                                        $cp_satisfaction = \App\Models\CustomerSatisfactionModel::where('pk_id', $pk->id)->first();
                                        $cp_satisfaction_dtl = \App\Models\CustomerSatisfactionDetailModel::where('customer_satisfaction_id', isset($cp_satisfaction->id))->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pk->cust_name }}</td>
                                        <td>{{ $pk->pk_no }}</td>
                                        <td>{{ $pk->pk_date }}</td>
                                        <td>{{ $lookup->lookup_name }}</td>
                                        <td>{{ $cp_satisfaction_dtl->commercial_aspect ?? '-' }}</td>
                                        <td>{{ $cp_satisfaction_dtl->technical_aspect ?? '-' }}</td>
                                        <td>{{ $cp_satisfaction_dtl->logistics ?? '-' }}</td>
                                        <td>{{ $cp_satisfaction_dtl->quality ?? '-' }}</td>
                                        <td>
                                            @if ($pk->status == 6)
                                                <div class="btn-group">
                                                    <a href='{{ route('customer-complaint.create', ['id' => Crypt::encrypt($pk->pk_no)]) }}' type="button" class="btn btn-rounded btn-sm bg-gradient-secondary w-100">
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
                                        </td>
                                        <td>
                                            @if (isset($cp_satisfaction->status) == null)
                                                <div class="w-100"><span class="badge badge-danger">No Survey Yet</span></div>
                                            @else
                                                <div class="w-100"><span class="badge badge-success">Survey Finished</span></div>
                                            @endif
                                        </td>
                                        <td>
                                            <a href='{{ route('customer-complaint.show', ['id' => Crypt::encrypt($pk->pk_no)]) }}'><i class='fa fa-eye ms-text-primary'></i></a>
                                            <a href='{{ route('customer-complaint.print', ['id' => Crypt::encrypt($pk->pk_no)]) }}'><i class='fa fa-print ms-text-primary'></i></a>
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
