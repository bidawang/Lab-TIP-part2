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
        @foreach($bahan_pakai as $data)
        @if($data->status=='tunggu')
                <tr>
                    <td>{{ $data->nama_bahan }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->tanggal_pemakaian }}</td>
                    <td>{{ $data->jumlah }} {{$data->satuan}}</td>
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