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
                        <li class="breadcrumb-item active" aria-current="page">Company</li>
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
                            <h4 class="box-title">List Data</h4>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end mb-0">
                            @if(Helpers::hasPrivilege('companyc'))
                                <div class="btn-group">
                                    <a href="{{ route('company.create') }}" type="button" class="btn bg-gradient-secondary">
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
                                    <th>Company Name</th>
                                    <th>Company Sector</th>
                                    <th>Website</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Address</th>
                                    <th width="10%"><i class="fa fa-cog"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($company as $cp)
                                    @php
                                        $lookup = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $cp->company_sector)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $cp->company_name }}</td>
                                        <td>{{ $lookup->lookup_name }}</td>
                                        <td>{{ $cp->website }}</td>
                                        <td>{{ $cp->email }}</td>
                                        <td>{{ $cp->telephone }}</td>
                                        <td>{{ $cp->address }}</td>
                                        <td>
                                            <a href='{{ route('company.detail', ['id' => $cp->id]) }}'><i class='fa fa-eye ms-text-primary'></i></a>
                                            @if(Helpers::hasPrivilege('companyu'))
                                                <a href='{{ route('company.edit', ['id' => $cp->id]) }}'><i class='fa fa-pencil ms-text-primary'></i></a>
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
