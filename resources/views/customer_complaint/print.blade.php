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
        }

        .center-align {
            text-align: center; /* Menyelaraskan teks ke tengah */
        }
        .tandaTangan {
            text-align: right; /* Menyelaraskan teks ke tengah */
        }
        .subJudul {
            background-color: #EDEDED;
        }
        .padding-bottom {
            padding-bottom: 70px; /* Atur sesuai dengan kebutuhan */
        }
        .padding-lampiran {
            padding-bottom: 280px; /* Atur sesuai dengan kebutuhan */
        }
        .images-container {
            text-align: center; /* Memusatkan gambar secara horizontal */
        }
        .print-img {
            width: 55%; 
            max-width: 100%; 
            display: block; 
            margin-left: auto; 
            margin-right: auto;
            padding: 5px;
        }
        @media print {
            table {
                width: 100%;
                border: none;
            }
            img {
                display: block;
                margin-left: auto;
                margin-right: auto;
            }

            .center-align {
                text-align: center; /* Menyelaraskan teks ke tengah */
            }
            
            .tandaTangan {
                text-align: right; /* Menyelaraskan teks ke tengah */
            }

            .subJudul {
                background-color: #EDEDED !important;
            }
            .padding-bottom {
                padding-bottom: 110px; /* Atur sesuai dengan kebutuhan */
            }
            .padding-lampiran {
                padding-bottom: 280px; /* Atur sesuai dengan kebutuhan */
            }
            .images-container {
                text-align: center; /* Memusatkan gambar secara horizontal */
            }
            .print-img {
                width: 55%; 
                max-width: 100%; 
                display: block; 
                margin-left: auto; 
                margin-right: auto;
                padding: 5px;
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
            <table>
                <tbody>
                    <tr>
                        <td rowspan="2" width="15%" class="center-align"><img width="50%" src="{{ url('') }}/assets/images/LogoBBN.png" alt=""></td>
                        <td class="center-align"><b>Customer Complain</b></td>
                        <td width="25%">No : {{ $customer_complaint->complaint_no }}</td>
                    </tr>
                    <tr>
                        <td class="center-align">FORMULIR KELUHAN PELANGGAN</td>
                        <td width="25%">DATE : {{ $customer_complaint->created_at->format('d m Y') }}</td>
                    </tr>
                </tbody>
            </table> 
        </div>
        <div class="dataPelanggan">
            <table>
                <tbody>
                    <tr>
                        <td colspan="3" class="subJudul"><b>The Details</b> <br> (Rincian)</td>
                    </tr>
                    <tr>
                        <td><b>Customer Name</b> (Nama Pelanggan)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->customer }}</td>
                    </tr>
                    <tr>
                        <td><b>Tel/Fax No.</b> (Telp)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->telp_fax }}</td>
                    </tr>
                    <tr>
                        <td><b>Mobile No</b> (No HP)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->phone }}</td>
                    </tr>
                    <tr>
                        <td><b>Email Address</b> (Alamat Email)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->email }}</td>
                    </tr>
                    <tr>
                        <td><b>Person Contacted</b> (Orang yang dihubungi)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->personal_name }}</td>
                    </tr>
                    <tr>
                        <td><b>Title</b> (Jabatan)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->title }}</td>
                    </tr>
                    <tr>
                        <td><b>Purchase Order No & Date</b> (No. Pesanan Pembelian & Tanggal)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->po_dan_date }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="subJudul"><b>Category</b> <br> (Kategori)</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            @foreach ($customer_complaint_category as $cpc)
                                <div class="col-md-6">
                                    <div class="c-inputs-stacked">
                                        <input type="checkbox" id="checkbox_{{ $loop->index + 1 }}_{{ $cpc->id }}" name="category[]" checked disabled>
                                        <label for="checkbox_{{ $loop->index + 1 }}_{{ $cpc->id }}" class="me-30">{{ $cpc->category_name }}</label>
                                        @if ($cpc->category_name == 'others')
                                            <div class="type-form">
                                                <div id="type-form-{{ $loop->index + 1 }}">
                                                    <input type="text" class="form-control ps-15" name="category_other" placeholder="Input Other Category" value="{{ old('category_other') }}" {{ $cpc->checked ? '' : 'disabled' }}>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                    {{-- the issue --}}
                    <tr>
                        <td colspan="3" class="subJudul"><b>The Issue</b> <br> (Masalah)</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="padding-bottom">{{ $customer_complaint->description }}</td>
                    </tr>
                    {{-- File Lampiran --}}
                    <tr>
                        <td colspan="3" class="subJudul"><b>File Lampiran</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="padding-lampiran">
                            @foreach ($customer_complaint_file as $cpf)
                                <a href="{{ url('upload/customer_complaint/lampiran')}}/{{ $cpf->file_lampiran }}" target="__blank">
                                    <p>{{ $cpf->file_lampiran }}</p>
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    {{-- Foto Lampiran --}}
                    <tr>
                        <td colspan="3" class="subJudul"><b>Foto Lampiran</b></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="padding-bottom">
                            @foreach ($customer_complaint_file as $cpf)
                                <img width="30%" class="print-img" src="{{ url('upload/customer_complaint/foto')}}/{{ $cpf->foto_lampiran }}" alt="">
                            @endforeach
                        </td>
                    </tr>
                    {{-- complaint resolved by --}}
                    <tr>
                        <td colspan="3" class="subJudul"><b>Complaints Resolved by</b> <br> (Resolusi keluhan)</td>
                    </tr>
                    <tr>
                        <td><b>Complain Received by</b> (keluhan diterima oleh)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->received_by }}</td>
                    </tr>
                    <tr>
                        <td><b>Date Received</b> (Tanggal Diterima)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->received_date }}</td>
                    </tr>
                    <tr>
                        <td><b>Complaints Resolved By</b> <br> (Keluhan diselesaikan oleh )</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->resolved_by }}</td>
                    </tr>
                    <tr>
                        <td><b>Title</b> (Jabatan)</td>
                        <td>:</td>
                        <td>{{ $customer_complaint->resolved_title }}</td>
                    </tr>
                    <tr>
                        <td><b>Action Taken</b> (Tindakan yang Diambil)</td>
                        <td>:</td>
                        <td class="padding-bottom">{{ $customer_complaint->action_taken }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="tandaTangan">
                            <p><b>Autorized Signature</b></p>
                            <p style="margin-bottom: 15%"></p>
                            <p><b>Indria Kusumawati</b></p>
                        </td>
                    </tr>
                </tbody>
            </table>
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