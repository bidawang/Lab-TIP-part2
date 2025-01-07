@include('auth.header')
@php
    // Mendapatkan alamat email pengguna yang sedang masuk
    $email = Auth::user()->email;
    
    // Memisahkan bagian nama dari alamat email
    $nameParts = explode('@', $email);
    
    // Mengonversi format nama: mengubah huruf pertama dari setiap kata menjadi huruf besar
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
@endphp
<body>
@include('auth.headerbody')
@include('Laboran/sidebar.side')

<main id="main" class="main">
  
  <div class="pagetitle">
    <h1>Peminjaman Alat</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Alat</li>
          <li class="breadcrumb-item active">Print Peminjaman Alat</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <a href="{{ route('alatpjm')}}" class="btn btn-danger mt-3 mb-2"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
            <button onclick="window.print()" class="btn btn-success mt-3 mb-2"><i class="bi bi-printer"></i> Print</button>
            
            <form action="{{ route('searchalat') }}" method="GET">
              <div class="row mb-3">
                  <div class="form-group col-lg-2">
                      <label for="start_date">Tanggal Mulai:</label>
                      <input type="date" class="form-control" id="start_date" name="start_date" 
                             value="{{ old('start_date', isset($startDate) ? $startDate : '') }}">
                  </div>
                  <div class="form-group col-lg-2">
                      <label for="end_date">Tanggal Selesai:</label>
                      <input type="date" class="form-control" id="end_date" name="end_date" 
                             value="{{ old('end_date', isset($endDate) ? $endDate : '') }}">
                  </div>
                  <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-search"></i> Cari</button>
                  </div>
              </div>
            </form>

            <div class="printable-area">
              <h4>{{ $startDate }} - {{ $endDate }}</h4>
              <h5>{{ $formattedName }}</h5>
              <table class="table table-bordered table-striped mt-4">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Alat</th>
                        <th scope="col">Stok Awal</th>
                        <th scope="col">Stok Sisa</th>
                        <th scope="col">Total Pemakaian</th>
                        <th scope="col">Waktu</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                    // Group the items by name and sum their quantities
                    $groupedAlatpjm = $alatpjm->where('status', 'Disetujui')->groupBy('nama_alat')->map(function ($group) {
                        return [
                            'nama_alat' => $group->first()->nama_alat,
                            'jumlah' => $group->sum('jumlah'),
                            'satuan' => $group->first()->satuan,
                            'tanggal_peminjaman' => $group->first()->tanggal_peminjaman,
                            'alat' => $group->first()->alat,
                        ];
                    });
                  @endphp

                  @foreach($groupedAlatpjm as $data)
                    @if (session('level') != 'Mahasiswa')
                        <tr>
                            <td>{{ $data['nama_alat'] }}</td>
                            <td>
                                @if ($data['alat'])
                                    {{ $data['jumlah'] + $data['alat']->stok }} {{ $data['satuan'] }}
                                @else
                                    {{ $data['jumlah'] }} {{ $data['satuan'] }} (Stok tidak tersedia)
                                @endif
                            </td>
                            <td>
                                @if ($data['alat'])
                                    {{ $data['alat']->stok }} {{ $data['alat']->satuan }}
                                @else
                                    Stok tidak tersedia (Alat BMN)
                                @endif
                            </td>
                            <td>{{ $data['jumlah'] }} {{ $data['satuan'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($data['tanggal_peminjaman'])->isoFormat('DD MMMM YYYY') }}</td>
                        </tr>
                    @endif
                  @endforeach
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
</main>

@include('auth.footer')

<!-- Tambahkan CSS khusus untuk tampilan cetak -->
<style>
  @media print {
    body * {
      visibility: hidden;
    }
    .printable-area, .printable-area * {
      visibility: visible;
    }
    .printable-area {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
      padding: 0;
    }
    .btn, .breadcrumb, form {
      display: none;
    }
  }
</style>

</body>
</html>
