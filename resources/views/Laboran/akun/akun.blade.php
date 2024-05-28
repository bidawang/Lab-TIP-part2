@include('auth.header')
@php
    $email = null;
    $formattedName = null;

    // Periksa apakah ada pengguna yang diotentikasi sebelum mengakses properti 'email'
    if(Auth::check() && Auth::user()) {
        $email = Auth::user()->email;

        // Memisahkan bagian nama dari alamat email
        $nameParts = explode('@', $email);

        // Mengonversi format nama: mengubah huruf pertama dari setiap kata menjadi huruf besar
        $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
    }
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
    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <a href="{{ route('takun')}}" class="btn btn-primary mt-3">Tambah Akun</a>
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>N</b>ame
                    </th>
                    <th>Ext.</th>
                    <th>City</th>
                    <th data-type="date" data-format="YYYY/DD/MM">Start Date</th>
                    <th>Completion</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($akun as $data)
                  @if($data->level == 'Mahasiswa')
                  <tr>
                    <td> <?php
            $email_parts = explode('@', $data->email);
            $name_part = $email_parts[0];
            $name_parts = explode('.', $name_part);
            $formatted_name = implode(' ', array_map('ucwords', $name_parts));
            echo $formatted_name;
            ?></td>
            <td>{{$data->prodi}}</td>
            <td>{{$data->no_hp}}</td>
            <td>{{$data->avatar}}</td>
                    <td>
                      <a href=""><i class="bi bi-pencil-square"></i>Edit</a>
                      <a href=""><i class="bi bi-trash3"></i>Hapus</a>
                    </td>
                  </tr>
                  @endif
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

</body>

</html>