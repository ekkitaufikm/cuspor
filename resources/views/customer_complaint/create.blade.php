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
            <h3 class="page-title">{{ __('Customer Complaint') }}</h3>
            <div class="d-inline-block align-items-center">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"> Home</i></a></li>
                        <li class="breadcrumb-item" aria-current="page">Settings</li>
                        <li class="breadcrumb-item" aria-current="page">{{ __('Customer Complaint') }}</li>
                        <li class="breadcrumb-item active" aria-current="page">Add Survey</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<section class="content">
    <form class="form">
        <div class="row">			  
            <div class="col-lg-6 col-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <h4 class="box-title text-info mb-0"><i class="ti-user me-15"></i> Customer Details</h4>
                        <hr class="my-15">
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Company Code<span style="color: red">*</span></label>
                                <input type="text" class="form-control ps-15" value="{{ $data_customer->cust_code }}" disabled>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Company Name<span style="color: red">*</span></label>
                                <input type="text" class="form-control ps-15" value="{{ $data_customer->cust_name }}" disabled>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            @php
                                $lookup = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $data_customer->company_sector)->first();
                                $pk_status = \App\Models\LookupModel::where('lookup_config', 'sls_pk_status')->where('lookup_code', $perintah_kerja->status)->first();
                            @endphp
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Company Sector<span style="color: red">*</span></label>
                                    <select id="select-companySector" class="form-select select2" name="company_sector" aria-label="Default select example" disabled>
                                        <option value="{{ $data_customer->company_sector }}" selected>{{ $lookup->lookup_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">PK No</label>
                                    <input type="text" class="form-control ps-15" value="{{ $perintah_kerja->pk_no }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">PK Date</label>
                                    <input type="text" class="form-control ps-15" value="{{ $perintah_kerja->pk_date }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">PK Status</label>
                                    <input type="text" class="form-control ps-15" value="{{ $pk_status->lookup_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Survey Status</label>
                                    <input type="text" class="form-control ps-15" value="{{ isset($cp_satisfaction->status) ? '[Survey Finished]' : '[No Survey Yet]' }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">PIC Sales BBN</label>
                                    <input type="text" class="form-control ps-15" value="{{ $data_pic_sales->user_name }}" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">PIC Customer BBN</label>
                                    <input type="text" class="form-control ps-15" value="{{ $data_pic_customer->pic_name }}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->			
            </div>  
            <div class="col-lg-6 col-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <h4 class="box-title text-info mb-0"><i class="ti-user me-15"></i> Complaint Details</h4>
                        <hr class="my-15">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <fieldset class="scheduler-border">
                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                    <label class="form-label"><b>Category</b></label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_123">
                                                            <label for="checkbox_123" class="me-30">Short Shipment</label>
                                                            <br>
                                                            <input type="checkbox" id="checkbox_234">
                                                            <label for="checkbox_234" class="me-30">Surface Discontinuities of Bolt (F788)</label>
                                                            <br>
                                                            <input type="checkbox" id="checkbox_345">
                                                            <label for="checkbox_345" class="me-30">Surface Discontinuities of Nut (F812)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_456">
                                                            <label for="checkbox_456" class="me-30">Coating Surface</label>
                                                            <br>
                                                            <input type="checkbox" id="checkbox_567">
                                                            <label for="checkbox_567" class="me-30">Thread Function</label>
                                                            <br>
                                                            <input type="checkbox" id="checkbox_678">
                                                            <label for="checkbox_678" class="me-30">Others</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </fieldset>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Description of Non- Conformance (The Issues)</label>
                                    <textarea rows="5" class="form-control" name="dexcription" placeholder="material shortage Item #51, #50, #18 "></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Upload File Lampiran</label>
									<input type="file" name="file" class="form-control bg-transparent" required> 
                                    <div class="form-control-feedback"><small>Example : Form Keluhan Pelanggan Format Customer</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box -->			
            </div>  
            <div class="col-lg-12">
                <div class="box">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <h4 class="box-title text-info mb-0"><i class="ti-user me-15"></i> Complaint Resolved</h4>
                        <hr class="my-15">
                        <div class="row">
                            <div class="col-md-6" style="margin-bottom: 10px;">
                                <fieldset class="scheduler-border" id="complex-header">
                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                    <label class="form-label"><b>Resolved Infomation</b></label>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Date Received</label>
                                                <input type="text" class="form-control ps-15" value="{{ now() }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Job Title</label>
                                                <input type="text" class="form-control ps-15" value="{{ $data_sls_inquiry->project_name ?? '-' }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Complaints Received by</label>
                                                <input type="text" class="form-control ps-15" value="{{ Auth::user()->name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Complaints Resolved By</label>
                                                <input type="text" class="form-control ps-15" value="{{ Auth::user()->name }}" disabled>
                                            </div>
                                        </div>  
                                    </div>                               
                                </fieldset>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <textarea rows="5" class="form-control dynamic-height" name="dexcription" placeholder="Action Taken"></textarea>
                                </div>
                            </div>  
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Upload File Lampiran</label>
									<input type="file" name="file" class="form-control bg-transparent" required> 
                                </div>
                            </div> 
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Upload File Lampiran</label>
									<input type="file" name="file" class="form-control bg-transparent" required> 
                                </div>
                            </div> 
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Upload File Lampiran</label>
									<input type="file" name="file" class="form-control bg-transparent" required> 
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
                <!-- /.box -->			
            </div>  
        </div>
    </form>
</section>
@endsection

@section('js-library')
    {{-- Tempat Ngoding Meletakkan js library --}}

@endsection

@section('js-custom')
    {{-- Tempat Ngoding Meletakkan js custom --}}
    <script>
        // Mendapatkan tinggi dari fieldset "Resolved Information"
        var resolvedInfoHeight = document.getElementById('complex-header').clientHeight;
    
        // Menentukan textarea yang akan diatur tingginya
        var textarea = document.querySelector('.dynamic-height');
    
        // Mengatur tinggi textarea sesuai dengan tinggi resolvedInfoHeight
        textarea.style.height = resolvedInfoHeight + 'px';
    </script>

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
