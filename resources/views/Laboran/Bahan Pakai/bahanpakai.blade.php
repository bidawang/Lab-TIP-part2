<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemakaian Bahan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        @media print {
            #dataTableArea {
                display: none;
            }

            #printableArea {
                display: block;
            }
        }

        .table-responsive {
            margin-top: 1rem;
        }

        /* Adjust table for small screens */
        @media (max-width: 576px) {
            .table-responsive {
                font-size: 0.75rem; /* Adjust font size */
            }

            .table-responsive th,
            .table-responsive td {
                padding: 0.5rem; /* Reduce padding for small screens */
            }

            .table {
                width: 100%; /* Ensure table fills container width */
                display: block; /* Enable horizontal scrolling */
                overflow-x: auto; /* Add horizontal scrollbar if needed */
            }
        }

        /* Style button group */
        .button-group {
            display: flex;
            flex-wrap: wrap; /* Allow buttons to stack on smaller screens */
            gap: 0.5rem;
        }

        .button-group .btn {
            flex: 1;
        }

        @media (min-width: 768px) {
            .button-group {
                justify-content: flex-end; /* Align buttons to the right on larger screens */
            }

            .button-group .btn {
                width: auto;
            }

            .button-group .btn:first-child {
                margin-right: auto; /* Align "Back" button to the left on larger screens */
            }
        }
    </style>
</head>

@php
    // Get the email address of the currently logged-in user
    $email = Auth::user()->email;

    // Split the email to get the username part
    $nameParts = explode('@', $email);

    // Format the username: capitalize the first letter of each word
    $formattedName = ucwords(str_replace('.', ' ', $nameParts[0]));
@endphp

<body>
    @include('auth.header')
    @include('auth.headerbody')
    @include('Laboran/sidebar.side')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Pemakaian Bahan</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active">Home</li>
                    <li class="breadcrumb-item active">Bahan</li>
                    <li class="breadcrumb-item active">Pemakaian Bahan</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            @if(session('success'))
                <div id="alert" class="alert alert-success" onclick="this.style.display='none'">
                    {{ session('success') }}
                </div>
            @endif 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                                <a href="{{ route('bahan') }}" class="btn btn-danger mt-3"><i class="bi bi-arrow-left-circle"></i> Kembali</a>
                                  <a href="{{ route('tambah_pemakaian') }}" class="btn btn-info mt-3"><i class="bi bi-plus-circle"></i> Tambah Pemakaian</a>
                            <!-- Table with stripped rows -->
                            <div id="printableArea" class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Bahan</th>
                                            <th>Jumlah</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bahan_pakai as $data)
                                            @if($data->google_id == Auth::user()->google_id)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->nama_bahan }}</td>
                                                    <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
                                                    <td>{{ $data->status }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
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
