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
                        <li class="breadcrumb-item" aria-current="page">Users</li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
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
                            <h4 class="box-title">{{ __('Edit Data') }}</h4>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end mb-0">
                            <div class="btn-group">
                                <button id="btn-submit" type="submit" class="btn btn-outline btn-success" style="margin-right: 10px;">Save</button>
                                <a href="{{ route('users') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <form id="form-id" action="{{ route('users.update', $users) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">User ID<span style="color: red">*</span></label>
                                    <input name="username" type="text" class="form-control ps-15 bg-transparent" value="{{ $users->username }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Name<span style="color: red">*</span></label>
                                    <input name="name" type="text" class="form-control ps-15 bg-transparent" value="{{ $users->name }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Password<span style="color: red">*</span></label>
                                    <input name="password" type="text" class="form-control ps-15 bg-transparent">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Confirm Password<span style="color: red">*</span></label>
                                    <input name="verifikasi" type="text" class="form-control ps-15 bg-transparent">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Name<span style="color: red">*</span></label>
                                    <select id="select-companyName" class="form-select select2" name="company_name" aria-label="Default select example">
                                        <option value="{{ $users->company_name }}" selected>{{ $users->company_name ?? '' }}</option>
                                        <option value="">--Choose Options--</option>
                                        @foreach(\App\Models\CompanyModel::all() as $cmpny)
                                            <option value="{{ $cmpny->company_name }}">{{ $cmpny->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>    
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Telephone</label>
                                    <input name="phone" type="text" class="form-control ps-15 bg-transparent" value="{{ $users->phone }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">User Group<span style="color: red">*</span></label>
                                    <select id="select-Usergroup" class="form-select select2" name="m_role_id" aria-label="Default select example">
                                        <option value="{{ $users->m_role_id }}" selected>{{ $users->role->nama }}</option>
                                        <option value="">--Choose Options--</option>
                                        @foreach(\App\Models\RoleModel::all() as $usergrup)
                                            <option value="{{ $usergrup->id }}">{{ $usergrup->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>    
                            </div>
                            <div class="col-4">
                                @php
                                    $lookup = \App\Models\LookupModel::where('lookup_config', 'StatusUser')->where('lookup_code', $users->status)->first();
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Status<span style="color: red">*</span></label>
                                    <select id="select-statusUser" class="form-select select2" name="status" aria-label="Default select example">
                                        <option value="{{ $users->m_role_id }}" selected>{{ $lookup->lookup_name }}</option>
                                        <option value="">--Choose Options--</option>
                                        @foreach(\App\Models\LookupModel::where('lookup_config', 'StatusUser')->get() as $lookup)
                                            <option value="{{ $lookup->lookup_code }}">{{ $lookup->lookup_name }}</option>
                                        @endforeach
                                    </select>
                                </div>    
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <textarea rows="5" class="form-control" name="alamat" placeholder="Address">{{ $users->alamat }}</textarea>
                                </div>
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
            $('.select-companySector').select2({ placeholder: "--Choose Options--" });

            // SUBMIT FORM
            $("#btn-submit").on('click', function(e) {
                e.preventDefault();
                $('#btn-submit').prop('disabled', true);
                
                let formUrl = $('#form-id').attr('action');
                let form_data = $('#form-id').serialize();
                // console.log(form_data);

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
