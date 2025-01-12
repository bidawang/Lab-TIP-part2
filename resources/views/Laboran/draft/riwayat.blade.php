@include('auth.header')

<body>
  @include('auth.headerbody')
  @include('Laboran/sidebar.side')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Riwayat Peminjaman</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Riwayat Peminjaman</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section profile">
      <div class="row">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">
                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mahasiswa">Peminjaman Alat</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Laboran">Pemakaian Bahan</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dosen">Peminjaman Ruangan</button>
                </li>
              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-overview" id="mahasiswa">
                  <table class="table datatable">
                    <thead>
                      <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Tempat</th>
                        <th>Status</th>
                        <th>Tanggal Kembali</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($alat_pinjam as $data)
                      <tr>
                        <td>{{ $data->nama_alat }}</td>
                        <td>{{ $data->jumlah }}</td>
                        <td>{{ $data->tempat_peminjaman }}</td>
                        <td>{{ $data->status }}</td>
                        <td>{{ $data->tanggal_kembali }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade profile-overview" id="Laboran">
                  <table class="table datatable">
                    <thead>
                      <tr>
                        <th>Nama Pemakai</th>
                        <th>Nama Bahan</th>
                        <th>Tanggal Pemakaian</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($bahan_pakai as $data)
                      <tr>
                        <td>{{ $data->nama_pemakai }}</td>
                        <td>{{ $data->nama_bahan }}</td>
                        <td>{{ $data->tanggal_pemakaian }}</td>
                        <td>{{ $data->jumlah }}</td>
                        <td>{{ $data->satuan }}</td>
                        <td>{{ $data->status }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade profile-overview" id="dosen">
                  <table class="table datatable">
                    <thead>
                      <tr>
                        <th>Nama Peminjam</th>
                        <th>Nama Ruangan</th>
                        <th>Waktu</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Penanggungjawab</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
    @foreach($pinjam_ruangan as $data)
        @php
            // Pecah email menjadi nama yang diformat
            $nameParts = explode('@', $data->email ?? 'unknown@example.com');
            $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
        @endphp
        <tr>
            <!-- Tampilkan nama pengguna yang diformat -->
            <td>{{ $formattedName }}</td>
            <td>{{ $data->nama_ruangan }}</td>
            <td>{{ $data->jam_mulai }} - {{ $data->jam_selesai }}</td>
            <td>{{ $data->tanggal_peminjaman }}</td>
            <td>{{ $data->penanggungjawab }}</td>
            <td>{{ $data->status }}</td>
        </tr>
    @endforeach
</tbody>

                  </table>
                </div>
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
