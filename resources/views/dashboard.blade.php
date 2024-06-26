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
    $complaint      = $customer_satisfaction->where('cust_id', Auth::user()->id)->count('id');
    $satisfaction   = $customer_complaint->where('cust_id', Auth::user()->id)->count('id');
    @endphp

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">
                        <div class="d-flex align-items-center justify-content-between ">
                            <div>
                                <p class="text-mute mb-0">Tracking PO</p>
                                <h3 class="text-dark mb-0 mt-1 fw-500">0</h3>
                            </div>
                            <div class="img-updown">
                                <img src="{{ url('') }}/assets/images/dashboard/jcb-1.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-mute mb-0">E-Sertificate</p>
                                <h3 class="text-dark mb-0 mt-1 fw-500">0</h3>
                            </div>
                            <div class="img-updown">
                                <img src="{{ url('') }}/assets/images/dashboard/jcb-2.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-mute mb-0">Customer Satisfaction</p>
                                <h3 class="text-dark mb-0 mt-1 fw-500">{{ $satisfaction }}</h3>
                            </div>
                            <div class="img-updown">
                                <img src="{{ url('') }}/assets/images/dashboard/jcb-3.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-12">
                <div class="box pull-up">
                    <div class="box-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <p class="text-mute mb-0">Customer Complaint</p>
                                <h3 class="text-dark mb-0 mt-1 fw-500">{{ $complaint }}</h3>
                            </div>
                            <div class="img-updown">
                                <img src="{{ url('') }}/assets/images/dashboard/jcb-4.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xxl-8 col-lg-12 col-12">
                <div class="box">
                    <div class="d-flex justify-content-between box-header">
                        <h4 class="box-title fw-600">Overall Balance</h4>
                        <ul class="d-flex list-unstyled"> 
                          <li><i class="fa fa-circle text-info f-12"></i>  Open Ticket</li>
                          <li class="ms-2"><i class="fa fa-circle text-primary f-12"></i> Close Ticket</li>
                        </ul>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-lg-9 p-0">
                                <div id="chart-Overall" class="me-20"></div>
                            </div>
                            <div class="col-lg-3 ps-0 align-self-center">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card pull-up">
                                            <div class="card-body d-flex align-items-center p-3">
                                                <div class="me-10">
                                                    <i class="fa fa-dollar text-success f-16 rounded10 avatar avatar-lg bg-primary-light"></i>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 fw-500">
                                                    <p class="text-mute m-0">Earning</p>
                                                    <h5 class="fw-500 m-0">$15,145</h5>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="px-10 pt-5" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti-more-alt"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                                      <a class="dropdown-item" href="#">Daly</a>
                                                      <a class="dropdown-item" href="#">Weekly</a>
                                                      <a class="dropdown-item" href="#">Monthly</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card pull-up">
                                            <div class="card-body d-flex align-items-center p-3">
                                                <div class="me-10">
                                                    <i class="fa fa-fw fa-money	 text-danger f-16 rounded10 avatar avatar-lg bg-primary-light"></i>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 fw-500">
                                                    <p class="text-mute m-0">Expense</p>
                                                    <h5 class="fw-500 m-0">$8,658</h5>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="px-10 pt-5" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti-more-alt"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                                      <a class="dropdown-item" href="#">Daly</a>
                                                      <a class="dropdown-item" href="#">Weekly</a>
                                                      <a class="dropdown-item" href="#">Monthly</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card pull-up m-0">
                                            <div class="card-body d-flex align-items-center p-3">
                                                <div class="me-10">
                                                    <i class="fa fa-line-chart text-primary f-16 rounded10 avatar avatar-lg bg-primary-light"></i>
                                                </div>
                                                <div class="d-flex flex-column flex-grow-1 fw-500">
                                                    <p class="text-mute m-0">Profit</p>
                                                    <h5 class="fw-500 m-0">$6,356</h5>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="px-10 pt-5" href="#" data-bs-toggle="dropdown" aria-expanded="false"><i class="ti-more-alt"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-end" style="">
                                                      <a class="dropdown-item" href="#">Daly</a>
                                                      <a class="dropdown-item" href="#">Weekly</a>
                                                      <a class="dropdown-item" href="#">Monthly</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-lg-6 col-12">
                <div class="box overflow-hidden">
                    <div class="box-header with-border">
                        <h4 class="box-title">Number Of Ticket/Week</h4>
                        <ul class="box-controls pull-right">
                          <li class="dropdown">
                            <a data-bs-toggle="dropdown" href="#" class="px-10 pt-1"><i class="ti-more-alt fs-18"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
                              <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
                              <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
                            </div>
                          </li>
                        </ul>
                    </div>
                    <div>
                        <div id="numberchart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-lg-6 col-12">
                <div class="box overflow-hidden">
                    <div class="box-header with-border">
                        <h4 class="box-title">Maintenance</h4>
                        <ul class="box-controls pull-right">
                          <li class="dropdown">
                            <a data-bs-toggle="dropdown" href="#" class="px-10 pt-1"><i class="ti-more-alt fs-18"></i></a>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
                              <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
                              <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
                              <div class="dropdown-divider"></div>
                              <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
                            </div>
                          </li>
                        </ul>
                    </div>
                    <div class="box-body pt-0">
                        <div id="revenue-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-8 col-lg-12 col-12">
                <div class="box">
                    <div class="d-flex justify-content-between align-items-center box-header">
                        <h4 class="box-title fw-600">Support Ticket</h4>
                        <button type="button" class="waves-effect waves-light btn btn-outline btn-primary btn-sm">View All</button>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xl-4 col-md-12 col-12">
                                <div class="box pull-up mb-0">
                                    <div class="box-body">
                                        <h4 class="text-dark mb-0 mt-1 fw-500">JCB</h4>
                                        <div class="text-center">
                                            <img src="../images/dashboard/image-1.png">
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between ">
                                            <p class="mb-0 text-primary"><i class="fa fa-hand-paper-o"></i> Manual</p>
                                            <h6 class="mb-0">$350/h</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12 col-12">
                                <div class="box pull-up mb-0">
                                    <div class="box-body">
                                        <h4 class="text-dark mb-0 mt-1 fw-500">JCB Tractor</h4>
                                        <div class="text-center">
                                            <img src="../images/dashboard/image-2.png">
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between ">
                                            <p class="mb-0 text-primary"><i class="fa fa-hand-paper-o"></i> Manual</p>
                                            <h6 class="mb-0">$400/h</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-12 col-12">
                                <div class="box pull-up mb-0">
                                    <div class="box-body">
                                        <h4 class="text-dark mb-0 mt-1 fw-500">JCB Front Loader</h4>
                                        <div class="text-center">
                                            <img src="../images/dashboard/image-3.png">
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between ">
                                            <p class="mb-0 text-primary"><i class="fa fa-hand-paper-o"></i> Manual</p>
                                            <h6 class="mb-0">$450/h</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                  <div class="box">
                    <div class="box-header with-border">
                          <h4 class="box-title">Resent Ticket</h4>
                          <div class="box-controls pull-right">
                            <div class="lookup lookup-circle lookup-right">
                                  <input type="text" name="s">
                            </div>
                          </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive px-2">
                          <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Order Id</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Ticket</th>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>#C78765</td>
                                    <td>Martin</td>
                                    <td>04/08/23</td>
                                    <td>1 Pcs</td>
                                    <td><span class="badge badge-pill badge-success">Done</span></td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>#A12778</td>
                                    <td>Josha</td>
                                    <td>03/08/23</td>
                                    <td>3 Pcs</td>
                                    <td><span class="badge badge-pill badge-danger">Panding</span></td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>#B23789</td>
                                    <td>Tony</td>
                                    <td>02/08/23</td>
                                    <td>2 Pcs</td>
                                    <td><span class="badge badge-pill badge-danger">Panding</span></td>
                                </tr>
                                <tr>
                                    <td>4.</td>
                                    <td>#E47U47</td>
                                    <td>MArgret</td>
                                    <td>02/08/23</td>
                                    <td>1 Pcs</td>
                                    <td><span class="badge badge-pill badge-success">Done</span></td>
                                </tr>
                                <tr>
                                    <td class="border-0">5.</td>
                                    <td class="border-0">#F467DE</td>
                                    <td class="border-0">Tommy</td>
                                    <td class="border-0">01/08/23</td>
                                    <td class="border-0">2 Pcs</td>
                                    <td class="border-0"><span class="badge badge-pill badge-danger">Panding</span></td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
            </div>
            <div class="col-xl-4">
                  <div class="box">
                    <div class="box-header with-border">
                          <h4 class="box-title">Agent With Most Tickets</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="table-responsive px-2">
                          <table class="table table-hover">
                            <thead>
                                <tr class="border-bottom-primary">
                                    <th>Name</th>
                                    <th>Ticket</th>
                                    <th>Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Briggs</td>
                                    <td>6</td>
                                    <td>08:00AM</td>
                                </tr>
                                <tr>
                                    <td>Jenkins</td>
                                    <td>4</td>
                                    <td>10:20AM</td>
                                </tr>
                                <tr>
                                    <td>Martin</td>
                                    <td>2</td>
                                    <td>05:20pm</td>
                                </tr>
                                <tr>
                                    <td>Hella</td>
                                    <td>5</td>
                                    <td>08:00pm</td>
                                </tr>
                                <tr>
                                    <td class="border-0">Josef</td>
                                    <td class="border-0">4</td>
                                    <td class="border-0">10:00pm</td>
                                </tr>
                            </tbody>
                          </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
            </div>
        </div> --}}
    </section>
    <!-- /.content -->

@endsection

@section('js-library')
    {{-- Tempat Ngoding Meletakkan js library --}}
@endsection

@section('js-custom')
    {{-- Tempat Ngoding Meletakkan js custom --}}
@endsection
