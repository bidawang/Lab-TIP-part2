@include('auth.header')
<body>
@include('auth.headerbody')

@php
    $email = Auth::user()->email;
    $nameParts = explode('@', $email);
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
    use Carbon\Carbon;
@endphp

@include('Laboran/sidebar.side')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Print Surat Permohonan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Home</li>
                <li class="breadcrumb-item active">Print Surat</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <a href="{{ route('ruangpjm')}}" class="btn btn-danger mt-3 mb-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>

                        @php
    $inputDate = request('tanggal') ?? \Carbon\Carbon::now()->toDateString();
@endphp
                        <!-- Filter Form -->
                        <form action="{{ route('ruangpjm.filter') }}" method="POST">
                          @csrf
                          <input type="date" name="tanggal" value="{{ $inputDate }}" required>
                          <button type="submit">Filter</button>
                      </form>
                      

                      <div id="printableArea">
                        @if($ruangpjm->isEmpty())
                            <p>Tidak ada peminjaman di tanggal {{ $inputDate }}</p>
                        @else 
                        <h4 class="text-end">Pelaihari, {{ \Carbon\Carbon::parse($inputDate)->isoFormat('DD MMMM YYYY') }}</h4>
                    
                        <h5>Hal: Penggunaan Laboratorium</h5>
                        <br>
                        <h5>Kepada</h5>
                        <h5>Kepala Laboratorium Agroindustri</h5>
                        <h5>Di-</h5>
                        <p>Tempat</p>
                        <p>Dengan hormat,</p>
                    
                        
                            <p>
                                Sehubungan dengan penelitian/pengabdian kepada masyarakat yang akan dilakukan guna menyelesaikan
                                @foreach($ruangpjm as $data)
                                    @if (session('level') == 'Mahasiswa' && $data->status == 'Disetujui' && $data->google_id == Auth::user()->google_id)
                                        @if($data->tipe_peminjaman == 'TA')
                                            {{ $data->tipe_peminjaman }}
                                        @else
                                            {{ $data->tipe_peminjaman }} {{ $data->mata_kuliah }}
                                        @endif
                                    @endif
                                @endforeach
                                , maka dengan ini:
                            </p>
                    
                            <div class="mb-2 mx-auto">
                                <table class="table table-borderless w-100">
                                    <tbody>
                                        <tr>
                                            <td class="text-start" style="width: 30%;">Nama</td>
                                            <td class="text-start">: {{$formattedName}}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">NIM</td>
                                            <td class="text-start">: {{ auth::user()->NIM }}</td>
                                        </tr>
                                        <tr>
                                            <td class="text-start">Program Studi</td>
                                            <td class="text-start">: {{ auth::user()->prodi }}</td>
                                        </tr>
                                        @foreach($ruangpjm as $data)
                                            @if (session('level') == 'Mahasiswa' && $data->status == 'Disetujui' && $data->google_id == Auth::user()->google_id)
                                                <tr>
                                                    <td class="text-start">Judul</td>
                                                    <td class="text-start">: {{$data->keperluan}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                    
                            <br>
                            <div class="d-flex justify-content-between">
                                <div class="text-start">
                                    <p>Pembimbing I</p>
                                    <br><br><br><br><br><br>
                                    <p>Nama: Pembimbing I</p>
                                    <p>NIP: NIP Pembimbing I</p>
                                </div>
                    
                                <div class="text-end">
                                    <p>Mahasiswa</p>
                                    <br><br><br><br><br><br>
                                    <p>Nama: {{$formattedName}}</p>
                                    <p>NIM: {{ auth::user()->NIM }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                        <button onclick="printTable();" class="btn btn-success mt-3">
                            <i class="bi bi-printer"></i> Print Surat
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('auth.footer')

<script>
function printTable() {
    var printContents = document.getElementById('printableArea').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>

</body>
</html>
