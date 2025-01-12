@include('auth.header')
@php
    $email = Auth::user()->email;
    $nameParts = explode('@', $email);
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
@endphp

<body>
    @include('auth.headerbody')
    @include('Laboran/sidebar.side')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Bahan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                    <li class="breadcrumb-item active">Bahan</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            @if (@session('success'))
                <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                    {{ Session::get('success') }}
                </div>
            @endif
            @if (@session('danger'))
                <div id="alert" class="alert alert-danger" onclick="this.style.display='none'">
                    {{ Session::get('danger') }}
                </div>
            @endif
            @if (@session('warning'))
                <div id="alert" class="alert alert-warning" onclick="this.style.display='none'">
                    {{ Session::get('warning') }}
                </div>
            @endif

            <div class="row">
                <div class="col-lg-12 mb-3">
                    @if (session('level') != 'Mahasiswa')
                        <a href="{{ route('tbahan') }}" class="btn btn-sm btn-primary mt-3"><i class="bi bi-plus-circle"></i>
                            Bahan</a>
                    @endif

                    @if (is_null(session('NIM')) || is_null(session('semester')) || is_null(session('no_hp')))
                        <h4 class="breadcum-item">Silahkan lengkapi profil anda terlebih dahulu</h4>
                    @else
                        <a href="{{ route('bahan_pakai') }}" class="btn btn-sm btn-info text-muted mt-3"><i
                                class="bi bi-file-earmark-plus-fill"></i> Pakai Bahan</a>
                    @endif
                    
                        <input type="text" id="searchInput" onkeyup="filterTable()" class="form-control mt-3" placeholder="Cari...">

                </div>
            </div>

            <div id="noDataFound" style="display: none;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card custom-border">
                            <div class="card-body">
                                <center>
                                    <h1><b>DATA TIDAK DITEMUKAN</b></h1>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel Data -->
            <table id="bahanTable" class="table table-hover table-sm small align-middle text-center">
                <thead>
                    <tr>
                        <th>Bahan</th>
                        <th>Jumlah</th>
                        <th>Action</th>
                    </tr>
                </thead> 
                <tbody>
                    @foreach ($bahan as $data)
                        <tr class="filtered-item">
                            
                            <td class="small">{{ $data->nama_bahan }}</td>
                            <td class="small">{{ $data->stok }} {{ $data->satuan }}</td>
                            <td class="small">
                                @if (session('level') != 'Mahasiswa')
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#editModal{{ $data->id_bahan }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="/bahan/hapus" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id_bahan" value="{{ $data->id_bahan }}">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                @endif
                                <!-- Button Detail -->
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#detailModal{{ $data->id_bahan }}">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


<script>
    function filterTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('bahanTable');
        const rows = table.getElementsByTagName('tr');
        let noDataFound = true;

        for (let i = 1; i < rows.length; i++) { // Mulai dari 1 untuk menghindari header
            const cells = rows[i].getElementsByTagName('td');
            let rowMatch = false;

            // Periksa setiap sel dalam baris
            for (let j = 0; j < cells.length; j++) {
                const cellContent = cells[j].textContent || cells[j].innerText;
                if (cellContent.toLowerCase().indexOf(filter) > -1) {
                    rowMatch = true;
                    break;
                }
            }

            // Tampilkan atau sembunyikan baris berdasarkan kecocokan
            rows[i].style.display = rowMatch ? '' : 'none';
            if (rowMatch) noDataFound = false;
        }

        // Tampilkan pesan "DATA TIDAK DITEMUKAN" jika tidak ada data yang cocok
        document.getElementById('noDataFound').style.display = noDataFound ? '' : 'none';
    }
</script>

        </section>
    </main>

    @include('auth.footer')

    <!-- Modal Detail -->
    @foreach ($bahan as $data)
        <div class="modal fade" id="detailModal{{ $data->id_bahan }}" tabindex="-1"
            aria-labelledby="detailModal{{ $data->id_bahan }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModal{{ $data->id_bahan }}Label">Detail Bahan
                            {{ $data->nama_bahan }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('Foto Bahan/' . $data->foto_bahan) }}" alt="Foto Bahan"
                                class="img-fluid mb-3" style="max-width: 200px;">
                        </div>
                        <p><strong>Nama Bahan:</strong> <span class="small">{{ $data->nama_bahan }}</span></p>
                        <p><strong>Jumlah:</strong> <span class="small">{{ $data->stok }} {{ $data->satuan }}</span></p>
                        <p><strong>Keterangan:</strong> <span class="small">{{ $data->keterangan }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($bahan as $data)
        <div class="modal fade" id="editModal{{ $data->id_bahan }}" tabindex="-1"
            aria-labelledby="editModal{{ $data->id_bahan }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal{{ $data->id_bahan }}Label">Edit Bahan
                            {{ $data->nama_bahan }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('bahan.update', ['id' => $data->id_bahan]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id_bahan" value="{{ $data->id_bahan }}">
                            <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
                            <div class="mb-3">
                                <label for="edit_nama_bahan" class="form-label">Nama Bahan</label>
                                <input type="text" class="form-control" id="edit_nama_bahan" name="nama_bahan"
                                    value="{{ $data->nama_bahan }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_foto_bahan" class="form-label">Foto Bahan</label>
                                <input type="file" class="form-control" id="edit_foto_bahan" name="foto_bahan"
                                    accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label for="edit_stok" class="form-label">Stok</label>
                                <input type="number" class="form-control" id="edit_stok" name="stok"
                                    value="{{ $data->stok }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_satuan" class="form-label">Satuan</label>
                                <select class="form-select" id="edit_satuan" name="satuan" required>
                                    <option value="gram" {{ $data->satuan == 'gram' ? 'selected' : '' }}>gram
                                    </option>
                                    <option value="ml" {{ $data->satuan == 'ml' ? 'selected' : '' }}>ml</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="edit_status" required>
                                    <option value="baik" {{ $data->status == 'baik' ? 'selected' : '' }}>Baik
                                    </option>
                                    <option value="rusak" {{ $data->status == 'rusak' ? 'selected' : '' }}>Rusak
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_keterangan" class="form-label">Keterangan</label>
                                <textarea class="form-control" id="edit_keterangan" name="keterangan" rows="3">{{ $data->keterangan }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
