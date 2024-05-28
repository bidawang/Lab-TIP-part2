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

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="../../NiceAdmin/assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">TIP</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
          
        </li><!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../Profil/{{ Auth::user()->avatar}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{$formattedName}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{$formattedName}}</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('laboran/sidebar.side')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Surat Peminjaman</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Surat Peminjaman</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section">
    <div class="card">
            <div class="card-body">
              <a href="{{route('surat')}}" class="btn btn-primary mb-3 mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
              <!-- Floating Labels Form -->
              <form class="row g-3" method="post" action="/pinjam-insert"  enctype="multipart/form-data">
                @csrf 
                <div class="col-md-12">
                  <div class="form-floating">
                    <input type="hidden" class="form-control" id="floatingName" name="nama_peminjam" value="{{$formattedName}}" placeholder="Nama">
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-floating mb-3 mt-3">
                    <input type="date" name="tanggal_peminjaman" class="form-control">
                    <label for="inputDate" class="col-sm-2 col-form-label">Tanggal Pinjam</label>
                  </div>
                </div>
                
                <div class="col-md-4">
                  <div class="form-floating mb-3 mt-3">
                    <input type="time" name="waktu_mulai" class="form-control">
                    <label for="inputTime" class="col-sm-2 col-form-label">Waktu Mulai</label>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating mb-3 mt-3">
                    <input type="time" name="waktu_akhir" class="form-control">
                    <label for="inputTime" class="col-sm-2 col-form-label">Waktu Akhir</label>
                  </div>
                </div>
                
                <div class="col-12">
                  <div class="form-floating">
                    <textarea class="form-control" name="keperluan" placeholder="Address" id="floatingTextarea" style="height: 100px;"></textarea>
                    <label for="floatingTextarea">Keperluan</label>
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