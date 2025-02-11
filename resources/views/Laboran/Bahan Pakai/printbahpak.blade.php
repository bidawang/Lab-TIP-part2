<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Print Pemakaian Bahan</title>
</head>

@php
    // Mendapatkan nama pengguna dari email
    $email = Auth::user()->email;
    $nameParts = explode('@', $email);
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));

    // Ambil tanggal pemakaian dari data pertama (diasumsikan sama untuk semua dalam grup)
    $tanggalPemakaian = $bahanpjm->where('status', 'Disetujui')->first()->tanggal_pemakaian ?? null;
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
                    <li class="breadcrumb-item active">Print Pemakaian Bahan</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('bahan_pakai') }}" class="btn btn-danger mt-3">
                                <i class="bi bi-arrow-left-circle"></i> Kembali
                            </a>
                            <button onclick="window.print()" class="btn btn-success mt-3">
                                <i class="bi bi-printer"></i> Print
                            </button>

                            <div class="printable-area">
                                <h5 class="mt-4">Tanggal: {{ \Carbon\Carbon::parse($tanggalPemakaian)->isoFormat('DD MMMM YYYY') }}</h5>
                                <h6 class="mt-2">{{ $formattedName }}</h6>

                                <table class="table table-bordered table-striped mt-4">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Nama Bahan</th>
                                            <th scope="col">Jumlah</th>
                                            <th scope="col">Sisa Stok</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $groupedAlatpjm = $bahanpjm->where('status', 'Disetujui')->groupBy('nama_bahan')->map(function ($group) {
                                                return (object) [
                                                    'nama_bahan' => $group->first()->nama_bahan,
                                                    'jumlah' => $group->sum('jumlah'),
                                                    'satuan' => $group->first()->satuan,
                                                    'google_id' => $group->first()->google_id,
                                                ];
                                            });
                                        @endphp

                                        @foreach($groupedAlatpjm as $data)
                                            @if (session('level') != 'Mahasiswa' || (session('level') == 'Mahasiswa' && $data->google_id == Auth::user()->google_id))
                                                <tr>
                                                    <td>{{ $data->nama_bahan }}</td>
                                                    <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
                                                    <td>
                                                        @php
                                                            $stokBahan = \App\Models\mdlBahan::where('nama_bahan', $data->nama_bahan)->first();
                                                        @endphp
                                                        {{ $stokBahan ? $stokBahan->stok . ' ' . $stokBahan->satuan : 'Stok tidak tersedia' }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>

                                <h6 class="mt-3">Keperluan: {{ $bahanpjm->first()->keperluan ?? 'Tidak ada keperluan yang tercantum' }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('auth.footer')

    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .printable-area, .printable-area * {
                visibility: visible;
            }
            .printable-area {
                left: 0;
                top: 0;
                width: 100%;
                padding: 0;
            }
            .btn, .breadcrumb {
                display: none;
            }
        }
    </style>
</body>

</html>
