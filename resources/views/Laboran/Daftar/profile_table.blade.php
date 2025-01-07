<table class="table datatable">
    <thead>
        <tr>
            <th>Name</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>No HP</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach($akun as $data)
    @if($data->level == $level)
        <tr>
            <td>{{ ucwords(str_replace('.', ' ', explode('@', $data->email)[0])) }}</td>
            <td>{{ $data->NIM }}</td>
            <td>{{ $data->prodi }}</td>
            <td>{{ $data->no_hp }}</td>
            <td>
                <form action="{{ route('draftpinjammhs') }}" method="GET">
                    <input type="hidden" name="google_id" value="{{ $data->google_id }}">
                    <button type="submit" class="btn btn-warning text-muted"><i class="bi bi-eye"></i> Lihat Peminjaman
                    </button>
                </form>
            </td>
        </tr>
    @endif
@endforeach

    </tbody>
</table>
