@php
    // Mengelompokkan data berdasarkan kode_bahan_pakai
    $groupedData = $bahan_pakai->groupBy('kode_bahan_pakai');
@endphp
<div class="accordion" id="faqAccordion">
    @foreach($groupedData as $kode_bahan => $group)
        @php
            // Mengecek apakah semua status dalam grup adalah "Disetujui"
            $allApproved = $group->every(fn($data) => $data->status === 'Disetujui');
        @endphp

        @if(!$allApproved)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $kode_bahan }}">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $kode_bahan }}" aria-expanded="true" aria-controls="collapse{{ $kode_bahan }}">
                        <div class="d-flex justify-content-between">
                            {{ $kode_bahan }} ({{ count($group) }} Data)
                        </div>
                    </button>
                </h2>
                
                <div id="collapse{{ $kode_bahan }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $kode_bahan }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        <!-- Menampilkan tanggal pengajuan dan pemakaian di atas tabel -->
                        @php
                            $tanggal_pengajuan = $group->first()->created_at;
                            $tanggal_pemakaian = $group->first()->tanggal_pemakaian;
                        @endphp
                        <div class="table-responsive mb-3 text-center">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pengajuan</th>
                                        <th>Tanggal Pemakaian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $tanggal_pengajuan }}</td>
                                        <td>{{ $tanggal_pemakaian }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Tabel Data -->
                        <table class="table table-bordered text-center align-middle">
                            <thead>
                                <tr>
                                    <th>Bahan</th>
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group as $data)
                                    @if($data->status == 'tunggu')
                                        <tr>
                                            <td>{{ $data->nama_bahan }}</td>
                                            <td>{{ $data->jumlah }} {{ $data->satuan }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eh{{ $data->id_bahan_pakai }}">
                                                    {{ $data->status }}
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
