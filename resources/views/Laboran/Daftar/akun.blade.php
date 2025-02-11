@include('auth.header')
<body>
  @include('auth.headerbody')
  @include('Laboran/sidebar.side')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Peminjaman</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Daftar Peminjaman</li>
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
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mahasiswa">Mahasiswa</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#Laboran">Laboran</button>
                        </li>
                        @if(session('level') == 'Dosen' || (session('level') == 'Developer'))
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#dosen">Dosen</button>
                        </li>
                        @endif
                        @if (session('level') =='Developer')
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#developer">Developer</button>
                        </li>
                        @endif
                    </ul>
                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="mahasiswa">
                            @include('Laboran/Daftar.profile_table', ['level' => 'Mahasiswa'])
                        </div>
                        <div class="tab-pane fade profile-overview" id="Laboran">
                            @include('Laboran/Daftar.profile_table', ['level' => 'Laboran'])
                        </div>
                        <div class="tab-pane fade profile-overview" id="dosen">
                            @include('Laboran/Daftar.profile_table', ['level' => 'Dosen'])
                        </div>
                        @if (session('level') =='Developer')
                        <div class="tab-pane fade profile-overview" id="developer">
                            @include('Laboran/Daftar.profile_table', ['level' => 'Developer'])
                        </div>
                        @endif
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
@foreach($akun as $data)
<div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" aria-labelledby="editModal{{$data->id}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal{{$data->id}}Label">Edit Ruangan {{$data->nama_ruangan}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('ustatus', ['id' => $data->id]) }}" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id" value="{{$data->id}}" id="">
          <input type="hidden" name="email" value="{{$data->email}}">
          <div class="mb-3">
            <label for="edit_lantai" class="form-label">Lantai</label>
            <select class="form-select" id="edit_lantai" name="level" required>
              <option value="mahasiswa" {{ $data->level == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
              <option value="Laboran" {{ $data->level == 'Laboran' ? 'selected' : '' }}>Laboran</option>
              <option value="dosen" {{ $data->level == 'dosen' ? 'selected' : '' }}>Dosen</option>
            </select>
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