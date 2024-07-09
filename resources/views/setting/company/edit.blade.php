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
                                <a href="{{ route('company') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <form id="form-id" action="{{ route('company.update', $company) }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Name<span style="color: red">*</span></label>
                                    <input name="company_name" type="text" class="form-control ps-15 bg-transparent" value="{{ old('company_name', $company->company_name) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                @php
                                    $lookup = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $company->company_sector)->first();
                                @endphp
                                <div class="form-group">
                                    <label class="form-label">Company Sector<span style="color: red">*</span></label>
                                    <select id="select-companySector" class="form-select select2" name="company_sector" aria-label="Default select example">
                                        <option value="{{ $company->company_sector }}" selected>{{ $lookup->lookup_name }}</option>
                                        <option value="">--Choose Options--</option>
                                        @foreach(\App\Models\LookupModel::where('lookup_config', 'company_sector')->get() as $lookup)
                                            <option value="{{ $lookup->lookup_code }}">{{ $lookup->lookup_name }}</option>
                                        @endforeach
                                    </select>
                                </div>    
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Website</label>
                                    <input name="website" type="text" class="form-control ps-15 bg-transparent" value="{{ old('website', $company->website) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Email</label>
                                    <input name="email" type="text" class="form-control ps-15 bg-transparent" value="{{ old('email', $company->email) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Telephone</label>
                                    <input name="telephone" type="text" class="form-control ps-15 bg-transparent" value="{{ old('telephone', $company->telephone) }}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Company Address</label>
                                    <textarea rows="5" class="form-control" name="address" placeholder="Company Address">{{ old('address', $company->address) }}</textarea>
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
