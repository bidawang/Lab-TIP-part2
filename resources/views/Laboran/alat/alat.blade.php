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
      <h1>Alat</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Alat</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      @if (@session('success'))
                <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                    {{Session::get('success')}}
                </div>
            @endif 
      @if (@session('danger'))
                <div id="alert" class="alert alert-danger" onclick="this.style.display='none'">
                    {{Session::get('danger')}}
                </div>
            @endif 
      @if (@session('warning'))
                <div id="alert" class="alert alert-warning" onclick="this.style.display='none'">
                    {{Session::get('warning')}}
                </div>
            @endif 
        <div class="row">
            <div class="col-lg-12">
            @if (session('level') != 'Mahasiswa')
                <a href="{{ route('talat') }}" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i>
Alat</a>
            @endif
            @if (is_null(session('NIM')) || is_null(session('semester')) || is_null(session('no_hp')))
    <h4 class="breadcum-item">Silahkan lengkapi profil anda terlebih dahulu</h4>
@else
    <a href="{{ route('alatpjm') }}" class="btn btn-info text-muted mt-3">
        <i class="bi bi-file-earmark-plus-fill"></i> Pinjam Alat
    </a>
@endif

                <input type="text" id="searchInput" class="form-control mt-3" placeholder="Cari Alat...">
                <div id="noDataFound" class="mb-4 mt-4" style="display: none;">
                    <center>
                        <h1><b>DATA TIDAK DITEMUKAN</b></h1>
                    </center>
                </div>
            </div>
        </div>
        <div class="row mt-3" id="cardContainer">
        @foreach($alat as $data)
    @if (session('level') == 'Mahasiswa' && $data->stok > 1)
        <div class="col-md-3 mb-4 filtered-item" style="display: block;">
            <div class="card custom-border h-100">
                <img src="{{ asset('Foto Alat/' . $data->foto_alat) }}" class="card-img-top" alt="Foto Alat">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->nama_alat }}</h5>
                    <p class="card-text">Jumlah: {{ $data->stok }} {{ $data->satuan }}</p>
                </div>
            </div>
        </div>
    @elseif (session('level') != 'Mahasiswa')
        <div class="col-md-3 mb-4 filtered-item" style="display: block;">
            <div class="card custom-border h-100">
                <img src="{{ asset('Foto Alat/' . $data->foto_alat) }}" class="card-img-top" alt="Foto Alat">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->nama_alat }}</h5>
                    <p class="card-text">Jumlah: {{ $data->stok }} {{ $data->satuan }}</p>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#rustak{{$data->id_alat}}">
                        <i class="bi bi-exclamation-triangle"></i> Rusak
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal{{$data->id_alat}}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <form action="/alat/hapus" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id_alat" value="{{ $data->id_alat }}">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="bi bi-trash3"></i> Hapus
                        </button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detailalat{{$data->id_alat}}">
                        <i class="bi bi-info-circle"></i> Detail
                    </button>
                </div>
            </div>
        </div>
    @endif
@endforeach




        </div>

    <script>
        function searchItems() {
            var input, filter, cards, cardContainer, title, noDataFound;
            input = document.getElementById('searchInput');
            filter = input.value.toUpperCase();
            cardContainer = document.getElementById('cardContainer');
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

        document.getElementById('searchInput').addEventListener('keyup', searchItems);
    </script>
</section>

  </main>
  
@include('auth.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Skrip Bootstrap (Pastikan versi yang Anda gunakan sesuai dengan kode Anda) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Modal Edit -->
@foreach($alat as $data)
<div class="modal fade custom-border" id="editModal{{$data->id_alat}}" tabindex="-1" aria-labelledby="editModal{{$data->id_alat}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal{{$data->id_alat}}Label">Edit Alat {{$data->nama_alat}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('alat.update', ['id' => $data->id_alat]) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="id_alat" value="{{$data->id_alat}}" id="">
          <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
          <div class="mb-3">
            <label for="edit_nama_alat" class="form-label">Nama Alat</label>
            <input type="text" class="form-control" id="edit_nama_alat" name="nama_alat" value="{{ $data->nama_alat }}" required>
          </div>
          <div class="mb-3">
            <label for="edit_foto_alat" class="form-label">Foto Alat</label>
            <input type="file" class="form-control" id="edit_foto_alat" name="foto_alat" accept="image/*">
          </div>
          <div class="mb-3">
            <label for="edit_stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="edit_stok" name="stok" value="{{ $data->stok }}" required>
          </div>
          <div class="mb-3">
            <label for="edit_satuan" class="form-label">Satuan</label>
            <select class="form-select" id="edit_satuan" name="satuan" required>
              <option value="gram" {{ $data->satuan == 'gram' ? 'selected' : '' }}>gram</option>
              <option value="ml" {{ $data->satuan == 'ml' ? 'selected' : '' }}>ml</option>
              <option value="buah" {{ $data->satuan == 'buah' ? 'selected' : '' }}>Buah</option>
              <option value="butir" {{ $data->satuan == 'butir' ? 'selected' : '' }}>Butir</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_status" class="form-label">Status</label>
            <select class="form-select" name="status" id="edit_status" required>
              <option value="baik" {{ $data->status == 'baik' ? 'selected' : '' }}>Baik</option>
              <option value="rusak" {{ $data->status == 'rusak' ? 'selected' : '' }}>Rusak</option>
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


@foreach($alat as $data)
<div class="modal fade" id="detailalat{{$data->id_alat}}" tabindex="-1" aria-labelledby="editModal{{$data->id_alat}}Label" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editModal{{$data->id_alat}}Label">Detail Alat: {{$data->nama_alat}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="card custom-border">
          @if($data->foto_alat)
            <img src="{{ asset('Foto Alat/'.$data->foto_alat) }}" class="card-img-top" alt="Foto Alat">
          @endif
          <div class="card-body">
            <h5 class="card-title">{{ $data->nama_alat }}</h5>
            <p class="card-text">Stok: {{ $data->stok }}</p>
            <p class="card-text">Satuan: {{ $data->satuan }}</p>
            <p class="card-text">Status: {{ $data->status }}</p>
            <p class="card-text">Keterangan: {{ $data->keterangan }}</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endforeach



@foreach($alat as $data)
<div class="modal fade" id="rustak{{$data->id_alat}}" tabindex="-1" aria-labelledby="editModal{{$data->id_alat}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal{{$data->id_alat}}Label">Tambah Alat Rusak {{$data->nama_alat}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form method="POST" action="{{ route('alat/rusak') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
    <input type="hidden" name="id_alat" value="{{$data->id_alat}}">
    <div class="mb-3">
        <label for="nama_alat" class="form-label">Penanggungjawab</label>
        <input type="text" class="form-control" id="nama_alat" name="penanggungjawab" required>
    </div>
    <div class="mb-3">
        <label for="penyebab_kerusakan" class="form-label">Penyebab Kerusakan</label>
        <input type="text" class="form-control" id="penyebab_kerusakan" name="penyebab_kerusakan" required>
    </div>
    <div class="mb-3">
        <label for="jumlah" class="form-label">Jumlah</label>
        <input type="number" class="form-control" id="jumlah" name="jumlah" required>
    </div>
    <div class="mb-3">
        <label for="tingkat_kerusakan" class="form-label">Tingkat Kerusakan</label>
        <select class="form-select" id="tingkat_kerusakan" name="tingkat_kerusakan" required>
            <option value="ringan">Ringan</option>
            <option value="sedang">Sedang</option>
            <option value="berat">Berat</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Tambah Data</button>
</form>
      </div>
    </div>
  </div>
</div>
@endforeach


</body>

</html>