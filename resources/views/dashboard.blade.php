@extends('layouts.app')

@section('title', 'Home')

@section('css-library')
    {{-- Tempat Ngoding Meletakkan css library --}}
@endsection

@section('css-custom')
    {{-- Tempat Ngoding Meletakkan css custom --}}
@endsection

@section('content')
    @php
    $satisfaction      = $customer_satisfaction->where('cust_id', $sales_quotation->cust_id ?? '')->count('id');
    $complaint   = $customer_complaint->where('personal_name', Auth::user()->name)->count('id');
    @endphp

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-6 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body text-center" style="background-color: rgba(11,81,166,1)">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#ffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-cpu font-large-1"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"></rect><rect x="9" y="9" width="6" height="6"></rect><line x1="9" y1="1" x2="9" y2="4"></line><line x1="15" y1="1" x2="15" y2="4"></line><line x1="9" y1="20" x2="9" y2="23"></line><line x1="15" y1="20" x2="15" y2="23"></line><line x1="20" y1="9" x2="23" y2="9"></line><line x1="20" y1="14" x2="23" y2="14"></line><line x1="1" y1="9" x2="4" y2="9"></line><line x1="1" y1="14" x2="4" y2="14"></line></svg>
                            <p class="text-mute mb-0 text-white">Welcome to</p>
                            <h4 class="text-dark mb-0 mt-1 fw-500 text-white">Customer Portal System</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body text-center">
                        <div>
                            <h4 class="text-dark mb-0 mt-1 fw-500">Social Media</h4>
                            <hr />
                            
                            <div class="row">
                                <div class="col-lg-4 mt-2">
                                    <a href="https://www.youtube.com/@bukitbaja" target="__blank">
                                        <label class="form-label">Youtube</label><br>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-youtube font-large-1" style="color:#ff0000;"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path><polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon></svg>
                                    </a>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <a href="https://www.instagram.com/bukitbaja/" target="__blank">
                                        <label class="form-label">Instagram</label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram font-large-1" style="color: #c82c83;"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                    </a>
                                </div>
                                <div class="col-lg-4 mt-2">
                                    <a href="https://www.facebook.com/bukitbajanusantara" target="__blank">
                                        <label class="form-label">Facebook</label><br>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook font-large-1" style="color: #1b74e4;"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="box pull-up">
                    <div class="box-body">
                        <div>
                            <p class="text-mute mb-0">Tracking PO</p>
                            <h3 class="text-dark mb-0 mt-1 fw-500">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box pull-up">
                    <div class="box-body">
                        <div>
                            <p class="text-mute mb-0">E-Sertificate</p>
                            <h3 class="text-dark mb-0 mt-1 fw-500">0</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box pull-up">
                    <div class="box-body">
                        <div>
                            <p class="text-mute mb-0">Customer Satisfaction</p>
                            <h3 class="text-dark mb-0 mt-1 fw-500">{{ $satisfaction }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="box pull-up">
                    <div class="box-body">
                        <div>
                            <p class="text-mute mb-0">Customer Complaint</p>
                            <h3 class="text-dark mb-0 mt-1 fw-500">{{ $complaint }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

@endsection

@section('js-library')
    {{-- Tempat Ngoding Meletakkan js library --}}
@endsection

@section('js-custom')
    {{-- Tempat Ngoding Meletakkan js custom --}}
@endsection
