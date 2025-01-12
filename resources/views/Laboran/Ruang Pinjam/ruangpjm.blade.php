@include('auth.header')
<body>
  @include('auth.headerbody')
  @include('Laboran/sidebar.side')


<main id="main" class="main small">
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
<div class="col-12 mt-3 mb-3">
                        <a href="{{ route('ruang') }}" class="btn btn-danger btn-sm"><i class="bi bi-arrow-left-circle"></i> Kembali
                        </a>
                            <a href="{{ route('truangpjm') }}" class="btn btn-sm btn-info">
                                <i class="bi bi-plus-circle"></i> Tambah Surat
                            </a>
                        </div>

                        <!-- Search Input -->
                        <input id="searchInput" type="text" class="form-control search-input" placeholder="Cari Ruangan...">

                        <!-- Table with stripped rows -->
                        <div id="printableArea" class="table-responsive">
                            <table class="table table-sm table-bordered table-striped align-middle text-center">
                                <thead class="small align-middle">
                                    <tr>
                                        <th>Ruangan</th>
                                        <th>Pembuatan Surat</th>
                                        <th>Action</th> <!-- Kolom gabungan untuk Status dan Print -->
                                    </tr>
                                </thead>
                                <tbody class="text-center small" id="tableBody">
                                    @foreach($ruang_pinjam as $data)
                                        @if($data->google_id == auth::user()->google_id)
                                            <tr>
                                                <td>{{ $data->nama_ruangan }}</td>
                                                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d F Y') }}</td>
                                                <td>
                                                    @if($data->status == 'tunggu')
                                                        <span class="badge bg-warning">Tunggu</span>
                                                    @elseif($data->status == 'Ditolak')
                                                        <span class="badge bg-danger">Tolak</span>
                                                    @elseif($data->status == 'Disetujui')
                                                    
                                                        <a href="{{ route('printruangpjm', ['id' => $data->id_pinjam_ruangan]) }}" class="btn btn-success btn-sm">
                                                            <i class="bi bi-printer"></i>
                                                        </a>
                                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $data->id_pinjam_ruangan }}">
                                                            <i class="bi bi-info-circle"></i>
                                                        </button>
                                                    @endif
                                                </td>
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

<!-- Modal Detail -->
@foreach($ruang_pinjam as $data)
<div class="modal fade small" id="detailModal{{ $data->id_pinjam_ruangan }}" tabindex="-1" aria-labelledby="detailModal{{ $data->id_pinjam_ruangan }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="detailModal{{ $data->id_pinjam_ruangan }}Label">Detail Peminjaman Ruangan</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        @php
                        // Mendapatkan alamat email pengguna yang sedang masuk
                        $email = Auth::user()->email;
                        // Memisahkan bagian nama dari alamat email
                        $nameParts = explode('@', $email);
                        // Mengonversi format nama: mengubah huruf pertama dari setiap kata menjadi huruf besar
                        $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
                        @endphp
                        <h6 class="card-title text-center mb-3">{{ $data->nama_ruangan }}</h6>
                        <p><strong>Mata Kuliah:</strong><br>{{ $data->mata_kuliah }}</p>
                        <p><strong>Tanggal Peminjaman:</strong><br>{{ \Carbon\Carbon::parse($data->tanggal_peminjaman)->format('d F Y') }}</p>
                        <p><strong>Jam:</strong><br>{{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') }}</p>
                        <p><strong>Keperluan:</strong><br>{{ $data->keperluan }}</p>
                        <p><strong>Status:</strong><br>
                            @if($data->status == 'tunggu')
                            <span class="badge bg-warning text-dark">Tunggu</span>
                            @elseif($data->status == 'Ditolak')
                            <span class="badge bg-danger">Tolak</span>
                            @elseif($data->status == 'Disetujui')
                            <span class="badge bg-success">Disetujui</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- JS Script for Search Functionality -->
<script>
    document.getElementById("searchInput").addEventListener("keyup", function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#tableBody tr");

        rows.forEach(row => {
            const cells = row.getElementsByTagName("td");
            const roomName = cells[0].textContent.toLowerCase();
            const createdDate = cells[1].textContent.toLowerCase();

            if (roomName.includes(filter) || createdDate.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>

</body>
</html>
