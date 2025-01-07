@include('auth.header')

<body>

  <!-- ======= Header ======= -->
@include('auth.headerbody')
  <!-- ======= Sidebar ======= -->
  @include('Laboran/sidebar.side')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="card">
            <div class="card-body">
              <a href="{{route('akun')}}" class="btn btn-primary mb-3 mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
              <!-- Floating Labels Form -->
              <form class="row g-3">
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="floatingName" placeholder="NIM">
                    <label for="floatingName">NIM</label>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="floatingSelect" aria-label="State">
                            <option selected disabled>Pilih Program Studi</option>
                            <!-- Kategori D3 -->
                            <optgroup label="D3">
                                <option value="1">Teknologi Otomotif</option>
                                <option value="2">Teknologi Informasi</option>
                                <option value="3">Akuntansi</option>
                            </optgroup>
                            <!-- Kategori D4 -->
                            <optgroup label="D4">
                                <option value="4">Teknologi Pakan Ternak</option>
                                <option value="5">Teknologi Rekayasa Konstruksi Jalan Dan Jembatan</option>
                                <option value="6">Teknologi Rekayasa Komputer Jaringan</option>
                                <option value="7">Teknologi Rekayasa Pemeliharaan Alat Berat</option>
                                <option value="8">Akuntansi Perpajakan</option>
                                <option value="9">Pengembangan Produk Pangan</option>
                            </optgroup>
                        </select>
                        <label for="floatingSelect">Pilih</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3 mt-3">
                        <select class="form-select" id="floatingSelect" aria-label="State">
                            <option selected disabled>Semester</option>
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                                <option value="3">Semester 3</option>
                                <option value="4">Semester 4</option>
                                <option value="5">Semester 5</option>
                                <option value="6">Semester 6</option>
                                <option value="7">Semester 7</option>
                                <option value="8">Semester 8</option>
                                <option value="9">Lebih dari 8</option>
                        </select>
                        <label for="floatingSelect">Pilih</label>
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3 mt-3">
                    <input type="date" class="form-control">
                    <label for="inputDate" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="number" class="form-control" id="floatingPassword" placeholder="Nomor HP">
                    <label for="floatingPassword">Nomor HP</label>
                  </div>
                </div>
                
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
                    <label for="floatingTextarea">Address</label>
                  </div>
                </div>
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