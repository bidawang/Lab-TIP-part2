<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjaman Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        @media print {
            #dataTableArea {
                display: none;
            }
            #printableArea {
                display: block;
            }
        }

        .table-responsive {
            margin-top: 1rem;
        }

        /* Menyesuaikan tabel untuk layar kecil */
        @media (max-width: 576px) {
            .table-responsive {
                font-size: 0.75rem; /* Menyesuaikan ukuran font */
            }

            .table-responsive th,
            .table-responsive td {
                padding: 0.5rem; /* Mengurangi padding untuk tabel pada layar kecil */
            }

            .table {
                width: 100%; /* Memastikan tabel mengisi lebar kontainer */
                display: block; /* Membuat tabel bisa digulirkan horizontal */
                overflow-x: auto; /* Menambahkan scrollbar horizontal jika diperlukan */
            }
        }

        /* Menata tombol */
        .button-group {
            display: flex;
            flex-wrap: wrap; /* Memungkinkan tombol berjejer ke bawah pada layar kecil */
            gap: 0.5rem;
        }

        .button-group .btn {
            flex: 1;
        }

        @media (min-width: 768px) {
            .button-group {
                justify-content: flex-end; /* Menjaga tombol lain di kanan pada layar besar */
            }

            .button-group .btn {
                width: auto;
            }

            .button-group .btn:first-child {
                margin-right: auto; /* Mengatur tombol "Kembali" tetap di kiri pada layar besar */
            }
        }
    </style>
</head>
@php
    // Mendapatkan alamat email pengguna yang sedang masuk
    $email = Auth::user()->email;
    
    // Memisahkan bagian nama dari alamat email
    $nameParts = explode('@', $email);
    
    // Mengonversi format nama: mengubah huruf pertama dari setiap kata menjadi huruf besar
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
@endphp

<body>
@include('auth.header')
@include('auth.headerbody')
@include('Laboran/sidebar.side')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Peminjaman Alat</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Alat</li>
                <li class="breadcrumb-item active">Peminjaman Alat</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @if (@session('success'))
            <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
    
                            <a href="{{ route('alat') }}" class="btn btn-danger mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
                            <a href="{{ route('talatpjm') }}" class="btn btn-info mt-3"><i class="bi bi-plus-circle"></i> Pinjam Alat</a>
                            <a href="{{ route('printalatpjm') }}" class="btn btn-success mt-3"><i class="bi bi-printer"></i> Print</a>

                        <!-- Table with stripped rows -->
                        <div id="printableArea" class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th><b>N</b>ama</th>
                                        <th>Alat</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alat as $data)
                                    <tr>
                                        <td>{{ $data->nama_peminjam }}</td>
                                        <td>{{ $data->nama_alat }}</td>
                                        <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->isoFormat('DD MMMM YYYY') }}</td>
                                        <td>{{ $data->status }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('auth.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
