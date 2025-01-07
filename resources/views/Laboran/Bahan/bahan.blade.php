@include('auth.header')
<style>
    .card-img-top {
        height: 250px;
        /* Fixed height for all images */
        object-fit: cover;
        /* Ensure images cover the space while maintaining aspect ratio */
    }

    .custom-border {
        border: 1px solid #000;
        /* Thicker and darker border */
    }
</style>
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
        <!-- End Page Title -->
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
                        <a href="{{ route('tbahan') }}" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i>
                            Bahan</a>
                    @endif

                    @if (is_null(session('NIM')) || is_null(session('semester')) || is_null(session('no_hp')))
                    <h4 class="breadcum-item">Silahkan lengkapi profil anda terlebih dahulu</h4>
                    @else
                    <a href="{{ route('bahan_pakai') }}" class="btn btn-info text-muted mt-3"><i
                                class="bi bi-file-earmark-plus-fill"></i> Pakai Bahan</a>

                    @endif
                    <input type="text" id="searchInput" onkeyup="filterCards('searchInput', 'cardContainer')"
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

            <div id="cardContainer">
                <div class="row">
                    @foreach ($bahan as $data)
                        <div class="col-md-3 mb-4 filtered-item">
                            <div class="card custom-border h-100">
                                <img src="{{ asset('Foto Bahan/' . $data->foto_bahan) }}" class="card-img-top"
                                    alt="Foto Bahan">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $data->nama_bahan }}</h5>
                                    <p class="card-text">Jumlah: {{ $data->stok }} {{ $data->satuan }}</p>
                                    @if (session('level') != 'Mahasiswa')
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#editModal{{ $data->id_bahan }}"> <i
                                                class="bi bi-pencil-square"></i> Edit
                                        </button>
                                        <form action="/bahan/hapus" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id_bahan" value="{{ $data->id_bahan }}">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="bi bi-trash3"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <script>
                function filterCards(inputId, containerId) {
                    var input, filter, cards, cardContainer, title, noDataFound;
                    input = document.getElementById(inputId);
                    filter = input.value.toUpperCase();
                    cardContainer = document.getElementById(containerId);
                    cards = cardContainer.getElementsByClassName('filtered-item');
                    noDataFound = document.getElementById('noDataFound');
                    var found = false;

                    for (var i = 0; i < cards.length; i++) {
                        title = cards[i].querySelector('.card-title').textContent.toUpperCase();
                        if (title.indexOf(filter) > -1) {
                            cards[i].style.display = "block";
                            found = true;
                        } else {
                            cards[i].style.display = "none";
                        }
                    }

                    if (!found) {
                        noDataFound.style.display = "block";
                    } else {
                        noDataFound.style.display = "none";
                    }

                    // Jika input pencarian kosong, tampilkan semua item
                    if (filter === '') {
                        Array.prototype.forEach.call(cards, function(card) {
                            card.style.display = "block";
                        });
                        noDataFound.style.display = "none";
                    }
                }
            </script>

        </section>


    </main>

    @include('auth.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                            <input type="hidden" name="id_bahan" value="{{ $data->id_bahan }}" id="">
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
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

</body>

</html>
