
@include('auth.header')
<body>
@include('auth.headerbody')
@include('Laboran/sidebar.side')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Ruangan</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</a></li>
          <li class="breadcrumb-item active">Tambah Ruangan</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="card">
            <div class="card-body">
            <a href="{{route('ruang')}}" class="btn btn-danger mb-3 mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>

              <!-- Floating Labels Form -->
              <form class="row g-3" method="POST" action="/ruang/insert"  enctype="multipart/form-data">
                @csrf
                <div class="col-md-8">
                  <div class="form-floating">
                    <input type="text" class="form-control" id="nama_ruangan" name="nama_ruangan" placeholder="Your Name" required>
                    <label for="floatingName">Nama Ruangan</label>
                  </div>
                </div>

                <div class="col-md-4">
                <div class="form-floating">
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="foto_ruangan" name="foto_ruangan" accept="image/*" required>
                  </div>
                </div>
            </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="gedung" name="gedung" placeholder="Gedung" required>
                    <label for="floatingSelect">Gedung</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <select class="form-select" id="lantai" name="lantai" aria-label="State" required>
                      <option selected value="1">Lantai 1</option>
                      <option value="2">Lantai 2</option>
                      <option value="3">Lantai 3</option>
                    </select>
                    <label for="floatingSelect">Lantai</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="Laboran" name="Laboran" placeholder="Laboran" required>
                    <label for="floatingSelect">Laboran</label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" placeholder="Address" id="keterangan" name="keterangan" style="height: 100px;" required></textarea>
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
          </div>
    </section>
  </main>
  
@include('auth.footer')

</body>

</html>