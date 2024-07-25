<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ url('') }}/assets/images/LogoBBN.png">
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10mm;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .label {
            width: 210mm;
            height: auto;
            border: 1px solid black;
            padding: 5mm;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .judul, .evalKin {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .keterangan {
            font-size: 12px;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .commercial {
            padding-top: 20px;
            width: 100%;
        }

        .dataPelanggan {
            font-size: 12px;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            overflow-x: auto; /* Memungkinkan horizontal scrolling jika perlu */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }

        /* Responsiveness untuk tabel */
        @media (max-width: 768px) {
            table {
                width: 100%;
            }
            table th, table td {
                padding: 5px;
                text-align: left;
            }
        }

    </style>
</head>
<body>
    @php
        $users  = \App\Models\User::where('id', Auth::user()->id)->first();
    @endphp
    <div class="label">
        <div class="logo">
            <img style="padding-top: 2px" width="100%" src="{{ url('') }}/assets/images/kop/kop_surat.jpg" alt="" align="left">
        </div>
        <div class="judul">
            <h1>SURVEI KEPUASAN PELANGGAN</h1>
            <h2>(CUSTOMER SATISFACTION SURVEY)</h2>
        </div>
        <div class="keterangan">
            <p>Mohon berbagi pemikiran Anda tentang produk dan layanan kami</p>
            <span>(Please kindly sharing your thoughts regarding our product and services)</span>
        </div>
        <div class="dataPelanggan">
            <table>
                <tbody>
                    <tr>
                        <td><b>Nama Perusahaan</b> (Company Name)</td>
                        <td>:</td>
                        <td>{{ $sales_customer->cust_name }}</td>
                    </tr>
                    <tr>
                        <td><b>Nomer PO</b> (PO No)</td>
                        <td>:</td>
                        <td>{{ $sales_quotation->sq_no }}</td>
                    </tr>
                    <tr>
                        <td><b>Nama Project</b> (Project Name) / <b>Referensi proyek</b> (Project Ref.)</td>
                        <td>:</td>
                        <td>{{ $sales_inquiry->project_name ?? '' }}</td>
                    </tr>
                    <tr>
                        <td><b>Nama Pribadi</b> (Personal Name)</td>
                        <td>:</td>
                        <td>{{ $users->name }}</td>
                    </tr>
                    <tr>
                        <td><b>Alamat Email</b> (Email Address)</td>
                        <td>:</td>
                        <td>{{ $users->email }}</td>
                    </tr>
                    <tr>
                        <td><b>Divisi</b> (Division) / <b>Departemen</b> (Department)</td>
                        <td>:</td>
                        <td>{{ $users->department }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="evalKin">
            <h2>Evaluasi Kinerja PT Bukit Baja Nusantara</h2>
            <h3>(Performance Evaluation of PT Bukit Baja Nusantara)</h3>
        </div>
        <div class="dataPen">
            <div class="buyer">
                <table>
                    <thead>
                        <tr>
                            <th colspan="13">Procurement / Buyer</th>
                        </tr>
                        <tr>
                            <th rowspan="3">No</th>
                            <th rowspan="3">Description Survey</th>
                            <th colspan="10">Category</th>
                        </tr>
                        <tr>
                            <th colspan="4" style="color: red">Unsatisfactory</th>
                            <th colspan="2" style="color:black">Fair</th>
                            <th colspan="2" style="color:blue">Good</th>
                            <th colspan="2" style="color:green">Excelent</th>
                        </tr>
                        <tr>
                            <!-- Kolom Category -->
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>How was our service/response to the inquiry you sent to PT BBN?</td>
                            @php
                                $services_inquiry_value = $customer_satisfaction_dtl->services_inquiry;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category1_{{ $value }}" name="services_inquiry" value="{{ $value }}" class="star-checkbox" {{ $services_inquiry_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>
    
                        <tr>
                            <td>2</td>
                            <td>How was our service/response to the technical questions/clarifications/explanations you needed?</td>
                            @php
                                $services_technical_value = $customer_satisfaction_dtl->services_technical;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category2_{{ $value }}" name="services_technical" value="{{ $value }}" class="star-checkbox" {{ $services_technical_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>
    
                        <tr>
                            <td>3</td>
                            <td>What is the level of alignment between the inquiry you sent and the proposal submitted by PT BBN?</td>
                            @php
                                $services_level_alignment_value = $customer_satisfaction_dtl->services_level_alignment;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category3_{{ $value }}" name="services_level_alignment" value="{{ $value }}" class="star-checkbox" {{ $services_level_alignment_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h3 class="text-center">Remarks</h1>
                            </td>
                            <td colspan="11">
                                {{ $customer_satisfaction_dtl->services_remarks ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $nilai_average = ((($customer_satisfaction_dtl->services_inquiry ?? '0')+($customer_satisfaction_dtl->services_technical ?? '0')+($customer_satisfaction_dtl->services_level_alignment ?? '0'))/3)*10
                            @endphp
                            <td colspan="2">
                                <h3 class="text-center">Average Survey</h1>
                            </td>
                            <td colspan="11" style="margin-left: 5px">
                                {{ isset($nilai_average) ? $nilai_average . '%' : '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table> 
            </div>
            <div class="commercial">
                <table style="padding-top: 10px" width="100%">
                    <thead>
                        <tr>
                            <th rowspan="3">No</th>
                            <th rowspan="3">Description Survey</th>
                            <th colspan="10">Category</th>
                        </tr>
                        <tr>
                            <th colspan="4" style="color: red">Unsatisfactory</th>
                            <th colspan="2" style="color:black">Fair</th>
                            <th colspan="2" style="color:blue">Good</th>
                            <th colspan="2" style="color:green">Excelent</th>
                        </tr>
                        <tr>
                            <!-- Kolom Category -->
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>What is the level of alignment between the price we offer and the service and quality of materials we supply?</td>
                            @php
                                $commercial_level_alignment_value = $customer_satisfaction_dtl->commercial_level_alignment;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category4_{{ $value }}" name="commercial_level_alignment" value="{{ $value }}" class="star-checkbox" {{ $commercial_level_alignment_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>
    
                        <tr>
                            <td>2</td>
                            <td>What is the level of flexibility in the Terms of Payment provided by PT BBN?</td>
                            @php
                                $commercial_flexibility_value = $customer_satisfaction_dtl->commercial_flexibility;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category5_{{ $value }}" name="commercial_flexibility" value="{{ $value }}" class="star-checkbox" {{ $commercial_flexibility_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>How is the compliance and completeness of the supporting documents for the Invoice we submitted?</td>
                            @php
                                $commercial_compliance_value = $customer_satisfaction_dtl->commercial_compliance;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category6_{{ $value }}" name="commercial_compliance" value="{{ $value }}" class="star-checkbox" {{ $commercial_compliance_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h3 class="text-center">Remarks</h1>
                            </td>
                            <td colspan="11">
                                {{ $customer_satisfaction_dtl->commercial_aspect_remarks ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $nilai_average = ((($customer_satisfaction_dtl->commercial_level_alignment ?? '0')+($customer_satisfaction_dtl->commercial_flexibility ?? '0')+($customer_satisfaction_dtl->commercial_compliance ?? '0'))/3)*10
                            @endphp
                            <td colspan="2">
                                <h3>Average Survey</h1>
                            </td>
                            <td colspan="11">
                                {{ isset($nilai_average) ? $nilai_average . '%' : '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="inventory">
                <table>
                    <thead>
                        <tr>
                            <th colspan="13">Inventory Control / SCM / Receiving</th>
                        </tr>
                        <tr>
                            <th rowspan="3">No</th>
                            <th rowspan="3">Description Survey</th>
                            <th colspan="10">Category</th>
                        </tr>
                        <tr>
                            <th colspan="4" style="color: red">Unsatisfactory</th>
                            <th colspan="2" style="color:black">Fair</th>
                            <th colspan="2" style="color:blue">Good</th>
                            <th colspan="2" style="color:green">Excelent</th>
                        </tr>
                        <tr>
                            <!-- Kolom Category -->
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>What is the average accuracy of Delivery Material in relation to the due date of the Purchase Order?</td>
                            @php
                                $delivery_average_value = $customer_satisfaction_dtl->delivery_average;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category7_{{ $value }}" name="delivery_average" value="{{ $value }}" class="star-checkbox" {{ $delivery_average_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>What is the completeness of the documents provided by PT BBN during the material shipment?</td>
                            @php
                                $delivery_completeness_value = $customer_satisfaction_dtl->delivery_completeness;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category8_{{ $value }}" name="delivery_completeness" value="{{ $value }}" class="star-checkbox" {{ $delivery_completeness_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>What is the quality, safety, and neatness of the packing materials that PT BBN has been conducting during material shipments?</td>
                            @php
                                $delivery_packing_value = $customer_satisfaction_dtl->delivery_packing;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category9_{{ $value }}" name="delivery_packing" value="{{ $value }}" class="star-checkbox" {{ $delivery_packing_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h3 class="text-center">Remarks</h1>
                            </td>
                            <td colspan="11">
                                {{ $customer_satisfaction_dtl->delivery_material_remarks ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $nilai_average = ((($customer_satisfaction_dtl->delivery_average ?? '0')+($customer_satisfaction_dtl->delivery_completeness ?? '0')+($customer_satisfaction_dtl->delivery_packing ?? '0'))/3)*10
                            @endphp
                            <td colspan="2">
                                <h3 class="text-center">Average Survey</h1>
                            </td>
                            <td colspan="11">
                                {{ isset($nilai_average) ? $nilai_average . '%' : '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="QA">
                <table>
                    <thead>
                        <tr>
                            <th colspan="13">QA/QC</th>
                        </tr>
                        <tr>
                            <th rowspan="3">No</th>
                            <th rowspan="3">Description Survey</th>
                            <th colspan="10">Category</th>
                        </tr>
                        <tr>
                            <th colspan="4" style="color: red">Unsatisfactory</th>
                            <th colspan="2" style="color:black">Fair</th>
                            <th colspan="2" style="color:blue">Good</th>
                            <th colspan="2" style="color:green">Excelent</th>
                        </tr>
                        <tr>
                            <!-- Kolom Category -->
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                            <th>10</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>How compliant are the Materials sent with the PO specifications?</td>
                            @php
                                $product_compliant_value = $customer_satisfaction_dtl->product_compliant;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category10_{{ $value }}" name="product_compliant" value="{{ $value }}" class="star-checkbox" {{ $product_compliant_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>How complete/compliant are the Certificate documents and other supporting documents provided by BBN in relation to the PO requirements?</td>
                            @php
                                $product_certificate_value = $customer_satisfaction_dtl->product_certificate;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category11_{{ $value }}" name="product_certificate" value="{{ $value }}" class="star-checkbox" {{ $product_certificate_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Is the response and/or resolution action we have taken regarding complaints of nonconformity, both in terms of documents and materials, satisfactory?</td>
                            @php
                                $product_response_value = $customer_satisfaction_dtl->product_response;
                            @endphp
                            @foreach (range(1, 10) as $value)
                                <td>
                                    <input type="checkbox" id="category12_{{ $value }}" name="product_response" value="{{ $value }}" class="star-checkbox" {{ $product_response_value >= $value ? 'checked disabled' : '' }} disabled/>
                                                
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="2">
                                <h3 class="text-center">Remarks</h1>
                            </td>
                            <td colspan="11">
                                {{ $customer_satisfaction_dtl->product_quality_remarks ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            @php
                                $nilai_average = ((($customer_satisfaction_dtl->product_compliant ?? '0')+($customer_satisfaction_dtl->product_certificate ?? '0')+($customer_satisfaction_dtl->product_response ?? '0'))/3)*10
                            @endphp
                            <td colspan="2">
                                <h3 class="text-center">Average Survey</h1>
                            </td>
                            <td colspan="11">
                                {{ isset($nilai_average) ? $nilai_average . '%' : '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            window.print();
        });
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
    </script>
</body>
</html>