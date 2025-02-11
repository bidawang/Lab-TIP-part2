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
      <input name="nama" type="text" class="form-control" id="fullName" value="{{ $formattedName }}">
    </div>
  </div>

  <div class="row mb-3">
    <label for="NIM" class="col-md-4 col-lg-3 col-form-label">NIM</label>
    <div class="col-md-8 col-lg-9">
      <input name="NIM" type="text" class="form-control" id="NIM" value="{{ auth()->user()->NIM }}">
    </div>     
  </div>

  <div class="row mb-3">
    <label for="no_hp" class="col-md-4 col-lg-3 col-form-label">Nomor HP</label>
    <div class="col-md-8 col-lg-9">
      <input name="no_hp" type="number" class="form-control" id="no_hp" value="{{ auth()->user()->no_hp ?? '0' }}">
    </div>
  </div>

  @if (!Str::endsWith(auth()->user()->email, '@politala.ac.id'))
    <div class="mb-3">
      <label class="col-md-4 col-lg-3 col-form-label">Semester</label>
      <select name="semester" class="form-select col-md-8 col-lg-9" id="semester">
        <option disabled>Pilih Semester</option>
        @for ($i = 1; $i <= 9; $i++)
          <option value="{{ $i }}" {{ auth()->user()->semester == $i ? 'selected' : '' }}>
            {{ $i == 9 ? 'Lebih dari 8' : 'Semester ' . $i }}
          </option>
        @endfor
      </select>
    </div>

    <div class="mb-3">
      <label class="col-md-4 col-lg-3 col-form-label">Prodi</label>
      <select name="prodi" class="form-select" id="prodi">
        <option disabled>Pilih Program Studi</option>
        <!-- Kategori D3 -->
        <optgroup label="D3">
          @foreach (['Teknologi Otomotif', 'Teknologi Informasi', 'Akuntansi', 'Agroindustri'] as $prodi)
            <option value="{{ $prodi }}" {{ auth()->user()->prodi == $prodi ? 'selected' : '' }}>
              {{ $prodi }}
            </option>
          @endforeach
        </optgroup>
        <!-- Kategori D4 -->
        <optgroup label="D4">
          @foreach ([
              'Teknologi Pakan Ternak', 
              'Teknologi Rekayasa Konstruksi Jalan Dan Jembatan', 
              'Teknologi Rekayasa Komputer Jaringan', 
              'Teknologi Rekayasa Pemeliharaan Alat Berat', 
              'Akuntansi Perpajakan', 
              'Pengembangan Produk Pangan'
          ] as $prodi)
            <option value="{{ $prodi }}" {{ auth()->user()->prodi == $prodi ? 'selected' : '' }}>
              {{ $prodi }}
            </option>
          @endforeach
        </optgroup>
      </select>
    </div>
  @else
    <input type="hidden" name="semester" value="-">
    <input type="hidden" name="prodi" value="-">
  @endif

  <div class="text-center">
    <button type="submit" class="btn btn-primary">Save Changes</button>
  </div>
</form>
<!-- End Profile Edit Form -->

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