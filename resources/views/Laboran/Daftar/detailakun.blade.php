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
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">Home</li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section profile">
      <div class="row">
        @if (@session('warning'))
        <div id="alert" class="alert alert-warning" onclick="this.style.display='none'">
            {{Session::get('warning')}}
        </div>
    @endif 
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="../../Profil/{{ Auth::user()->avatar}}"alt="Profile" class="rounded-circle">
              <h2>{{ $formattedName }}</h2>
              <h3>{{auth::user()->level}}</h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>
              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                    <div class="col-lg-9 col-md-8">{{ $formattedName }}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">NIM</div>
                    <div class="col-lg-9 col-md-8">{{auth::user()->NIM}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{auth::user()->email}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Nomor HP</div>
                    <div class="col-lg-9 col-md-8">{{auth::user()->no_hp ?? '0'}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Prodi</div>
                    <div class="col-lg-9 col-md-8">{{auth::user()->prodi}}</div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Semester</div>
                    <div class="col-lg-9 col-md-8">{{auth::user()->semester}}</div>
                  </div>
                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="{{ route('upakun') }}" method="POST">
    @csrf                    
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="nama" type="text" class="form-control" id="fullName" value="{{$formattedName}}">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">NIM</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="NIM" type="text" class="form-control" id="fullName" value="{{auth::user()->NIM}}">
                      </div>     
                    </div>

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Nomor HP</label>
                      <div class="col-md-8 col-lg-9">
                      <input name="no_hp" type="number" class="form-control" id="company" value="{{ auth()->user()->no_hp ?? '0' }}">
                    </div>
                    </div>

                    <div class="mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Semester</label>
                        <select name="semester" class="form-select col-md-8 col-lg-9" id="floatingSelect" aria-label="State">
                            <option selected disabled>Pilih Semester</option>
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
                    </div>

                    <div class="mb-3">
                    <label class="col-md-4 col-lg-3 col-form-label">Prodi</label>
                        <select name="prodi" class="form-select" id="floatingSelect" aria-label="State">
                            <option selected disabled>Pilih Program Studi</option>
                            <!-- Kategori D3 -->
                            <optgroup label="D3">
                                <option value="Teknologi Otomotif">Teknologi Otomotif</option>
                                <option value="Teknologi Informasi">Teknologi Informasi</option>
                                <option value="Akuntansi">Akuntansi</option>
                                <option value="Agroindustri">Agroindustri</option>
                            </optgroup>
                            <!-- Kategori D4 -->
                            <optgroup label="D4">
                                <option value="Teknologi Pakan Ternak">Teknologi Pakan Ternak</option>
                                <option value="Teknologi Rekayasa Konstruksi Jalan Dan Jembatan">Teknologi Rekayasa Konstruksi Jalan Dan Jembatan</option>
                                <option value="Teknologi Rekayasa Komputer Jaringan">Teknologi Rekayasa Komputer Jaringan</option>
                                <option value="Teknologi Rekayasa Pemeliharaan Alat Berat">Teknologi Rekayasa Pemeliharaan Alat Berat</option>
                                <option value="Akuntansi Perpajakan">Akuntansi Perpajakan</option>
                                <option value="Pengembangan Produk Pangan">Pengembangan Produk Pangan</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>
                  </form><!-- End settings Form -->

                </div>
              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>
  </main>
  
@include('auth.footer')

</body>

</html>