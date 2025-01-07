@include('auth.header')
@php
    // Mendapatkan alamat email pengguna yang sedang masuk
    $email = Auth::user()->email;
    
    // Memisahkan bagian nama dari alamat email
    $nameParts = explode('@', $email);
    
    // Mengonversi format nama: mengubah huruf pertama dari setiap kata menjadi huruf besar
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
@endphp
<style>
    .card-img-top {
    height: 250px; /* Fixed height for all images */
    object-fit: cover; /* Ensure images cover the space while maintaining aspect ratio */
  }
  .custom-border {
    border: 1px solid #000; /* Thicker and darker border */
  }
</style>
<body>
@include('auth.headerbody')
@include('Laboran/sidebar.side')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Alat Rusak</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Alat</li>
          <li class="breadcrumb-item active">Alat Rusak</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      @if (@session('success'))
                <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                    {{Session::get('success')}}
                </div>
            @endif 
      @if (@session('warning'))
                <div id="alert" class="alert alert-warning" onclick="this.style.display='none'">
                    {{Session::get('warning')}}
                </div>
            @endif 
      <div class="row">
        <div class="col-lg-12">

          <div class="card ">
            <div class="card-body">
              <a href="{{ route('alat')}}" class="btn btn-danger mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
              <a href="{{ route('riwayatucak')}}" class="btn btn-dark mt-3">Riwayat</a>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Alat</th>
                    <th>Penanggungjawab</th>
                    <th>Penyebab <br> Kerusakan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($alat_rusak as $data)
                  @if($data->jumlah==!0)
                  <tr>
                    @if($data->kode_barang == NULL)
                      <td>{{optional($data->alat)->nama_alat ?? 'N/A'}} : {{$data->jumlah}} {{optional($data->alat)->satuan ?? 'N/A'}}<br>
                      <img src="{{ asset('Foto Alat/'. optional($data->alat)->foto_alat ?? 'N/A') }}" height="150" class="custom-border" alt="Foto Alat"">
                      @elseif($data->kode_barang != NULL)
                      <td>{{optional($data->alat_bmn)->nama_alat ?? 'N/A'}} : {{$data->jumlah}} {{optional($data->alat_bmn)->satuan ?? 'N/A'}}<br>

                      <img src="{{ asset('Foto Barang/'. optional($data->alat_bmn)->foto_barang ?? 'N/A') }}" height="150" class="custom-border" alt="Foto Barang"">
@endif
                    </td>
                    <td>{{$data->penanggungjawab}}</td>
                    <td>{{ $data->penyebab_kerusakan }}</td>
                    
                    <td><button type="button" class="btn btn-success" data-toggle="modal" data-target="#editModal{{$data->id_alat_rusak}}">Selesai</button>
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detailModal{{$data->id_alat_rusak}}">
            Detail
        </button></td>
                  </tr>
                  @endif
                  @endforeach
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>
  </main>
  
@include('auth.footer')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Modal Edit -->
@foreach($alat_rusak as $data)
<div class="modal fade" id="editModal{{$data->id_alat_rusak}}" tabindex="-1" aria-labelledby="editModal{{$data->id_alat_rusak}}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal{{$data->id_alat_rusak}}Label">Edit Alat {{optional($data->alat)->nama_alat}}</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('alat/baik',['id' => $data->id_alat_rusak]) }}" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id_alat_rusak" value="{{$data->id_alat_rusak}}" id="">
          <input type="hidden" name="id_alat" value="{{$data->id_alat}}" id="">
          <input type="hidden" name="id_bmn" value="{{$data->id_bmn}}" id="">
          <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
          
          <div class="mb-3">
            <label for="edit_stok" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="edit_stok" name="jumlah" value="{{ $data->jumlah }}" required>
          </div>
          <div class="mb-3">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea class="form-control" id="keterangan" name="keterangan" rows="3">{{$data->keterangan}}</textarea>
    </div>
          
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
@foreach($alat_rusak as $data)
<!-- Edit Modal -->
<div class="modal fade" id="editModal{{$data->id_alat_rusak}}" tabindex="-1" role="dialog" aria-labelledby="editModal{{$data->id_alat_rusak}}Label" aria-hidden="true">
    <!-- Modal content here -->
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal{{$data->id_alat_rusak}}" tabindex="-1" role="dialog" aria-labelledby="detailModal{{$data->id_alat_rusak}}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <!-- Display detailed information here -->
                {{ $data->keterangan }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Additional buttons if needed -->
            </div>
        </div>
    </div>
</div>
@endforeach
</body>

</html>