@php
    // Mengelompokkan data berdasarkan kode_bahan_pakai
    $groupedData = $alat_pinjam->groupBy('kode_alat_pinjam');
@endphp

<div class="accordion" id="faqAccordion">
    @foreach($groupedData as $kode_alat => $groupedData)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $kode_alat }}">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $kode_alat }}" aria-expanded="true" aria-controls="collapse{{ $kode_alat }}">
                    <div class="d-flex justify-content-between">
                        {{ $kode_alat }} ({{ count($groupedData) }} Data)
                    </div>
                </button>
            </h2>
            
            <div id="collapse{{ $kode_alat }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $kode_alat }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Barang</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Jumlah</th>
                                <th>Tempat</th>
                                <th>Action</th>
                                <th>Selesai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groupedData as $data)
                                @if($data->tanggal_kembali == NULL)
                                    <tr>
                                        <td>{{ $data->nama_alat }}</td>
                                        <td>{{ $data->created_at }}</td>
                                        <td>{{ $data->tanggal_peminjaman }}</td>
                                        <td>{{ $data->jumlah }}</td>
                                        <td>{{ $data->tempat_peminjaman }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $data->id_alat_pinjam }}">
                                                {{ $data->status }}
                                            </button>
                                        </td>
                                        <td>
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
    @endforeach
</div>
