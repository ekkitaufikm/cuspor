@extends('layouts.app')

@section('title', 'Data Users')

@section('css-library')
    {{-- Tempat Ngoding Meletakkan css library --}}
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
@endsection

@section('css-custom')
    {{-- Tempat Ngoding Meletakkan css custom --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        }

        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
        }
        .popup h2 {
            margin-top: 0;
        }
        .popup ul {
            list-style-type: none;
            padding: 0;
        }
        .popup li {
            margin-bottom: 10px;
        }
        .popup button {
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .popup button:hover {
            background-color: #0056b3;
        }
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
                        <li class="breadcrumb-item" aria-current="page">{{ __('Customer Complaint') }}</li>
                        <li class="breadcrumb-item active" aria-current="page">Add Survey</li>
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
                            <h4 class="box-title">{{ __('Create Data') }}</h4>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-end mb-0">
                            <div class="btn-group">
                                <button id="btn-submit" type="submit" class="btn btn-outline btn-success" style="margin-right: 10px;">Save</button>
                                <a href="{{ route('customer-complaint') }}" type="button" class="btn btn-outline btn-dark">
                                    Return
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <form id="form-id" action="{{ url('customer-complaint/add-survey/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Complaint No</label>
                                    <input type="text" class="form-control ps-15" name="complaint_no" placeholder="[ Auto ]" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Complaint Date</label>
                                    <input type="text" class="form-control ps-15" name="created_at" value="{{ now() }}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Complaint By</label>
                                    <input type="text" class="form-control ps-15" name="created_by" value="{{ Auth::user()->name }}" readonly>
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label">SQ No<span style="color: red">*</span></label>
                                <div class="input-group">
                                    <input id="select-quotation-display" name="sq_id" type="text" class="form-control" placeholder="SQ No" readonly>
                                    <input id="select-quotation-input" name="sq_id" type="hidden" class="form-control">
                                    <button type="button" class="btn btn-primary" onclick="openQuotationPopup()">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                                <!-- /.input group -->
                            </div>
                             <!-- Modal -->
                             <div class="modal fade" id="quotationModal" tabindex="-1" role="dialog" aria-labelledby="quotationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="quotationModalLabel">Select Sales Quotation</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <div class="table-responsive">
                                        <table id="quotationTable" class="table table-striped table-bordered" style="width:100%">
                                          <thead>
                                            <tr>
                                              <th>No</th>
                                              <th>SQ No</th>
                                              <th>INQ No</th>
                                              <th>Customer</th>
                                              <th>RFQ Subject</th>
                                              <th>Action</th>
                                            </tr>
                                          </thead>
                                          <tbody id="quotationTableBody">
                                            <!-- Quotations will be dynamically added here -->
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 10px;margin-top:20px;">
								<fieldset class="scheduler-border" style="padding: 20px;">
									<legend class="scheduler-border" style="color: green;">SQ Information</legend>
									<div class="row mt-2" style="padding-left: 2.5rem; padding-right: 2.5rem;">
										<div class="col-xl-4 p-0">
											<table id="quotationDetailsTable" style="padding: 20px;">
												<tbody>
													<tr>
														<td class="pr-1" valign="top">SQ No</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="quotation-no" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">INQ No</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="inquiry-no" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">SQ Date</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="quotation-date" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Status</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="status" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Offer Mode</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="offer-mode" valign="top"></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-xl-4 p-0">
											<table id="quotationDetailsTable">
												<tbody>
													<tr>
														<td class="pr-1" valign="top">Est`d Shipping CW</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="est-ship-weight" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Payment Term</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="payment-term" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Payment Mode</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="payment-mode" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Delivery Time</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="delivery-time" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Technical Abbreviation/Remarks</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="tech-remarks" valign="top"></td>
													</tr>
												</tbody>
											</table>
										</div>
										<div class="col-xl-4 p-0">
											<table>
												<tbody>
													<tr>
														<td class="pr-1" valign="top">Delivery Mode</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="delivery-mode" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Packing</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="packing" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Certification</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="certification" valign="top"></td>
													</tr>
													<tr>
														<td class="pr-1" valign="top">Offer Validity</td>
														<td style="width: 10px;" valign="top">: </td>
														<td id="offer-validity" valign="top"></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>

									<div class="row" style="margin-bottom: -20px">
										<div class="col-12 d-flex flex-sm-row flex-column" style="justify-content: right;margin-bottom: 20px">
											<a href="javascript:void(0)" onclick="myFunction()">
												<h5 class="show-hide text-info">VIEW MORE SQ DETAIL</h5>
											</a>
										</div>
									</div>

								</fieldset>
							</div>
                            <div id="myDiv" style="display: none;">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom: 10px;margin-top:20px;">
                                        <fieldset class="scheduler-border" style="padding: 20px;">
                                            <legend class="scheduler-border" style="color: green;">Inquiry Information</legend>
                                            <div class="row mt-2" style="padding-left: 2.5rem; padding-right: 2.5rem;">
                                                <div class="col-xl-4 p-0">
                                                    <table style="padding: 20px;">
                                                        <tbody>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Customer Inquiry No</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="customer-inquiry" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Stage of Inquiry</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="stage-inquiry" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Inquiry Date</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="inquiry-date" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Status</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="status-inquiry" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">PIC Acknowledge</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="pic-ack" valign="top"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-xl-4 p-0">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Email Datetime</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="email-datetime" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Closing Date</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="closing-datetime" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Subject</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="subject-inquiry" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">PIC Sales</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="pic-sales" valign="top"></td>
                                                                <input id="pic-sales" name="pic_sales" type="hidden" class="form-control">
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Remarks</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="remarks-inquiry" valign="top"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-xl-4 p-0">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Customer Name</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="customer-name" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">Customer Type</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="customer-type" valign="top"></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pr-1" valign="top">PIC Customer</td>
                                                                <td style="width: 10px;" valign="top">: </td>
                                                                <td id="pic-customer" valign="top"></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                    <div class="col-md-12" style="margin-bottom: 10px;margin-top:20px;">
                                        <fieldset class="scheduler-border" style="padding: 20px;">
                                            <legend class="scheduler-border" style="color: green;">PRODUCT ORDER HISTORY</legend>
                                            <div class="form-group row">
                                                <div class="table-responsive mt-3">
                                                    <table id="itemsTable" class="table table-striped table-bordered display" style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Customer Material No</th>
                                                                <th>Coating</th>
                                                                <th>Type</th>
                                                                <th>Spec</th>
                                                                <th>Grade</th>
                                                                <th>QTY (Nut)</th>
                                                                <th>Nut (Type)</th>
                                                                <th>Spec</th>
                                                                <th>Grade</th>
                                                                <th>QTY (Washer)</th>
                                                                <th>Washer (Type)</th>
                                                                <th>Diameter</th>
                                                                <th>Length</th>
                                                                <th>Satuan</th>
                                                                <th>QTY Sets</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="itemsTableBody">
                                                        </tbody>                            
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Personal Name</label>
                                    <input type="text" class="form-control ps-15" name="personal_name" value="{{ Auth::user()->name }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Tel/Fax No.</label>
                                    <input type="text" class="form-control ps-15" name="telp_fax" value="{{ Auth::user()->phone }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Mobile No</label>
                                    <input type="text" class="form-control ps-15" name="phone" value="{{ Auth::user()->phone }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Email Customer</label>
                                    <input type="text" class="form-control ps-15" name="email" value="{{ Auth::user()->email }}" disabled>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Title</label>
                                    <select class="form-control" name="title" aria-label="Default select example" disabled>
                                        <option value="{{ Auth::user()->department }}">{{ Auth::user()->department ?? '' }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label">Purchase Order No & Date</label>
                                    <input type="text" name="po_dan_date" class="form-control ps-15" value="{{ $sales_quotation->sq_no }} & {{ $sales_quotation->created_date }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 10px;">
                                <fieldset class="scheduler-border" style="padding: 20px;">
                                    {{-- <legend class="scheduler-border">Inquiry Items</legend> --}}
                                    <legend class="scheduler-border" style="color: green;">Category</legend>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_123" name="category[]" value="Short Shipment">
                                                            <label for="checkbox_123" class="me-30">Short Shipment</label>
                                                            <br>
                                                            <input type="checkbox" id="checkbox_234" name="category[]" value="Surface Discontinuities of Bolt (F788">
                                                            <label for="checkbox_234" class="me-30">Surface Discontinuities of Bolt (F788)</label>
                                                            <br>
                                                            <input type="checkbox" id="checkbox_345" name="category[]" value="Surface Discontinuities of Nut (F812)">
                                                            <label for="checkbox_345" class="me-30">Surface Discontinuities of Nut (F812)</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="c-inputs-stacked">
                                                            <input type="checkbox" id="checkbox_456" name="category[]" value="Coating Surface">
                                                            <label for="checkbox_456" class="me-30">Coating Surface</label>
                                                            <br>
                                                            <input type="checkbox" id="checkbox_567" name="category[]" valude="Thread Function">
                                                            <label for="checkbox_567" class="me-30">Thread Function</label>
                                                            <br>
                                                            <input type="checkbox" id="checkbox_678" name="category[]" value="Others">
                                                            <label for="checkbox_678" class="me-30">Others</label>
                                                            <div class="type-form">
                                                                <div id="type-form-1">
                                                                    <input type="text" class="form-control ps-15" name="category_other" placeholder="Input Other Category">
                                                                </div>
                                                            </div>
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
                                    <textarea rows="5" class="form-control" name="description" placeholder="material shortage Item #51, #50, #18 "></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6" >
                                    <div class="form-group file-input-group" id="fileInputsContainer1">
                                        <label class="form-label">Upload File Lampiran</label>
                                        <div class="input-group">
                                            <input type="file" name="file_lampiran[]" class="form-control bg-transparent" multiple>
                                        </div>
                                        <div class="form-control-feedback"><small>Contoh: Form Keluhan Pelanggan Format Customer</small></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <button id="addFileButton1" class="btn btn-primary mb-3" type="button">Tambah Upload File Lampiran</button>
                                    </div>
                                </div>
                                <div class="col-lg-6" >
                                    <div class="form-group file-input-group" id="fileInputsContainer2">
                                        <label class="form-label">Upload Photo</label>
                                        <div class="input-group">
                                            <input type="file" name="file_photo[]" class="form-control bg-transparent" multiple>
                                        </div>
                                        <div class="form-control-feedback"><small>Contoh: Foto Produk yang Rusak</small></div>
                                    </div>
                                    <div class="col-lg-6">
                                        <button id="addFileButton2" class="btn btn-primary mb-3" type="button">Tambah Upload Photo</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-lg-6 mt-2">
                            <h4 class="box-title">{{ __('Complaints Resolved By') }}</h4>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Complain Received by</label>
                                <input type="text" class="form-control ps-15" name="personal_name" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Date Received</label>
                                <input type="text" class="form-control ps-15" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Complaints Resolved By</label>
                                <input type="text" class="form-control ps-15" disabled>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control ps-15" disabled>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">Action Taken</label>
                                <textarea rows="5" class="form-control" disabled></textarea>
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
    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js" integrity="sha384-BVX3EoFmCW85CPbT2U5Fp1a3Rp4zMGH1+Oz5xCv4eDf5Y8Bc4pW4fG1ksw5LUIMh" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

@endsection

@section('js-custom')
    {{-- Tempat Ngoding Meletakkan js custom --}}
    <script>
        $(document).ready(function() {
            $('#addFileButton1').click(function() {
                var html = `
                    <div class="form-group file-input-group">
                        <label class="form-label">Upload File Lampiran</label>
                        <div class="input-group">
                            <input type="file" name="file_lampiran[]" class="form-control bg-transparent" multiple>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger delete-button1"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="form-control-feedback"><small>Example : Form Keluhan Pelanggan Format Customer</small></div>
                    </div>`;
                $('#fileInputsContainer1').append(html);
            });
        
            $(document).on('click', '.delete-button1', function() {
                $(this).closest('.form-group').remove();
            });

            $('#addFileButton2').click(function() {
                var html = `
                    <div class="form-group file-input-group">
                        <label class="form-label">Upload Photo</label>
                        <div class="input-group">
                            <input type="file" name="file_photo[]" class="form-control bg-transparent" multiple>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-danger delete-button2"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="form-control-feedback"><small>Contoh: Foto Produk yang Rusak</small></div>
                    </div>`;
                $('#fileInputsContainer2').append(html);
            });
        
            $(document).on('click', '.delete-button2', function() {
                $(this).closest('.form-group').remove();
            });
        });
    </script>
    
    <script>
        // Fungsi untuk menampilkan atau menyembunyikan form berdasarkan status checkbox
        function toggleFormVisibility() {
            const checkbox = document.getElementById('checkbox_678');
            const typeForm = document.getElementById('type-form-1');
    
            if (checkbox.checked) {
                typeForm.style.display = 'block'; // Jika checkbox dicentang, tampilkan form
            } else {
                typeForm.style.display = 'none'; // Jika checkbox tidak dicentang, sembunyikan form
            }
        }
    
        // Tambahkan event listener untuk mendeteksi klik pada checkbox
        document.getElementById('checkbox_678').addEventListener('change', toggleFormVisibility);
    
        // Panggil fungsi toggleFormVisibility() sekali pada awal untuk sinkronisasi tampilan
        toggleFormVisibility();
    </script>
    <script>
        // Function to open the quotation popup
        function openQuotationPopup() {
          // Clear previous table rows
          $('#quotationTableBody').empty();
      
          // Fetch sales quotations via Ajax
            $.ajax({
                url: '{{ url("customer-complaint/get-data-ajax") }}', // URL dari rute yang telah Anda definisikan di Laravel
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Populate the modal with sales quotations
                    data.forEach((quotation, index) => {
                        let row = `<tr>
                                    <td>${index + 1}</td>
                                    <td>${quotation.sq_no}</td>
                                    <td>${quotation.inq_no}</td>
                                    <td>${quotation.cust_name}</td>
                                    <td>${quotation.subject}</td>
                                    <td><button type="button" class="btn btn-link" onclick="selectQuotation('${quotation.sq_no}', '${quotation.inq_no}')">Select</button></td>
                                </tr>`;
                        $('#quotationTableBody').append(row);
                    });
        
                    // Show the modal
                    $('#quotationModal').modal('show');
                },
                error: function(xhr, status, error) {
                console.error('Failed to fetch sales quotations:', status, error);
                }
            });
        }
      
        function rupiah(amount) {
            return `Rp ${amount.toLocaleString('id-ID')}`;
        }
        // Function to select a quotation
        function selectQuotation(sqNo, inqNo) {
            // Perform actions when a quotation is selected (e.g., update form fields)
            // console.log(`Selected Quotation: SQ No - ${sqNo}, Inquiry No - ${inqNo}`);
            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ url("customer-complaint/get-quotation-details") }}',
                type: 'POST',
                dataType: 'json',
                data: { sqNo: sqNo }, // Sending the selected SQ number to server
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Mengirim CSRF token dalam header
                },
                success: function(response) {
                    // Autofill form fields with quotation details
                    $('#select-quotation-display').val(response.sq_no); 
                    $('#select-quotation-input').val(response.sq_id); 
                    $('#quotation-no').text(response.sq_no);
                    $('#inquiry-no').text(response.inq_no);
                    $('#quotation-date').text(response.quotation_date);
                    $('#status').text(response.status); 
                    $('#offer-mode').text(response.offer_mode); 
                    $('#est-ship-weight').text(response.est_ship_weight); 
                    $('#payment-term').text(response.payment_term);
                    $('#payment-mode').text(response.payment_mode);
                    $('#delivery-time').text(response.delivery_time);
                    $('#tech-remarks').text(response.tech_remarks);
                    $('#delivery-mode').text(response.delivery_mode);
                    $('#packing').text(response.packing);
                    $('#certification').text(response.certification);
                    $('#offer-validity').text(response.offer_validity);
                    $('#customer-inquiry').text(response.inq_no);
                    $('#stage-inquiry').text(response.stage_inquiry);
                    $('#inquiry-date').text(response.inquiry_date);
                    $('#status-inquiry').text(response.status_inquiry);
                    $('#pic-ack').text(response.pic_ack);
                    $('#email-datetime').text(response.email_datetime);
                    $('#closing-datetime').text(response.closing_date);
                    $('#subject-inquiry').text(response.subject_inquiry);
                    $('#pic-sales').text(response.pic_sales);
                    $('#remarks-inquiry').text(response.remarks_inquiry);
                    $('#customer-name').text(response.customer_name);
                    $('#customer-type').text(response.customer_type);
                    $('#pic-customer').text(response.pic_customer);
                    response.quotation_items.forEach((quotation_item, index) => {
                        let row = `<tr>
                                    <td>${index + 1}</td>
                                    <td>${quotation_item.cust_mat_code}</td>
                                    <td>${quotation_item.coating}</td>
                                    <td>${quotation_item.type}</td>
                                    <td>${quotation_item.spec}</td>
                                    <td>${quotation_item.grade}</td>
                                    <td>${quotation_item.qty_nut}</td>
                                    <td>${quotation_item.nut}</td>
                                    <td>${quotation_item.spec_nut}</td>
                                    <td>${quotation_item.grade_nut}</td>
                                    <td>${quotation_item.qty_washer}</td>
                                    <td>${quotation_item.washer_type}</td>
                                    <td>${quotation_item.diameter}</td>
                                    <td>${quotation_item.length}</td>
                                    <td>${quotation_item.length_unit}</td>
                                    <td>${quotation_item.qty_sets}</td>
                                </tr>`;
                        $('#itemsTableBody').append(row);
                    });

                    // Show selected quotation in a specific div or update some UI
                    $('#selected-quotation').html(`Selected Quotation: ${response.sq_no}`);

                    // Hide the modal after filling the form
                    $('#quotationModal').modal('hide');
                },
                error: function(xhr, status, error) {
                    console.error('Failed to fetch quotation details:', status, error);
                }
            });
            // Hide the modal
            $('#quotationModal').modal('hide');
        }
    </script>
    <script>
        function myFunction() {
            var myDiv = $('#myDiv');
            var buttonText = $('.show-hide');
    
            if (myDiv.is(':visible')) {
                myDiv.hide();
                buttonText.text('VIEW MORE SQ DETAIL');
                buttonText.removeClass('text-warning');
            } else {
                myDiv.show();
                buttonText.text('HIDE SQ DETAIL');
                buttonText.addClass('text-warning');
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $("#btn-submit").on('click', function(e) {
                e.preventDefault();
                $('#btn-submit').prop('disabled', true);
                
                let formUrl = $('#form-id').attr('action');
                let formData = new FormData($('#form-id')[0]); // Menggunakan FormData untuk mengirim form data

                $.ajax({
                    url: formUrl,
                    method: "POST",
                    dataType: "JSON",
                    data: formData,
                    contentType: false,
                    processData: false, // Penting untuk FormData
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
