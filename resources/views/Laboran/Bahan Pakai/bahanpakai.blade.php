<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemakaian Bahan</title>
</head>

@php
    $groupedData = $bahan_pakai->groupBy('kode_bahan_pakai');
@endphp

<body>
    @include('auth.header')
    @include('auth.headerbody')
    @include('Laboran/sidebar.side')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Pemakaian Bahan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                    <li class="breadcrumb-item active">Bahan</li>
                    <li class="breadcrumb-item active">Pemakaian Bahan</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            @if(session('success'))
                <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                    {{ session('success') }}
                </div>
            @endif 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <a href="{{ route('bahan') }}" class="btn btn-danger btn-sm mt-3">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <a href="{{ route('tambah_pemakaian') }}" class="btn btn-info btn-sm mt-3">
                                <i class="bi bi-plus-circle"></i> Pemakaian
                            </a>
                        </div>

                            <div class="accordion mt-3 small" id="faqAccordion">
                                @foreach($groupedData as $kode_bahan => $group)
                                    <div class="accordion-item small mt-2">
                                        <h2 class="accordion-header" id="heading{{ $kode_bahan }}">
                                            <button class="accordion-button btn-small" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $kode_bahan }}" aria-expanded="true" aria-controls="collapse{{ $kode_bahan }}">
                                                <div class="d-flex justify-content-between small">
                                                    <span class="small">{{ $kode_bahan }} ({{ count($group) }} Data)</span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $kode_bahan }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $kode_bahan }}" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body">
                                            @php
                        $tanggal_peminjaman = \Carbon\Carbon::parse($group->first()->tanggal_peminjaman)->isoFormat('DD MMMM YYYY');
                    @endphp
                    <div class="mb-2">
                        <strong>{{ $tanggal_peminjaman }}</strong> 
                    </div>
                                            <table class="table table-sm table-bordered align-middle text-center">
                                            <thead class="thead-light">
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Bahan</th>
                                                            <th>Jumlah</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($group as $data)
                                                            @if($data->google_id == Auth::user()->google_id)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $data->nama_bahan }}</td>
                                                                    <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
                                                                    <td>{{ $data->status }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                <div class="text-end mt-2">
                        <a href="{{ route('printbah', ['kode_bahan_pakai' => $kode_bahan]) }}" class="btn btn-success btn-sm">
                            <i class="bi bi-printer me-2"></i> Print
                        </a>
                    </div>
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
