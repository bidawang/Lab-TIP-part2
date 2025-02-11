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
      <h1>Alat Rusak</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Alat</li>
          <li class="breadcrumb-item active">Riwayat Alat Rusak</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <a href="{{ route('alat.ucak')}}" class="btn btn-danger mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Alat</th>
                    <th>Penanggungjawab</th>
                    <th>Penyebab <br> Kerusakan</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($alat_rusak as $data)
                  <tr>
                    @if($data->kode_barang == NULL)
                  <td>{{optional($data->alat)->nama_alat ?? 'N/A'}} : {{$data->riwayat}} {{optional($data->alat)->satuan ?? 'N/A'}}<br>
                      <img src="{{ asset('Foto Alat/'. optional($data->alat)->foto_alat ?? 'N/A') }}"class="custom-border" height="100" alt="Foto Alat"">
                      @elseif($data->kode_barang != NULL)
                      <td>{{optional($data->alat_bmn)->nama_alat ?? 'N/A'}} : {{$data->riwayat}} {{optional($data->alat_bmn)->satuan ?? 'N/A'}}<br>

                      <img src="{{ asset('Foto Barang/'. optional($data->alat_bmn)->foto_barang ?? 'N/A') }}" class="custom-border" height="100" alt="Foto Barang"">
@endif
                    </td>
                    <td>{{$data->penanggungjawab}}</td>
                    <td>{{ $data->penyebab_kerusakan }}
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#detailModal{{$data->id_alat_rusak}}">
            <i class="bi bi-eye"></i> Detail
        </button></td>
                  </tr>
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