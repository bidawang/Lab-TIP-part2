@include('auth.header')
<body>
  @include('auth.headerbody')
  @include('Laboran/sidebar.side')
  @php
    // Mendapatkan alamat email pengguna yang sedang masuk
    
    // Memisahkan bagian nama dari alamat email
    $nameParts = explode('@', $email);
    
    // Mengonversi format nama: mengubah huruf pertama dari setiap kata menjadi huruf besar
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
@endphp
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Daftar Peminjaman</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">{{$formattedName}}</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section profile">
      @if (@session('success'))
                <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                    {{Session::get('success')}}
                </div>
            @endif 
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <!-- Bordered Tabs -->
                    <ul class="nav nav-tabs nav-tabs-bordered">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mahasiswa">Peminjaman <br> Alat</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Laboran">Pemakaian<br>Bahan</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dosen">Peminjaman<br>Ruangan</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="mahasiswa">
                            @include('Laboran/draft/personal.alatpinjam')
                        </div>
                        <div class="tab-pane fade profile-overview" id="Laboran">
                            @include('Laboran/draft/personal.bahanpakai')
                        </div>
                        <div class="tab-pane fade profile-overview" id="dosen">
                            @include('Laboran/draft/personal.ruangpinjam')
                        </div>
                    </div>
                </div>
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
@foreach($alat_pinjam as $data)
<div class="modal fade" id="editModal{{$data->id_alat_pinjam}}" tabindex="-1" aria-labelledby="editModal{{$data->id_alat_pinjam}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal{{$data->id_alat_pinjam}}Label">Edit Ruangan {{$data->nama_ruangan}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('mhsstat', ['id' => $data->id_alat_pinjam]) }}" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id_alat_pinjam" value="{{$data->id_alat_pinjam}}" id="">
          <div class="mb-3">
            <select class="form-select" id="edit_lantai" name="status" required>
              <option value="tunggu" {{ $data->status == 'tunggu' ? 'selected' : '' }}>Tunggu</option>
              <option value="Disetujui" {{ $data->status == 'Disetujui' ? 'selected' : '' }}>Setujui</option>
              <option value="Ditolak" {{ $data->status == 'Ditolak' ? 'selected' : '' }}>Tolak</option>
            </select>
          </div>
          <input type="hidden" name="google_id" value="{{$data->google_id}}">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach

<!-- Status Ruangan -->
@foreach($pinjam_ruangan as $data)
<div class="modal fade" id="ruangan{{$data->id_pinjam_ruangan}}" tabindex="-1" aria-labelledby="editModal{{$data->id_pinjam_ruangan}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal{{$data->id_pinjam_ruangan}}Label">Edit Ruangan {{$data->nama_ruangan}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('izinruangan', ['id' => $data->id_pinjam_ruangan]) }}" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id_pinjam_ruangan" value="{{$data->id_pinjam_ruangan}}" id="">
          <div class="mb-3">
            <label for="edit_lantai" class="form-label">Lantai</label>
            <select class="form-select" id="edit_lantai" name="status" required>
              <option value="tunggu" {{ $data->status == 'tunggu' ? 'selected' : '' }}>Tunggu</option>
              <option value="Disetujui" {{ $data->status == 'Disetujui' ? 'selected' : '' }}>Setujui</option>
              <option value="Ditolak" {{ $data->status == 'Ditolak' ? 'selected' : '' }}>Tolak</option>
            </select>
          </div>
          <input type="hidden" name="google_id" value="{{$data->google_id}}">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach


@foreach($alat_pinjam as $data)
<div class="modal fade" id="selesai{{$data->id_alat_pinjam}}" tabindex="-1" aria-labelledby="selesai{{$data->id_alat_pinjam}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="selesai{{$data->id_alat_pinjam}}Label">Edit Ruangan {{$data->nama_ruangan}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('alatkembali', ['id' => $data->id_alat_pinjam]) }}" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id_alat_pinjam" value="{{$data->id_alat_pinjam}}" id="">
          <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="stok" name="jumlah" value="{{$data->jumlah}}" placeholder="Your Name">
                    <label for="floatingName">Jumlah Alat</label>
                  </div>
                </div>
                <input type="hidden" name="tanggal_kembali" value="{{ now()->format('Y-m-d') }}">
          <input type="hidden" name="google_id" value="$data->google_id">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach


@foreach($bahan_pakai as $data)
<div class="modal fade" id="eh{{$data->id_bahan_pakai}}" tabindex="-1" aria-labelledby="eh{{$data->id_bahan_pakai}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eh{{$data->id_bahan_pakai}}Label">Edit Ruangan {{$data->nama_ruangan}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('stabahmhs', ['id' => $data->id_bahan_pakai]) }}" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id_bahan_pakai" value="{{$data->id_bahan_pakai}}" id="">
          <input type="hidden" name="google_id" value="{{$data->google_id}}" id="">
          <div class="mb-3">
            <label for="edit_lantai" class="form-label">Lantai</label>
            <select class="form-select" id="edit_lantai" name="status" required>
              <option value="tunggu" {{ $data->status == 'tunggu' ? 'selected' : '' }}>Tunggu</option>
              <option value="Disetujui" {{ $data->status == 'Disetujui' ? 'selected' : '' }}>Setujui</option>
              <option value="Ditolak  " {{ $data->status == 'Ditolak  ' ? 'selected' : '' }}>Tolak</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@php
    $userGoogleId = auth()->user()->google_id; // Assuming you are using the Laravel Auth system and user has google_id
    $alatPinjamArray = $alat_pinjam->where('google_id', $userGoogleId)->toArray();
    $bahanPakaiArray = $bahan_pakai->where('google_id', $userGoogleId)->toArray();
    $combinedData = array_merge($alatPinjamArray, $bahanPakaiArray);
@endphp

@foreach($combinedData as $data)
<div class="modal fade" id="semua" tabindex="-1" aria-labelledby="semuaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="semuaLabel">Edit Ruangan</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        @if(array_key_exists('id_alat_pinjam', $data))
        <form method="POST" action="{{ route('mhsstat', ['id' => $data['id_alat_pinjam']]) }}" enctype="multipart/form-data">
          <input type="hidden" name="id_alat_pinjam" value="{{$data['id_alat_pinjam']}}">
        @elseif(array_key_exists('id_bahan_pakai', $data))
        <form method="POST" action="{{ route('stabahmhs', ['id' => $data['id_bahan_pakai']]) }}" enctype="multipart/form-data">
          <input type="hidden" name="id_bahan_pakai" value="{{$data['id_bahan_pakai']}}">
        @endif
          @csrf
          @method('POST')
          <div class="mb-3">
            <label for="edit_lantai" class="form-label">Lantai</label>
            <select class="form-select" id="edit_lantai" name="status" required>
              <option value="tunggu" {{ $data['status'] == 'tunggu' ? 'selected' : '' }}>Tunggu</option>
              <option value="Disetujui" {{ $data['status'] == 'Disetujui' ? 'selected' : '' }}>Setujui</option>
              <option value="Ditolak" {{ $data['status'] == 'Ditolak' ? 'selected' : '' }}>Tolak</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@foreach($alat_pinjam as $data)
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
    <input type="hidden" name="nama_alat" value="{{$data->nama_alat}}">
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