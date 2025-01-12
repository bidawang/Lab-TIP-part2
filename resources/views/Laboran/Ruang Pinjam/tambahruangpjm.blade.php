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

<main id="main" class="main small">

    <div class="pagetitle">
        <h1>Surat Peminjaman</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Surat Peminjaman</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{route('ruangpjm')}}" class="btn btn-sm btn-danger mb-3 mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
                
                <form class="row g-3" method="post" action="/ruangpjm/insert" enctype="multipart/form-data">
                    @csrf 
                    
                    <input type="hidden" name="status" value="tunggu">
                    <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">


                    <div class="col-6">
    <div class="form-floating mb-0">
        <select class="form-select" name="nama_ruangan" required style="font-size: 0.875rem;">
            <option selected disabled>Pilih Ruangan</option>
            @foreach($ruangan as $item)
                <option value="{{ $item->nama_ruangan }}">{{ $item->nama_ruangan }}</option>
            @endforeach
        </select>
        <label for="nama_ruangan">Ruangan</label>
    </div>
</div>



                    <div class=" col-6">
                        <div class="form-floating mb-0">
                            <select class="form-select" name="tipe_peminjaman" required style="font-size: 0.875rem;">
                                <option selected disabled>Pilih Tipe Peminjaman</option>
                                <option value="praktikum">Praktikum</option>
                                <option value="TA">TA</option>
                            </select>
                            <label for="tipe_peminjaman">Tipe Peminjaman</label>
                        </div>
                    </div>

                    <div class=" col-lg-6">
                        <div class="form-floating mb-0">
                            <input type="text" name="mata_kuliah" class="form-control" required>
                            <label for="mata_kuliah">Mata Kuliah</label>
                        </div>
                    </div>

                    <div class=" col-12">
                        <div class="form-floating mb-0" >
                            <input type="date" name="tanggal_peminjaman" class="form-control" required style="font-size: 0.875rem;">
                            <label for="tanggal_peminjaman">Tanggal Pinjam</label>
                        </div>
                    </div>

                    <div class=" col-6">
                        <div class="form-floating mb-0">
                            <input type="time" name="jam_mulai" class="form-control" required>
                            <label for="jam_mulai">Jam Mulai</label>
                        </div>
                    </div>

                    <div class=" col-6">
                        <div class="form-floating mb-0">
                            <input type="time" name="jam_selesai" class="form-control" required>
                            <label for="jam_selesai">Jam Selesai</label>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" name="keperluan" placeholder="Keperluan" id="keperluan" style="height: 100px;font-size: 0.875rem;"required></textarea>
                            <label for="keperluan">Keperluan</label>
                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <button type="reset" class="btn btn-sm btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                    </div>
                </form><!-- End floating Labels Form -->
            </div>
        </div>
    </section>
</main>

@include('auth.footer')

</body>

</html>
