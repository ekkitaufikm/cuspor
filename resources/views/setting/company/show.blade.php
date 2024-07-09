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
            <h3 class="page-title">{{ __('Company') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Settings</li>
                        <li class="breadcrumb-item" aria-current="page">Company</li>
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
                                <a href="{{ route('company') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Company Name</label>
                                <input name="company_name" type="text" class="form-control ps-15" value="{{ old('company_name', $company->company_name) }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            @php
                                $lookup = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $company->company_sector)->first();
                            @endphp
                            <div class="form-group">
                                <label class="form-label">Company Sector</label>
                                <input name="company_name" type="text" class="form-control ps-15" value="{{ $lookup->lookup_name }}" disabled>
                            </div>    
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Company Website</label>
                                <input name="website" type="text" class="form-control ps-15" value="{{ old('website', $company->website) }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Company Email</label>
                                <input name="email" type="text" class="form-control ps-15" value="{{ old('email', $company->email) }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Company Telephone</label>
                                <input name="telephone" type="text" class="form-control ps-15" value="{{ old('telephone', $company->telephone) }}" disabled>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">Company Address</label>
                                <textarea rows="5" class="form-control" name="address" placeholder="Company Address" disabled>{{ old('address', $company->address) }}</textarea>
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

@endsection

@section('js-custom')
    {{-- Tempat Ngoding Meletakkan js custom --}}
@endsection
