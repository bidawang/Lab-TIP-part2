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
    <h1>Pembelian</h1>
    <nav>
      <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Print Pembelian</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  
  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <a href="{{ route('beli')}}" class="btn btn-danger mt-3 mb-3">Kembali</a>
            <button onclick="window.print()" class="btn btn-success mt-3 mb-3"><i class="bi bi-printer"></i> Print</button>
            
            <form action="{{ route('search') }}" method="GET" class="mb-4">
              <div class="row">
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
                <div class="form-group col-lg-3">
                  <label for="jenis">Jenis:</label>
                  <select class="form-control" id="jenis" name="jenis">
                    <option value="all" {{ old('jenis', isset($jenis) ? $jenis : '') == 'all' ? 'selected' : '' }}>Semua</option>
                    <option value="bahan" {{ old('jenis', isset($jenis) ? $jenis : '') == 'bahan' ? 'selected' : '' }}>Bahan</option>
                    <option value="alat" {{ old('jenis', isset($jenis) ? $jenis : '') == 'alat' ? 'selected' : '' }}>Alat</option>
                  </select>
                </div>
                <div class="col-lg-2">           
                  <button type="submit" class="btn btn-primary mt-4"><i class="bi bi-search"></i> Cari</button>
                </div>
              </div>
            </form>

            <div class="printable-area">
              @isset($startDate)
              <h4>Rekap Pembelian <br> {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</h4>
              @endisset
              <h4>{{ $formattedName}}</h4>
              <table class="table table-bordered mt-4">
                <thead>
                  <tr>
                    <th>Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody class="text-center">
                  @php
                    $totalHarga = 0; // inisialisasi variabel total harga
                  @endphp
                  @foreach($beli as $data)
                    <tr>
                      <td>{{ $data->nama_barang }}</td>
                      <td>Rp. {{ number_format($data->harga, 0, ',', '.') }}</td>
                      <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
                      <td>{{ \Carbon\Carbon::parse($data->created_at)->isoFormat('DD MMMM YYYY') }}</td>
                      <td>{{ $data->jenis }}</td>
                      <td>Rp. {{ number_format($data->harga * $data->jumlah, 0, ',', '.') }}</td>
                    </tr>
                    @php
                      $totalHarga += $data->harga * $data->jumlah; // menambahkan total harga
                    @endphp
                  @endforeach
                  <tr>
                    <td colspan="5" class="text-right"><strong>Total Harga:</strong></td>
                    <td>Rp. {{ number_format($totalHarga, 0, ',', '.') }}</td>
                  </tr>
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

</body>
</html>
