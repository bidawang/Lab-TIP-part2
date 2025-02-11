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
                <form class="row g-3" method="POST" action="/beli/insert" enctype="multipart/form-data">
                    @csrf
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nama_toko" name="nama_toko" placeholder="Nama Toko">
                            <label for="floatingName">Nama Toko</label>
                        </div>
                    </div>

                    <!-- Checkbox untuk Barang Baru -->
                    <div class="col-md-12 mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_new_barang" name="is_new_barang">
                            <label class="form-check-label" for="is_new_barang">Barang Baru</label>
                        </div>
                    </div>

                    <!-- Nama Barang (Select2 Bahan + Alat) -->
                    <div class="dynamic-input-row col-8 row mt-3 align-items-center">
                        <div id="nama_barang_select">
                            <div class="form-floating">
                                <select class="form-select select2" id="nama_barang" name="nama_barang" required>
                                    <option value="">Pilih Nama Barang</option>
                                    <!-- Tampilkan nama barang dari bahan -->
                                    @foreach($bahan as $item)
                                    <option value="{{ $item->nama_bahan }}" data-jenis="bahan">{{ $item->nama_bahan }}</option>
                                    @endforeach
                                    <!-- Tampilkan nama barang dari alat -->
                                    @foreach($alat as $item)
                                    <option value="{{ $item->nama_alat }}" data-jenis="alat">{{ $item->nama_alat }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div id="new_barang_input" style="display:none;">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="new_nama_barang" name="nama_barang" placeholder="Masukkan Nama Barang Baru">
                                <label for="new_nama_barang">Nama Barang Baru</label>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Upload -->
                    <div class="col-md-4">
                        <label for="inputNumber" class="col-form-label">File Upload</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="formFile" name="foto_pembelian" accept="image/*">
                        </div>
                    </div>

                    <!-- Harga Satuan -->
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga Satuan">
                            <label for="floatingName">Harga Satuan</label>
                        </div>
                    </div>

                    <!-- Jumlah -->
                    <div class="col-md-3">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah">
                            <label for="floatingName">Jumlah</label>
                        </div>
                    </div>

                    <!-- Satuan -->
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

                    <!-- Jenis Pembelian (Akan diubah otomatis berdasarkan pilihan barang) -->
                    <div class="col-md-3">
                        <div class="form-floating mb-3">
                            <select class="form-select" id="jenis" name="jenis" aria-label="State" disabled>
                                <option hidden>Pilih Jenis</option>
                                <option value="alat">Alat</option>
                                <option value="bahan">Bahan</option>
                            </select>
                            <label for="floatingSelect">Jenis Pembelian</label>
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="col-12">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Keterangan" id="keterangan" name="keterangan" style="height: 100px;"></textarea>
                            <label for="floatingTextarea">Keterangan</label>
                        </div>
                    </div>

                    <!-- Hidden Google ID -->
                    <input type="hidden" name="google_id" value="{{Auth::user()->google_id;}}">

                    <!-- Submit and Reset Buttons -->
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

<script>
$(document).ready(function() {
    // Inisialisasi Select2
    $('#nama_barang').select2();

    // Menangani checkbox "Barang Baru"
    $('#is_new_barang').on('change', function() {
        if ($(this).is(':checked')) {
            $('#new_barang_input').show(); // Tampilkan input nama barang baru
            $('#nama_barang_select').hide(); // Sembunyikan Select2
            $('#jenis').prop('disabled', false)

        } else {
            $('#new_barang_input').hide(); // Sembunyikan input nama barang baru
            $('#nama_barang_select').show(); // Tampilkan Select2
            $('#jenis').prop('disabled', true)
        }
    });

    // Mengatur jenis pembelian otomatis berdasarkan nama barang yang dipilih
    $('#nama_barang').on('change', function() {
        var selectedItem = $(this).find(':selected');
        var jenis = selectedItem.data('jenis');
        if (jenis) {
            $('#jenis').val(jenis).trigger('change'); // Set jenis pembelian otomatis
        }
    });
});
</script>
