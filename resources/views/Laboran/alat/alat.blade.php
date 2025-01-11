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
            <h1>Alat</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                    <li class="breadcrumb-item active">Alat</li>
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
                        <a href="{{ route('talat') }}" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i>
                            Alat</a>
                    @endif

                    @if (is_null(session('NIM')) || is_null(session('semester')) || is_null(session('no_hp')))
                        <h4 class="breadcum-item">Silahkan lengkapi profil anda terlebih dahulu</h4>
                    @else
                        <a href="{{ route('alatpjm') }}" class="btn btn-info text-muted mt-3"><i
                                class="bi bi-file-earmark-plus-fill"></i> Pakai Alat</a>
                    @endif
                    <input type="text" id="searchInput" onkeyup="filterTable('searchInput', 'alatTable')"
                        class="form-control mt-3" placeholder="Cari...">
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
            <table id="alatTable" class="table table-bordered table-sm small align-middle text-center custom-border">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Action</th>
                    </tr>
                </thead> 
                <tbody>
                    @foreach ($alat as $data)
                        <tr class="filtered-item">
                            <td><img src="{{ asset('Foto Alat/' . $data->foto_alat) }}" alt="Foto Alat"
                                    class="img-fluid" style="max-width: 80px; height: auto;"></td>
                            <td class="small">{{ $data->nama_alat }}</td>
                            <td class="small">{{ $data->stok }} {{ $data->satuan }}</td>
                            <td>
                                @if (session('level') != 'Mahasiswa')
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#editModal{{ $data->id_alat }}">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </button>
                                    <form action="/alat/hapus" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id_alat" value="{{ $data->id_alat }}">
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="bi bi-trash3"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                                <!-- Button Detail -->
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                    data-target="#detailModal{{ $data->id_alat }}">
                                    <i class="bi bi-eye"></i> Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <script>
                function filterTable(inputId, tableId) {
                    var input, filter, table, tr, td, i, j, txtValue;
                    input = document.getElementById(inputId);
                    filter = input.value.toUpperCase();
                    table = document.getElementById(tableId);
                    tr = table.getElementsByTagName("tr");
                    var found = false;

                    for (i = 1; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td");
                        for (j = 1; j < td.length - 1; j++) { // Exclude action column for search
                            if (td[j]) {
                                txtValue = td[j].textContent || td[j].innerText;
                                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                    tr[i].style.display = "";
                                    found = true;
                                    break;
                                } else {
                                    tr[i].style.display = "none";
                                }
                            }
                        }
                    }

                    if (!found) {
                        document.getElementById('noDataFound').style.display = "block";
                    } else {
                        document.getElementById('noDataFound').style.display = "none";
                    }

                    if (filter === '') {
                        Array.prototype.forEach.call(tr, function(row) {
                            row.style.display = "";
                        });
                        document.getElementById('noDataFound').style.display = "none";
                    }
                }
            </script>
        </section>
    </main>

    @include('auth.footer')

    <!-- Modal Detail -->
    @foreach ($alat as $data)
        <div class="modal fade" id="detailModal{{ $data->id_alat }}" tabindex="-1"
            aria-labelledby="detailModal{{ $data->id_alat }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailModal{{ $data->id_alat }}Label">Detail Alat
                            {{ $data->nama_alat }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('Foto Alat/' . $data->foto_alat) }}" alt="Foto Alat"
                                class="img-fluid mb-3" style="max-width: 200px;">
                        </div>
                        <p><strong>Nama Alat:</strong> <span class="small">{{ $data->nama_alat }}</span></p>
                        <p><strong>Jumlah:</strong> <span class="small">{{ $data->stok }} {{ $data->satuan }}</span></p>
                        <p><strong>Keterangan:</strong> <span class="small">{{ $data->keterangan }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($alat as $data)
        <div class="modal fade" id="editModal{{ $data->id_alat }}" tabindex="-1"
            aria-labelledby="editModal{{ $data->id_alat }}Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModal{{ $data->id_alat }}Label">Edit Alat
                            {{ $data->nama_alat }}</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('alat.update', ['id' => $data->id_alat]) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id_alat" value="{{ $data->id_alat }}">
                            <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
                            <div class="mb-3">
                                <label for="edit_nama_alat" class="form-label">Nama Alat</label>
                                <input type="text" class="form-control" id="edit_nama_alat" name="nama_alat"
                                    value="{{ $data->nama_alat }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_foto_alat" class="form-label">Foto Alat</label>
                                <input type="file" class="form-control" id="edit_foto_alat" name="foto_alat"
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
                                    <option value="unit" {{ $data->satuan == 'unit' ? 'selected' : '' }}>unit</option>
                                    <option value="set" {{ $data->satuan == 'set' ? 'selected' : '' }}>set</option>
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
