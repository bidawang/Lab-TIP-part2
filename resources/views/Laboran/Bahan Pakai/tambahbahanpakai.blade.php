@include('auth.header')
@php
    // Mendapatkan alamat email pengguna yang sedang masuk
    $email = Auth::user()->email;
    
    // Memisahkan bagian nama dari alamat email
    $nameParts = explode('@', $email);
    
    // Mengonversi format nama: mengubah huruf pertama dari setiap kata menjadi huruf besar
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
@endphp

<script>
    // Data bahan dalam format JSON
    var bahanData = @json($bahan);
</script>


@include('auth.headerbody')
@include('Laboran/sidebar.side')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Pemakaian Bahan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Tambah Pemakaian</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="{{route('bahan_pakai')}}" class="btn btn-danger mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
                <form class="row g-3" method="POST" action="/bahanpakai/insert" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="nama_pemakai" value="{{ $formattedName }}">

                    <div id="dynamic-input-container">
                        <div class="dynamic-input-row row mt-3 align-items-center">
                            <div class="col-md-4 d-flex align-items-center">
                                <div class="form-floating flex-grow-1">
                                    <select class="form-select select2" name="nama_bahan[]" required onchange="fillSatuan(this)">
                                        <option selected disabled>Pilih Bahan</option>
                                        @foreach($bahan as $item)
                                            <option value="{{ $item->nama_bahan }}" data-satuan="{{ $item->satuan }}" data-max="{{ $item->stok }}">{{ $item->nama_bahan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="button" class="btn btn-success btn-sm ms-2" onclick="addInputRow()">Tambah Baris</button>
                            </div>
                            <div class="col-md-4 mt-2 d-flex align-items-center">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="jumlah[]" min="0" placeholder="Jumlah" required>
                                    <input type="text" class="form-control" name="satuan[]" placeholder="Satuan" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 mt-4 pt-4">
                        <div class="form-floating">
                            <input type="date" class="form-control" id="tanggal_pemakaian" name="tanggal_pemakaian" placeholder="Tanggal Pemakaian" required>
                            <label for="tanggal_pemakaian">Tanggal</label>
                        </div>
                    </div>

                    <div class="col-8 mt-4 pt-4">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Keperluan" name="keperluan" id="keperluan" style="height: 100px;" required></textarea>
                            <label for="keperluan">Keperluan</label>
                        </div>
                    </div>

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

        // Event listener for removing rows
        $('#dynamic-input-container').on('click', '.remove-row', function() {
            $(this).closest('.dynamic-input-row').remove();
        });
    });

    function fillSatuan(selectElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var satuan = selectedOption.getAttribute('data-satuan');
        var maxJumlah = selectedOption.getAttribute('data-max');
        var satuanInput = selectElement.closest('.dynamic-input-row').querySelector('input[name="satuan[]"]');
        var jumlahInput = selectElement.closest('.dynamic-input-row').querySelector('input[name="jumlah[]"]');
        satuanInput.value = satuan;
        jumlahInput.max = maxJumlah;  // Update max attribute
    }

    var dynamicInputIndex = 0;

    function addInputRow() {
        dynamicInputIndex++;

        var template = `
            <div class="dynamic-input-row row mt-3 align-items-center" id="dynamic-input-row-${dynamicInputIndex}">
                <div class="col-md-4 d-flex align-items-center">
                    <div class="form-floating flex-grow-1">
                        <select class="form-select select2" name="nama_bahan[]" required onchange="fillSatuan(this)">
                            <option selected disabled>Pilih Bahan</option>
                            @foreach($bahan as $item)
                                <option value="{{ $item->nama_bahan }}" data-satuan="{{ $item->satuan }}" data-max="{{ $item->stok }}">{{ $item->nama_bahan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm ms-2 remove-row">Hapus Baris</button>
                </div>
                <div class="col-md-4 mt-2 d-flex align-items-center">
                    <div class="input-group">
                        <input type="number" class="form-control" name="jumlah[]" min="0" placeholder="Jumlah" required>
                        <input type="text" class="form-control" name="satuan[]" placeholder="Satuan" readonly>
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date().toISOString().split('T')[0]; // Mengambil tanggal hari ini dalam format YYYY-MM-DD
        document.getElementById('tanggal_pemakaian').setAttribute('min', today);
    });
</script>

</body>
</html>
