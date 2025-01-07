<table class="table datatable">
    <thead>
        <tr>
            <th>Ruangan</th>
            <th>Tanggal Pengajuan</th>
            <th>Waktu</th>
            <th>Tanggal</th>
            <th>Penanggungjawab</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pinjam_ruangan as $data)
        @if($data->status=='tunggu')
                <tr>
                    <td>{{ $data->nama_ruangan }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->jam_mulai }} - {{$data->jam_selesai}}</td>
                    <td>{{ $data->tanggal_peminjaman }}</td>
                    <td>{{ $data->penanggungjawab }}</td>
                    <td>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ruangan{{ $data->id_pinjam_ruangan }}">
                        {{ $data->status}}
</button>
                    </td>
                </tr>
                @endif
        @endforeach
    </tbody>
</table>