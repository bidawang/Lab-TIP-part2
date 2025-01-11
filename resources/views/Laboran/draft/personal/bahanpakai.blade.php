@php
    // Mengelompokkan data berdasarkan kode_bahan_pakai
    $groupedData = $bahan_pakai->groupBy('kode_bahan_pakai');
@endphp

<div class="accordion" id="accordion">
    @foreach($groupedData as $kode_bahan => $group)
    <div class="accordion-item">
        <h2 class="accordion-header" id="heading{{ $kode_bahan }}">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $kode_bahan }}" aria-expanded="true" aria-controls="collapse{{ $kode_bahan }}">
                <div class="d-flex justify-content-between w-100">
                    <span>{{ $kode_bahan }} ({{ count($group) }} Data)</span>
                </div>
            </button>
        </h2>

        <div id="collapse{{ $kode_bahan }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $kode_bahan }}" data-bs-parent="#accordion">
            <div class="accordion-body">
                <table class="table datatable">
                    <thead>
                        <tr>
                            <th>Bahan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Tanggal Pemakaian</th>
                            <th>Jumlah</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($group as $data)
                        @if($data->status == 'tunggu')
                            <tr>
                                <td>{{ $data->nama_bahan }}</td>
                                <td>{{ $data->created_at }}</td>
                                <td>{{ $data->tanggal_pemakaian }}</td>
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
    @endforeach
</div>
