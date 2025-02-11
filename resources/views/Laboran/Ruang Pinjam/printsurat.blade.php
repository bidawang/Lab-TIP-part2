<!DOCTYPE html>
<html lang="en">
<head>
@php
    $email = Auth::user()->email;
    $nameParts = explode('@', $email);
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
@endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Surat Permohonan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            line-height: 1.6;
            margin: 2cm;
        }
        .kop-surat {
            display: flex;
            justify-content:space-around;
            margin-bottom: 20px;
        }
        .kop-surat img {
            height: 100px;
            margin-right: 80px;
        }
        .kop-surat div {
            text-align: left;
        }
        .kop-surat h5 {
            margin: 0;
        }
        .line {
            border-top: 2px solid black;
            margin: 10px 0;
        }
        .content {
            margin-top: 20px;
        }
        .signature {
            margin-top: 50px;
        }
        .signature div {
            width: 45%;
        }
        .signature .text-center {
            margin: auto;
        }
        @media print {
            body {
                margin: 0.5cm;
            }
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="kop-surat">
        <img src="data:image/jpeg;base64,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"
        alt="">
        <div>
            <h5>TEKNOLOGI AGROINDUSTRI</h5>
            <p>Jalan Pendidikan No. 123, Pelaihari, Kalimantan Selatan</p>
            <p>Email: info@institutagroindustri.ac.id | Telp: (0512) 345-6789</p>
        </div>
    </div>
    <div class="line"></div>

    <div class="content">
        <h4 class="text-end">Pelaihari, {{ \Carbon\Carbon::now()->isoFormat('DD MMMM YYYY') }}</h4>
        <h5>Hal: Penggunaan Laboratorium</h5>
        <br>
        <h5>Kepada</h5>
        <h5>Kepala Laboratorium Agroindustri</h5>
        <h5>Di-</h5>
        <p>Tempat</p>

        <p>Dengan hormat,</p>

        <p>
            Sehubungan dengan penelitian/pengabdian kepada masyarakat yang akan dilakukan guna menyelesaikan
            @if($ruangpjm->status == 'Disetujui' && $ruangpjm->google_id == Auth::user()->google_id)
                @if($ruangpjm->tipe_peminjaman == 'TA')
                    {{ $ruangpjm->tipe_peminjaman }}
                @else
                    {{ $ruangpjm->tipe_peminjaman }} {{ $ruangpjm->mata_kuliah }}
                @endif
            @endif
            , maka dengan ini:
        </p>

        <div class="mb-2 mx-auto">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td style="width: 30%;">Nama</td>
                        <td>: {{ $formattedName }}</td>
                    </tr>
                    <tr>
                        <td>NIM</td>
                        <td>: {{ auth::user()->NIM }}</td>
                    </tr>
                    <tr>
                        <td>Program Studi</td>
                        <td>: {{ auth::user()->prodi }}</td>
                    </tr>
                    <tr>
                        <td>Keperluan</td>
                        <td>: {{ $ruangpjm->keperluan }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <br>

        <div class="signature d-flex justify-content-between">
            <div class="text-center">
                <p>Pembimbing I</p>
                <br><br><br><br>
                <p>(Nama Pembimbing I)</p>
                <p>NIP: NIP Pembimbing I</p>
            </div>

            <div class="text-center">
                <p>Mahasiswa</p>
                <br><br><br><br>
                <p>{{ $formattedName }}</p>
                <p>NIM: {{ auth::user()->NIM }}</p>
            </div>
        </div>
    </div>

    <button onclick="printTable();" class="btn btn-success mt-3">
        <i class="bi bi-printer"></i> Print Surat
    </button>

    <script>
    function printTable() {
        window.print();
    }
    </script>
</body>
</html>
