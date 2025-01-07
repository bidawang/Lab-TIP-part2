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
    <h1>Pemakaian Bahan</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Print Pemakaian Bahan</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <a href="{{ route('bahan_pakai')}}" class="btn btn-danger mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
            <button onclick="window.print()" class="btn btn-success mt-3"><i class="bi bi-printer"></i> Print</button>
            
            <form action="{{ route('searchbahan') }}" method="GET">
              <div class="row mb-3 mt-3">
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
                    <button type="submit" class="btn btn-primary mt-4"><i class="bi bi-search"></i> Cari</button>
                  </div>
              </div>
            </form>

            <div class="printable-area">
              <h4>{{ $startDate }} - {{ $endDate }}</h4>
              <h5>{{ $formattedName }}</h5>
              <table class="table table-bordered table-striped mt-4">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nama Bahan</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Sisa Stok</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Keperluan</th>
                    </tr>
                </thead>
                <tbody>
                  @php
                    // Group the items by name and sum their quantities
                    $groupedAlatpjm = $bahanpjm->where('status', 'Disetujui')->groupBy('nama_bahan')->map(function ($group) {
                        return (object) [
                            'nama_bahan' => $group->first()->nama_bahan,
                            'jumlah' => $group->sum('jumlah'),
                            'satuan' => $group->first()->satuan,
                            'tanggal_pemakaian' => $group->first()->tanggal_pemakaian,
                            'keperluan' => $group->first()->keperluan,
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
                                    // Mengambil stok bahan berdasarkan nama bahan
                                    $stokBahan = \App\Models\mdlBahan::where('nama_bahan', $data->nama_bahan)->first();
                                @endphp

                                @if ($stokBahan)
                                    {{ $stokBahan->stok }} {{ $stokBahan->satuan }}
                                @else
                                    Stok tidak tersedia
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($data->tanggal_pemakaian)->isoFormat('DD MMMM YYYY') }}</td>
                            <td>{{ $data->keperluan }}</td>
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
