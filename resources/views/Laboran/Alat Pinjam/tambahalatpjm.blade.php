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
        <h1>Peminjaman Alat</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Alat</li>
                <li class="breadcrumb-item active">Tambah Peminjaman Alat</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('alatpjm') }}" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
                </div>

                <form class="row g-3" method="POST" action="/alatpjm/insert" enctype="multipart/form-data">
                    @csrf
                    <div id="dynamic-input-container">
                        <div class="dynamic-input-row row mt-3 align-items-center">
                        <div class="col-12 d-flex align-items-center">
                        <div class="form-floating flex-grow-1">
                                    <select class="form-select select2" name="nama_alat[]" required onchange="fillSatuan(this)">
                                        <option selected disabled>Pilih Alat</option>
                                        @foreach($alat as $item)
                                        @if($item->stok > 1) <!-- Kondisi untuk menampilkan hanya data dengan stok lebih dari 1 -->
                                            <option value="{{ $item->nama_alat }}" data-stok="{{ $item->stok }}" data-satuan="{{ $item->satuan }}">{{ $item->nama_alat }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    </div>
                                    <div class="col-4">
                                <button type="button" class="btn btn-success btn-sm ms-2" onclick="addInputRow()">Tambah Alat</button>
                            </div>
                            </div>

                            <div class="col-12 d-flex mt-4 align-items-center">
<div class="col-8">
    <input type="number" class="form-control " name="jumlah[]" min="0" placeholder="Jumlah" required>
    </div>
    <div class="col-4">
    <input type="text" class="form-control" name="satuan[]" placeholder="Satuan" readonly>
    </div>
</div>


                        </div>
                    </div>

                    <div class="mt-4 col-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="tempat_peminjaman" name="tempat_peminjaman" placeholder="Tempat Peminjaman" required>
                            <label for="tempat_peminjaman">Tempat Peminjaman</label>
                        </div>
                    </div>

                    <div class="mt-4 col-12 col-sm-6">
                        <div class="form-floating">
                            <input type="date" class="form-control" name="tanggal_peminjaman" id="tanggal_peminjaman" placeholder="Tanggal Pinjam" required>
                            <label for="tanggal_peminjaman">Tanggal Pinjam</label>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Keperluan" name="keperluan" id="keperluan" style="height: 100px;" required></textarea>
                            <label for="keperluan">Keterangan</label>
                        </div>
                    </div>

                    <input type="hidden" name="nama_peminjam" value="{{$formattedName}}">
                    <input type="hidden" name="google_id" value="{{ Auth::user()->google_id }}">
                    <input type="hidden" name="status" value="tunggu">

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>

@include('auth.footer')

<script>
    $(document).ready(function() {
        // Initialize Select2 for static and dynamically added elements
        $('select.select2').select2();
    });

    function fillSatuan(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var satuan = selectedOption.getAttribute('data-satuan');
        var stok = selectedOption.getAttribute('data-stok');  // Gunakan data-stok

        var satuanInput = selectElement.closest('.dynamic-input-row').querySelector('input[name="satuan[]"]');
        var jumlahInput = selectElement.closest('.dynamic-input-row').querySelector('input[name="jumlah[]"]');

        satuanInput.value = satuan;
        jumlahInput.setAttribute('max', stok);  // Update max attribute
        jumlahInput.setAttribute('placeholder', 'Max: ' + stok); // Dynamic placeholder
    }

    var dynamicInputIndex = 0;

    function addInputRow() {
        dynamicInputIndex++;

        var template = `
            <div class="dynamic-input-row row mt-3 align-items-center" id="dynamic-input-row-${dynamicInputIndex}">
                        <div class="col-12 d-flex align-items-center">
                    <div class="form-floating flex-grow-1">
                        <select class="form-select select2" name="nama_alat[]" required onchange="fillSatuan(this)">
                            <option selected disabled>Pilih Alat</option>
                            @foreach($alat as $item)
                                        @if($item->stok > 1) <!-- Kondisi untuk menampilkan hanya data dengan stok lebih dari 1 -->
                                <option value="{{ $item->nama_alat }}" data-stok="{{ $item->stok }}" data-satuan="{{ $item->satuan }}">{{ $item->nama_alat }}</option>
                            @endif
                                @endforeach
                        </select>
                    </div>
                    <div class="col-4">
                    <button type="button" class="btn btn-danger btn-sm ms-2" onclick="removeInputRow(${dynamicInputIndex})">Hapus Baris</button>
                </div></div>
                <div class="col-12 d-flex mt-4 align-items-center">
<div class="col-8">
    <input type="number" class="form-control " name="jumlah[]" min="0" placeholder="Jumlah" required>
    </div>
    <div class="col-4">
    <input type="text" class="form-control" name="satuan[]" placeholder="Satuan" readonly>
    </div>
</div>


                        </div>
                    </div>
        `;

        var container = document.getElementById('dynamic-input-container');
        var newDiv = document.createElement('div');
        newDiv.innerHTML = template.trim();
        container.appendChild(newDiv.firstChild);

        // Reinitialize Select2 for the new elements
        $('select.select2').select2();
    }

    function removeInputRow(index) {
        var element = document.getElementById(`dynamic-input-row-${index}`);
        element.remove();
    }

    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0]; // Mengambil tanggal hari ini dalam format YYYY-MM-DD
        document.getElementById('tanggal_peminjaman').setAttribute('min', today);
    });
</script>
</body>
</html>
