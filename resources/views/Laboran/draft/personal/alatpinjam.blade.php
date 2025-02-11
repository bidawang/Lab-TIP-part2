@php
    // Mengelompokkan data berdasarkan kode_alat_pinjam
    $groupedData = $alat_pinjam->groupBy('kode_alat_pinjam');
@endphp

<div class="accordion" id="faqAccordion">
    @foreach($groupedData as $kode_alat => $group)
        @php
            // Mengecek apakah semua status dalam grup adalah "selesai"
            $allApproved = $group->every(fn($data) => $data->tanggal_kembali != NULL);
        @endphp

        @if(!$allApproved) <!-- Only show if not all statuses are "selesai" -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $kode_alat }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $kode_alat }}" aria-expanded="true" aria-controls="collapse{{ $kode_alat }}">
                    <div class="d-flex justify-content-between">
                        {{ $kode_alat }} ({{ count($group) }} Data)
                    </div>
                </button>
            </h2>
            
            <div id="collapse{{ $kode_alat }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $kode_alat }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <!-- Menampilkan tanggal dan tempat di atas tabel -->
                    @php
                        $tanggal_pengajuan = $group->first()->created_at;
                        $tanggal_peminjaman = $group->first()->tanggal_peminjaman;
                        $tempat_peminjaman = $group->first()->tempat_peminjaman;
                    @endphp
                    <div class="table-responsive mb-3 align-middle text-center">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Tanggal Peminjaman</th>
                                    <th>Tempat Peminjaman</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $tanggal_pengajuan }}</td>
                                    <td>{{ $tanggal_peminjaman }}</td>
                                    <td>{{ $tempat_peminjaman }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Tabel Data -->
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($group as $data)
                                @if($data->tanggal_kembali == NULL) <!-- Tampilkan hanya yang belum kembali -->
                                    <tr>
                                        <td>{{ $data->nama_alat }}</td>
                                        <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $data->id_alat_pinjam }}">
                                                {{ $data->status }}
                                            </button>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#selesai{{ $data->id_alat_pinjam }}">
                                                Selesai
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    @endforeach
</div>
