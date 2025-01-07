<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Surat</title>
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
                padding: 0.3rem; /* Mengurangi padding untuk tabel pada layar kecil */
            }

            .table {
                width: 100%; /* Memastikan tabel mengisi lebar kontainer */
                display: block; /* Membuat tabel bisa digulirkan horizontal */
                overflow-x: auto; /* Menambahkan scrollbar horizontal jika diperlukan */
            }
        }

        /* Menata tombol untuk responsivitas */
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
                justify-content: flex-end;
            }

            .button-group .btn {
                width: auto;
            }
        }
    </style>
</head>
@php
    $email = Auth::user()->email;
    $nameParts = explode('@', $email);
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
    use Carbon\Carbon;
@endphp
<body>
@include('auth.header')
@include('auth.headerbody')
@include('Laboran/sidebar.side')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Kelola Surat</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Ruangan</li>
                <li class="breadcrumb-item active">Kelola Surat</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @if (@session('message'))
            <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                {{ Session::get('message') }}
            </div>
        @endif 

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                            <!-- Button Kembali di kiri -->
                            <a href="{{ route('ruang') }}" class="btn btn-danger mb-2">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <div class="col-12">
                                <a href="{{ route('truangpjm') }}" class="btn btn-info">
                                    <i class="bi bi-plus-circle"></i> Tambah Surat
                                </a>
                                {{-- <a href="javascript:void(0);" onclick="printTable();" class="btn btn-success">
                                    <i class="bi bi-printer"></i> Print Riwayat Peminjaman
                                </a> --}}
                                <a href="{{ route('printruangpjm')}}" class="btn btn-success">
                                    <i class="bi bi-printer"></i> Print Perizinan
                                </a>
                            </div>
                        <!-- Table with stripped rows -->
                        <div id="printableArea" class="table-responsive">
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Ruangan</th>
                                        <th>Pembuatan Surat</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Waktu</th>
                                        <th>Keperluan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ruang_pinjam as $data)
                                        @if($data->google_id == auth::user()->google_id)
                                            <tr>
                                                <td>{{ $data->nama_ruangan }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->format('d F Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->jam_mulai)->format('H.i') }} - {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H.i') }}</td>
                                                <td>{{ $data->keperluan }}</td>
                                            </tr>
                                        @endif
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

<script>
function printTable() {
    var printContents = document.getElementById('printableArea').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

<!-- Modal Edit -->
@foreach($ruang_pinjam as $data)
<div class="modal fade" id="editModal{{ $data->id_ruangan }}" tabindex="-1" aria-labelledby="editModal{{ $data->id_ruangan }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal{{ $data->id_ruangan }}Label">Edit Ruangan {{ $data->nama_ruangan }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('ubah', ['id' => $data->id_pinjam_ruangan]) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nama_peminjam" value="{{ $formattedName }}">
                    <input type="hidden" name="status" value="tunggu">
                    <input type="hidden" value="{{ $data->id_pinjam_ruangan }}" name="id_pinjam_ruangan">

                    <div class="mb-3">
                        <label for="nama_ruangan" class="form-label">Nama Ruangan</label>
                        <input type="text" id="nama_ruangan" name="nama_ruangan" value="{{ $data->nama_ruangan }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                        <input type="text" id="mata_kuliah" name="mata_kuliah" value="{{ $data->mata_kuliah }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_peminjaman" class="form-label">Tanggal Pinjam</label>
                        <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman" value="{{ $data->tanggal_peminjaman }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" value="{{ $data->jam_mulai }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" value="{{ $data->jam_selesai }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan</label>
                        <textarea class="form-control" id="keperluan" name="keperluan" style="height: 100px;">{{ $data->keperluan }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

</body>
</html>
