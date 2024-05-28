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
  @include('laboran/sidebar.side')

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
    <section class="section col-12">
    <div class="row">
      <!-- Kolom kiri -->
      <div class="col-md-6">
        <!-- Tabel pertama di kolom kiri -->
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title">Bordered Table (5 Rows)</h5>
            <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p>
            <!-- Tabel kiri atas -->
            <div class="table-responsive" style="max-height: 200px; overflow-y: auto;"> <!-- Tambahkan properti CSS untuk membatasi tinggi tabel -->
              <table class="table table-bordered" data-page-length="5" data-pagination="true" id="table-left-top">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Age</th>
                    <th>Start Date</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Isi dengan 5 baris data -->
                </tbody>
              </table>
            </div> <!-- Akhir div dengan kelas table-responsive -->
            <!-- Akhir Tabel kiri atas -->
          </div>
        </div>
        <!-- Akhir Tabel pertama di kolom kiri -->

        <!-- Tabel kedua di kolom kiri -->
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Bordered Table (5 Rows)</h5>
            <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p>
            <!-- Tabel kiri bawah -->
            <div class="table-responsive" style="max-height: 200px; overflow-y: auto;"> <!-- Tambahkan properti CSS untuk membatasi tinggi tabel -->
              <table class="table table-bordered" data-page-length="5" data-pagination="true" id="table-left-bottom">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Age</th>
                    <th>Start Date</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Isi dengan 5 baris data -->
                </tbody>
              </table>
            </div> <!-- Akhir div dengan kelas table-responsive -->
            <!-- Akhir Tabel kiri bawah -->
          </div>
        </div>
        <!-- Akhir Tabel kedua di kolom kiri -->
      </div>
      
      <!-- Kolom kanan -->
      <div class="col-md-6">
        <!-- Tabel kanan -->
        <div class="row" style="height: calc(100% - 30px);">
          <div class="col-md-12" style="height: 100%;">
            <div class="card mb-3 h-100">
              <div class="card-body" style="height: 100%;">
                <h5 class="card-title">Bordered Table (10 Rows)</h5>
                <p>Add <code>.table-bordered</code> for borders on all sides of the table and cells.</p>
                <!-- Tabel kanan -->
                <div class="table-responsive"> <!-- Tambahkan div dengan kelas table-responsive -->
                  <table class="table table-bordered" data-page-length="10" data-pagination="true" id="table-right">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Age</th>
                        <th>Start Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- Isi dengan 10 baris data -->
                    </tbody>
                  </table>
                </div> <!-- Akhir div dengan kelas table-responsive -->
                <!-- Akhir Tabel kanan -->
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>
  </main>

@include('auth.footer')

</body>

</html>