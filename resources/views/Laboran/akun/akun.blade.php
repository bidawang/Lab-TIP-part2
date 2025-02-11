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
  @if (session('level') !='Mahasiswa' && session('level') !='Laboran')

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item active">Daftar Akun</li>
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
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Prodi</th>
                    <th>No HP</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($akun as $data)
    @if(session('level') == 'Developer')
        <tr>
            <td>{{ ucwords(str_replace('.', ' ', explode('@', $data->email)[0])) }}</td>
            <td>{{ $data->NIM }}</td>
            <td>{{ $data->prodi }}</td>
            <td>{{ $data->no_hp }}</td>
            <td>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$data->id}}">
                    {{ $data->level }}
                </button>
                <!-- Button to open detail modal -->
            <button type="button" class="btn btn-info ms-2" data-bs-toggle="modal" data-bs-target="#detailModal{{$data->id}}">
              Detail
          </button>
            </td>
        </tr>
    @elseif(session('level') != 'Developer' && $data->level != 'Developer' && $data->level != 'Dosen')
        <tr>
            <td>{{ ucwords(str_replace('.', ' ', explode('@', $data->email)[0])) }}</td>
            <td>{{ $data->NIM }}</td>
            <td>{{ $data->prodi }}</td>
            <td>{{ $data->no_hp }}</td>
            <td>
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$data->id}}">
                {{ $data->level }}
            </button>
            
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
    </section>

  </main>
@endif
  @include('auth.footer')

  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Bootstrap JavaScript (Sesuaikan versi yang Anda gunakan dengan kode Anda) -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Modal Edit -->
  @foreach($akun as $data)
  <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" aria-labelledby="editModal{{$data->id}}Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModal{{$data->id}}Label">Edit Level {{$formattedName}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('ustatus', ['id' => $data->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="hidden" name="id" value="{{$data->id}}">
            <input type="hidden" name="email" value="{{$data->email}}">
            <div class="mb-3">
              <label for="edit_level" class="form-label">Level</label>
              <select class="form-select" id="edit_level" name="level" required>
                <option value="mahasiswa" {{ $data->level == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="Laboran" {{ $data->level == 'Laboran' ? 'selected' : '' }}>Laboran</option>
                @if (session('level') == 'Developer')
                <option value="dosen" {{ $data->level == 'dosen' ? 'selected' : '' }}>Dosen</option>
                @endif
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endforeach

  <!-- Modal Detail -->
@foreach($akun as $data)
<div class="modal fade" id="detailModal{{$data->id}}" tabindex="-1" aria-labelledby="detailModal{{$data->id}}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModal{{$data->id}}Label">Detail Akun {{$data->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama:</strong> {{ ucwords(str_replace('.', ' ', explode('@', $data->email)[0])) }}</p>
                <p><strong>NIM:</strong> {{ $data->NIM }}</p>
                <p><strong>Prodi:</strong> {{ $data->prodi }}</p>
                <p><strong>Semester:</strong> {{ $data->semester }}</p>
                <p><strong>No HP:</strong> {{ $data->no_hp }}</p>
                <p><strong>Email:</strong> {{ $data->email }}</p>
                <p><strong>Level:</strong> {{ $data->level }}</p>
                <p><strong>Avatar:</strong> <img src="{{ asset('Profil/' . $data->avatar) }}" alt="Avatar" class="img-fluid"></p>
            </div>
        </div>
    </div>
</div>
@endforeach

</body>
</html>
