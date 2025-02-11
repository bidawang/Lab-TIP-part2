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
                <!-- Peminjaman Alat Tab -->
                <div class="tab-pane fade show active profile-overview" id="mahasiswa">
                  <table class="table table-striped datatable">
                    <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($groupedAlatPinjam as $name => $group)
                        <tr>
                          <td>{{ $name }}</td>
                          <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal_{{ Str::slug($name) }}">Detail</button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                
                <!-- Pemakaian Bahan Tab -->
                <div class="tab-pane fade profile-overview" id="Laboran">
                  <table class="table table-striped datatable">
                    <thead>
                      <tr>
                        <th>Nama Pemakai</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($groupedBahanPakai as $name => $group)
                        <tr>
                          <td>{{ $name }}</td>
                          <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal_{{ Str::slug($name) }}">Detail</button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                
                <!-- Peminjaman Ruangan Tab -->
                <div class="tab-pane fade profile-overview" id="dosen">
                  <table class="table table-striped datatable">
                    <thead>
                      <tr>
                        <th>Nama Peminjam</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($groupedPinjamRuangan as $name => $group)
                        <tr>
                          <td>{{ $name }}</td>  
                          <td>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal_{{ Str::slug($name) }}">Detail</button>
                          </td>
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

  <!-- Modals for Detail -->
  @foreach($groupedAlatPinjam as $name => $group)
    <div class="modal fade" id="detailModal_{{ Str::slug($name) }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg class -->        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel">Detail Peminjaman Alat - {{ $name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Search input for modal -->
            <input type="text" class="form-control mb-3" id="searchModal_{{ Str::slug($name) }}" placeholder="Search...">
            <table class="table table-striped" id="tableModal_{{ Str::slug($name) }}">
              <thead>
                <tr>
                  <th>Nama</th>
                  <th>Barang</th>
                  <th>Jumlah</th>
                  <th>Tempat</th>
                  <th>Status</th>
                  <th>Tanggal Kembali</th>
                </tr>
              </thead>
              <tbody>
                @foreach($group as $data)
                  <tr>
                    <td>{{ $data->nama_peminjam }}</td>
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
        </div>
      </div>
    </div>
  @endforeach

  @foreach($groupedBahanPakai as $name => $group)
    <div class="modal fade" id="detailModal_{{ Str::slug($name) }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg class -->        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel">Detail Pemakaian Bahan - {{ $name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Search input for modal -->
            <input type="text" class="form-control mb-3" id="searchModal_{{ Str::slug($name) }}" placeholder="Search...">
            <table class="table table-striped" id="tableModal_{{ Str::slug($name) }}">
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
                @foreach($group as $data)
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
        </div>
      </div>
    </div>
  @endforeach

  @foreach($groupedPinjamRuangan as $name => $group)
    <div class="modal fade" id="detailModal_{{ Str::slug($name) }}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Added modal-lg class -->
              <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailModalLabel">Detail Peminjaman Ruangan - {{ $name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- Search input for modal -->
            <input type="text" class="form-control mb-3" id="searchModal_{{ Str::slug($name) }}" placeholder="Search...">
            <table class="table table-striped" id="tableModal_{{ Str::slug($name) }}">
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
                @foreach($group as $data)
                  <tr>
                    <td>{{ $data->nama_peminjam }}</td>
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
  @endforeach

  <script>
    // Search function inside modal
    document.addEventListener('DOMContentLoaded', function() {
      const modals = document.querySelectorAll('.modal');
      modals.forEach(function(modal) {
        const searchInput = modal.querySelector('.form-control');
        const table = modal.querySelector('table');
        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function() {
          const query = searchInput.value.toLowerCase();
          rows.forEach(function(row) {
            const cells = row.querySelectorAll('td');
            let match = false;
            cells.forEach(function(cell) {
              if (cell.textContent.toLowerCase().includes(query)) {
                match = true;
              }
            });
            row.style.display = match ? '' : 'none';
          });
        });
      });
    });
  </script>
</body>
</html>
