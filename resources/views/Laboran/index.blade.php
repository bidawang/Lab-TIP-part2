@include('auth.header')

<style>
  .carousel-item img {
    height: 300px;
    object-fit: cover;
    width: 100%;
  }

  .list-item {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #ddd;
  }

  .list-item img {
    height: 100px;
    width: 100px;
    object-fit: cover;
    margin-right: 20px;
  }

  .list-item h5 {
    margin: 0;
  }

  .list-item p {
    margin: 0;
  }
</style>

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

    <section class="section col-12">
      <!-- Carousel Ruangan -->
      <div class="row mt-3">
        <div class="col-12">
          <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
              @foreach($ruang as $data)
                <li data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
              @endforeach
            </ol>
            <div class="carousel-inner">
              @foreach($ruang as $data)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                  <img src="{{ asset('Foto Ruang/' . $data->foto_ruangan) }}" class="d-block w-100" alt="Foto Ruang">
                  <div class="carousel-caption d-none d-md-block">
                    <h5>{{ $data->nama_ruangan }}</h5>
                    <p>Lantai: {{ $data->lantai }}</p>
                    <p>Laboran: {{ $data->Laboran }}</p>
                    <p>Status: {{ $data->status }}</p>
                  </div>
                </div>
              @endforeach
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </a>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-md-6 mb-4">
          <div>
            <h5 class="mb-3">Daftar Bahan</h5>
            <div class="mb-3 col-12">
              <input type="text" class="form-control" id="filterBahan" placeholder="Cari Bahan..." onkeyup="filterList('filterBahan', 'bahan')">
            </div>
            <div id="bahan">
              @foreach($bahan as $data)
                <div class="list-item">
                  <img src="{{ asset('Foto Bahan/' . $data->foto_bahan) }}" alt="Foto Bahan">
                  <div>
                    <h5>{{ $data->nama_bahan }}</h5>
                    <p>Jumlah: {{ $data->stok }} {{ $data->satuan }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div>
            <h5 class="mb-3">Daftar Alat</h5>
            <div class="mb-3 col-12">
              <input type="text" class="form-control" id="filterAlat" placeholder="Cari Alat..." onkeyup="filterList('filterAlat', 'alat')">
            </div>
            <div id="alat">
              @foreach($alat as $data)
                <div class="list-item">
                  <img src="{{ asset('Foto Alat/' . $data->foto_alat) }}" alt="Foto Alat">
                  <div>
                    <h5>{{ $data->nama_alat }}</h5>
                    <p>Jumlah: {{ $data->stok }} {{ $data->satuan }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

    </section>
  </main>
  @include('auth.footer')
  <script>
    function filterList(inputId, containerId) {
      var input, filter, items, container, title, i;
      input = document.getElementById(inputId);
      filter = input.value.toUpperCase();
      container = document.getElementById(containerId);
      items = container.getElementsByClassName('list-item');
      for (i = 0; i < items.length; i++) {
        title = items[i].querySelector("div h5");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
          items[i].style.display = "";
        } else {
          items[i].style.display = "none";
        }
      }
    }
  </script>
</body>
</html>