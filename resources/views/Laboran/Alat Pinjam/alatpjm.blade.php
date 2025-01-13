<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjaman Alat</title>
</head>
@php
    $groupedData = $alat->groupBy('kode_alat_pinjam');
@endphp

<body>
@include('auth.header')
@include('auth.headerbody')
@include('Laboran/sidebar.side')

<main id="main" class="main">
    <div class="pagetitle">
        <h1 class="h4">Peminjaman Alat</h1>
        <nav>
            <ol class="breadcrumb small">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Alat</li>
                <li class="breadcrumb-item active">Peminjaman Alat</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        @if (@session('success'))
            <div id="alert" class="alert alert-success small" onclick="this.style.display='none'">
                {{ Session::get('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="{{ route('alat') }}" class="btn btn-danger btn-sm"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
                            <a href="{{ route('talatpjm') }}" class="btn btn-info btn-sm"><i class="bi bi-plus-circle"></i> Pinjam Alat</a>
                        </div>
                        <div class="accordion mt-3 small" id="faqAccordion">
                            
                        @foreach($groupedData as $kode_alat => $group)
    <div class="accordion-item small">
        <h2 class="accordion-header" id="heading{{ $kode_alat }}">
            <button class="accordion-button btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $kode_alat }}" aria-expanded="true" aria-controls="collapse{{ $kode_alat }}">
                <div class="small">
                    {{ $kode_alat }} ({{ count($group) }} Data)
                </div>
            </button>
        </h2>
        <div id="collapse{{ $kode_alat }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $kode_alat }}" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
                <!-- Menampilkan Tanggal -->
                @php
                    $tanggal_pemakaian = \Carbon\Carbon::parse($group->first()->tanggal_pemakaian)->isoFormat('DD MMMM YYYY');
                @endphp
                <div class="mb-2">
                    <strong>{{ $tanggal_pemakaian }}</strong>
                </div>

                <!-- Tabel Data -->
                <table class="table table-sm table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Alat</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->nama_alat }}</td>
                                <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
                                <td>{{ $data->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Tombol Print -->
                @php
                    // Cek apakah semua status dalam grup adalah "Diterima"
                    $allAccepted = $group->every(function($item) {
                        return $item->status === 'Disetujui';
                    });
                @endphp
                @if($allAccepted)
                    <div class="text-end mt-2">
                        <a href="{{ route('printalatpjm', ['kode_alat_pinjam' => $kode_alat]) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-printer me-2"></i> Print
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach

</div>



                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('auth.footer')
</body>
</html>
