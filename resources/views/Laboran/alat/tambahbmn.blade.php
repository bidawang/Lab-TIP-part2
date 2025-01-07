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
      <h1>Alat BMN</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Tambah Alat BMN</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="card">
            <div class="card-body">
              <a href="{{route('alat')}}" class="btn btn-danger mb-3 mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
              <form class="row g-3" method="POST" action="{{route('bmn.tambah')}}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nama_alat" name="nama_alat" placeholder="Nama Barang"required>
                    <label for="nama_alat">Nama Barang</label>
                  </div>
                </div>
                
                
                <input type="hidden" name="stok" value="1" id="">
                <input type="hidden" name="satuan" value="buah" id="">
                <input type="hidden" name="google_id" value="{{auth::user()->google_id}}" id="" required>


                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="merk" name="merk" placeholder="Merk">
                    <label for="merk">Merk</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Kode Barang"required>
                    <label for="kode_barang">Kode Barang</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select class="form-select" id="kondisi_barang" name="kondisi_barang" aria-label="Kondisi Barang" required>
                      <option selected>Pilih Kondisi Barang</option>
                      <option value="baik">Baik</option>
                      <option value="rusak ringan">Rusak Ringan</option>
                      <option value="rusak berat">Rusak Berat</option>
                    </select>
                    <label for="kondisi_barang">Kondisi Barang</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="foto_barang" class="col-form-label">Foto Barang</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="foto_barang" name="foto_barang" accept="image/*"required>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="foto_kode" class="col-form-label">Foto Kode</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="foto_kode" name="foto_kode" accept="image/*"required>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" name="keterangan" placeholder="Address"  id="floatingTextarea" style="height: 100px;" required></textarea>
                    <label for="floatingTextarea">Keterangan</label>
                  </div>
                </div>
                <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
                <div class="text-center">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
              </form><!-- End floating Labels Form -->

            </div>
    </section>
  </main>
  
@include('auth.footer')

</body>

</html>
