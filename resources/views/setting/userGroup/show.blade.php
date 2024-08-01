@extends('layouts.app')

@section('title', 'Data User Group')

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
            <h3 class="page-title">{{ __('User Group') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Settings</li>
                        <li class="breadcrumb-item" aria-current="page">User Group</li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
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
                            <h4 class="box-title">{{ __('Details Data') }}</h4>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end mb-0">
                            <div class="btn-group">
                                <button id="btn-submit" type="submit" class="btn btn-outline btn-success" style="margin-right: 10px;">Save</button>
                                <a href="{{ route('user-group') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <form id="form-id" action="{{ route('user-group.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">User Group Code<span style="color: red">*</span></label>
                                    <input name="kode" type="text" class="form-control ps-15" value="{{ $role->kode }}" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">User Group Name<span style="color: red">*</span></label>
                                    <input name="nama" type="text" class="form-control ps-15" value="{{ $role->nama }}" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">Created By<span style="color: red">*</span></label>
                                    <input type="text" class="form-control ps-15" value="{{ $role->dibuatOleh->name ?? '-' }}" readonly>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label class="form-label">Created Date<span style="color: red">*</span></label>
                                    <input type="text" class="form-control ps-15" value="{{ $role->created_at }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <h5><b>{{ __('Access Control') }}</b></h5>
                            @foreach ($privileges as $priv)
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">{{ $priv->module->nama }}<span style="color: red">*</span></label>
                                        @foreach (\App\Models\PrivilegesModel::where('m_module_id', $priv->m_module_id )->get() as $priv_code)
                                            <div class="controls">
                                                <fieldset>
                                                    <input type="checkbox" name="m_privilege_id[]" id="checkbox_{{ $priv_code->id }}" value="{{ $priv_code->id }}" checked disabled>
                                                    <label for="checkbox_{{ $priv_code->id }}">{{ $priv_code->nama }}</label>
                                                </fieldset>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
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
