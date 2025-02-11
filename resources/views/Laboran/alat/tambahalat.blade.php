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
@if (session('level') !='Mahasiswa')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Alat</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Tambah Alat</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="card">
            <div class="card-body">
              <a href="{{route('alat')}}" class="btn btn-danger mb-3 mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
              <form class="row g-3" method="POST" action="/alat/insert"  enctype="multipart/form-data">
                @csrf
                <div class="col-md-8">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nama_alat" name="nama_alat" placeholder="" required>
                    <label for="floatingName">Nama Alat</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="inputNumber" class="col-form-label">File Upload</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="foto_alat" name="foto_alat" accept="image/*"required>
                </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="stok" name="stok" placeholder="Your Name"required>
                    <label for="floatingName">Stok</label>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select class="form-select" id="satuan" name="satuan" aria-label="State"required>
                      <option selected>Pilih Satuan</option>
                      <option value="gram">Miligram</option>
                      <option value="ml">Gram</option>
                      <option value="buah">Buah</option>
                    </select>
                    <label for="floatingSelect">Satuan</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" name="keterangan" placeholder="Address"  id="floatingTextarea" style="height: 100px;"required></textarea>
                    <label for="floatingTextarea">Keterangan</label>
                  </div>
                </div>
                <input type="hidden" name="google_id" value="{{Auth::user()->google_id;}}">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>
    </section>
  </main>
  @endif
@include('auth.footer')

</body>

</html>