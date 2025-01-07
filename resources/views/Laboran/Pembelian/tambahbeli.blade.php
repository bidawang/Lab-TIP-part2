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
          <li class="breadcrumb-item active">Tambah Pembelian</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="card">
            <div class="card-body">
              <a href="{{route('beli')}}" class="btn btn-danger mb-3 mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
              <form class="row g-3" method="POST" action="/beli/insert"  enctype="multipart/form-data">
                @csrf
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nama_toko" name="nama_toko" placeholder="Your Name">
                    <label for="floatingName">Nama Toko</label>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" placeholder="Your Name">
                    <label for="floatingName">Nama Barang</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="inputNumber" class="col-form-label" >File Upload</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile" name="foto_pembelian" accept="image/*">
                </div>
                </div>
                
                <div class="col-md-3">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Your Name">
                    <label for="floatingName">Harga Satuan</label>
                  </div>
                </div>

                <div class="col-md-3">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Your Name">
                    <label for="floatingName">Jumlah</label>
                  </div>
                </div>

                <div class="col-md-3">
    <div class="form-floating mb-3">
        <select class="form-select" id="satuan" name="satuan" aria-label="State">
            <option hidden>Satuan</option>
            <option value="ml">ml (Mililiter)</option>
            <option value="gram">gram</option>
            <option value="kg">kg (Kilogram)</option>
            <option value="liter">liter</option>
        </select>
        <label for="floatingSelect">Satuan</label>
    </div>
</div>


                <div class="col-md-3">
                  <div class="form-floating mb-3">
                    <select class="form-select" id="jenis" name="jenis" aria-label="State">
                      <option hidden>Pilih Jenis</option>
                      <option value="alat">Alat</option>
                      <option value="bahan">Bahan</option>
                    </select>
                    <label for="floatingSelect">Jenis Pembelian</label>
                  </div>
                </div>

                

                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Address" id="keterangan" name="keterangan" style="height: 100px;"></textarea>
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
  
@include('auth.footer')

</body>

</html>