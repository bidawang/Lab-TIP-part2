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

<main id="main" class="main small">

    <div class="pagetitle">
        <h1>Ruangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Ruangan</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
      @if (@session('message'))
                <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                    {{Session::get('message')}}
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
        @if (session('level') !='Mahasiswa')
            <a href="{{ route('truang') }}" class="btn btn-sm btn-primary mb-3"><i class="bi bi-plus-circle"></i> Tambah Ruangan</a>
            @endif
          
            @if (is_null(session('NIM')) || is_null(session('semester')) || is_null(session('no_hp')))
            <h6 class="breadcum-item">Silahkan lengkapi profil anda terlebih dahulu</h6>
            <a href="myprofile">Klik Disini</a>

            @else
            <a href="{{ route('ruangpjm') }}" class="btn btn-sm btn-info mb-3"><i class="bi bi-file-earmark-plus-fill"></i> Pinjam Ruangan</a>

            @endif
            <input type="text" id="searchInput" class="form-control mt-3" placeholder="Cari Ruangan...">
            <div id="noDataFound" class="mb-4 mt-4" style="display: none;">
                <center>
                    <h1><b>DATA TIDAK DITEMUKAN</b></h1>
                </center>
            </div>
            <div class="row mt-3">
                @foreach($ruang as $data)
                <div class="col mb-3">
                    <div class="card custom-border h-80">
                        <img src="{{ asset('Foto Ruang/' . $data->foto_ruangan) }}" class="card-img-top" alt="Foto Ruang">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data->nama_ruangan }}</h5>
                            <p class="card-text">Lantai: {{ $data->lantai }}</p>
                            <p class="card-text">Laboran: {{ $data->Laboran }}</p>
                            <p class="card-text">Status: {{ $data->status }}</p>
                            @if (session('level') !='Mahasiswa')

                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $data->id_ruangan }}">
                              <i class="bi bi-pencil-square"></i> Edit
                            </button>
                            <form action="/ruang/hapus" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id_ruangan" value="{{ $data->id_ruangan }}">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
    </div>

    <script>
        function searchItems() {
            var input = document.getElementById('searchInput').value.toUpperCase();
            var cards = document.getElementsByClassName('card');
            var noDataFound = document.getElementById('noDataFound');
            var found = false;

            for (var i = 0; i < cards.length; i++) {
                var title = cards[i].querySelector('.card-title').textContent.toUpperCase();
                if (title.indexOf(input) > -1) {
                    cards[i].style.display = "";
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
@foreach($ruang as $data)
<div class="modal fade" id="editModal{{$data->id_ruangan}}" tabindex="-1" aria-labelledby="editModal{{$data->id_ruangan}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal{{$data->id_ruangan}}Label">Edit Ruangan {{$data->nama_ruangan}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('ruang.update', ['id' => $data->id_ruangan]) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="id_ruangan" value="{{$data->id_ruangan}}" id="">
          <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
          <div class="mb-3">
            <label for="edit_nama_ruangan" class="form-label">Nama Ruangan</label>
            <input type="text" class="form-control" id="edit_nama_ruangan" name="nama_ruangan" value="{{ $data->nama_ruangan }}" required>
          </div>
          <div class="mb-3">
            <label for="edit_foto_ruangan" class="form-label">Foto Ruangan</label>
            <input type="file" class="form-control" id="edit_foto_ruangan" name="foto_ruangan" accept="image/*">
          </div>
          <div class="mb-3">
            <label for="edit_gedung" class="form-label">Gedung</label>
            <input type="text" class="form-control" id="edit_gedung" name="gedung" value="{{ $data->gedung }}" required>
          </div>
          <div class="mb-3">
            <label for="edit_lantai" class="form-label">Lantai</label>
            <select class="form-select" id="edit_lantai" name="lantai" required>
              <option value="1" {{ $data->lantai == '1' ? 'selected' : '' }}>Lantai 1</option>
              <option value="2" {{ $data->lantai == '2' ? 'selected' : '' }}>Lantai 2</option>
              <option value="3" {{ $data->lantai == '3' ? 'selected' : '' }}>Lantai 3</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_Laboran" class="form-label">Laboran</label>
            <input type="text" class="form-control" id="edit_Laboran" name="Laboran" value="{{ $data->Laboran }}" required>
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
