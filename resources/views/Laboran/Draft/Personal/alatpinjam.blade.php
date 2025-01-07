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
    @foreach($alat_pinjam as $data)
    @if($data->tanggal_kembali==NULL)
        <tr>
            <td>{{ $data->nama_alat }}</td>
            <td>{{ $data->created_at }}</td>
            <td>{{ $data->tanggal_peminjaman}}</td>
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
