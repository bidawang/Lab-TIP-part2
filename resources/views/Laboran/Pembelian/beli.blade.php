@include('auth.header')
<body>
@include('auth.headerbody')
@include('Laboran/sidebar.side')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Pembelian</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Pembelian</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      @if (@session('success'))
      <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
          {{Session::get('success')}}
      </div>
  @endif 
    <div class="row">
            <div class="col-lg-12 mb-3">
            <a href="{{ route('tbeli')}}" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i> Pembelian</a>
              <a href="{{ route('beliprint')}}" class="btn btn-success  mt-3"> <i class="bi bi-printer"></i> Print</a>
              <input type="text" class="form-control mt-3" id="searchInput" placeholder="Cari...">
            </div>
        </div>
        <div class="mb-3">
              
              <div id="noDataFound" style="display: none;">
                <center>
                  <h1><b>DATA KADADA</b></h1>
                </center>
              </div>
            </div>     
              <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4">
    @foreach($beli as $data)
    <div class="col mb-4">
        <div class="card h-100">
            <img src="{{ asset('Foto Beli/'. $data->foto_pembelian) }}" class="card-img-top" alt="Foto Pembelian">
            <div class="card-body">
                <h5 class="card-title">{{ $data->nama_barang }}</h5>
                <p class="card-text">Jumlah: {{ $data->jumlah }} {{ $data->satuan }}</p>
                <p class="card-text">{{ \Carbon\Carbon::parse($data->created_at)->isoFormat('DD MMMM YYYY') }}</p>
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal{{$data->id_pembelian}}">
                    Edit
                </button>
                <form action="/beli/hapus" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="id_pembelian" value="{{ $data->id_pembelian }}">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </form> --}}
            </div>
        </div>
    </div>
    @endforeach
    <script>
    function searchItems() {
        // Mendapatkan nilai input dari field pencarian
        var input = document.getElementById('searchInput').value.toUpperCase();
        // Mendapatkan semua elemen card
        var cards = document.getElementsByClassName('card');
        // Mendapatkan elemen pesan "Tidak ada data yang ditemukan"
        var noDataFound = document.getElementById('noDataFound');
        var found = false; // Variabel untuk menunjukkan apakah data ditemukan

        // Melakukan iterasi pada setiap elemen card
        for (var i = 0; i < cards.length; i++) {
            var title = cards[i].querySelector('.card-title').textContent.toUpperCase();
            // Mengatur tampilan card berdasarkan pencarian
            if (title.indexOf(input) > -1) {
                cards[i].style.display = "";
                found = true;
            } else {
                cards[i].style.display = "none";
            }
        }

        // Menampilkan pesan "Tidak ada data yang ditemukan" jika tidak ada hasil pencarian
        if (!found) {
            noDataFound.style.display = "block";
        } else {
            noDataFound.style.display = "none";
        }
    }

    // Mendengarkan event saat pengguna mengetikkan sesuatu di field pencarian
    document.getElementById('searchInput').addEventListener('keyup', searchItems);
</script>

</div>
              </div>
            </div>
    </section>
  </main>
  
@include('auth.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Skrip Bootstrap (Pastikan versi yang Anda gunakan sesuai dengan kode Anda) -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Modal Edit -->
@foreach($beli as $data)
<div class="modal fade" id="editModal{{$data->id_pembelian}}" tabindex="-1" aria-labelledby="editModal{{$data->id_pembelian}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal{{$data->id_pembelian}}Label">Edit Pembelian {{$data->nama_barang}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('pembelian.update', ['id' => $data->id_pembelian]) }}" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id_pembelian" value="{{$data->id_pembelian}}" id="">
          <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
          <div class="mb-3">
            <label for="edit_nama_barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang" value="{{ $data->nama_barang }}" required>
          </div>
          <div class="mb-3">
            <label for="edit_foto_pembelian" class="form-label">Foto Pembelian</label>
            <input type="file" class="form-control" id="edit_foto_pembelian" name="foto_pembelian" accept="image/*">
          </div>
          <div class="mb-3">
            <label for="edit_harga" class="form-label">Harga Satuan</label>
            <input type="number" class="form-control" id="edit_harga" name="harga" value="{{ $data->harga }}" required>
          </div>
          <div class="mb-3">
            <label for="edit_jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="edit_jumlah" name="jumlah" value="{{ $data->jumlah }}" required>
          </div>
          <div class="mb-3">
            <label for="edit_satuan" class="form-label">Satuan</label>
            <select class="form-select" id="edit_satuan" name="satuan" required>
              <option value="ml" {{ $data->satuan == 'ml' ? 'selected' : '' }}>ml</option>
              <option value="gram" {{ $data->satuan == 'gram' ? 'selected' : '' }}>gram</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="edit_jenis" class="form-label">Jenis Pembelian</label>
            <select class="form-select" id="edit_jenis" name="jenis" required>
              <option value="alat" {{ $data->jenis == 'alat' ? 'selected' : '' }}>Alat</option>
              <option value="bahan" {{ $data->jenis == 'bahan' ? 'selected' : '' }}>Bahan</option>
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