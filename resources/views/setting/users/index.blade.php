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
            <h3 class="page-title">{{ __('Users') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Settings</li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                            @if(Helpers::hasPrivilege('userc'))
                                <div class="btn-group">
                                    <a href="{{ route('users.create') }}" type="button" class="btn bg-gradient-secondary">
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
                                    <th>Users ID</th>
                                    <th>Name</th>
                                    <th>Company Name</th>
                                    <th>Company Sector</th>
                                    <th>User Group</th>
                                    <th>Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $cp)
                                    @php
                                        $lookup = \App\Models\LookupModel::where('lookup_config', 'StatusUser')->where('lookup_code', $cp->status)->first();
                                        $data_sector = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $cp->company_sector)->first();
                                        $role = \App\Models\RoleModel::where('id', $cp->m_role_id)->first();
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $cp->username }}</td>
                                        <td>{{ $cp->name }}</td>
                                        <td>{{ $cp->company_name ?? '-' }}</td>
                                        <td>{{ $data_sector->lookup_name ?? '-' }}</td>
                                        <td>{{ $role->nama }}</td>
                                        <td>
                                            @if ($cp->status == 1)
                                                <span class="badge badge-success">{{ $lookup->lookup_name }}</span>
                                            @else
                                                <span class="badge badge-danger">{{ $lookup->lookup_name }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group mb-5">
                                                <a class="btn btn-sm btn-info" type="button" href='{{ route('users.detail', ['id' => Crypt::encrypt($cp->id)]) }}'>Detail</a>
                                                @if(Helpers::hasPrivilege('useru'))
                                                <a class="btn btn-sm btn-secondary" type="button" href='{{ route('users.edit', ['id' => Crypt::encrypt($cp->id)]) }}'>Edit</a>
                                                @endif
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
