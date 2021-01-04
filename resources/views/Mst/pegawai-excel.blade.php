<table>
    <thead>
    <tr>
        <th>NIP</th>
        <th>Nama</th>
        <th>Pangkat Golongan</th>
        <th>Jabatan</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($pegawai as $item)
        <tr>
            <td>{{ $item->nip }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->pangkat_golongan->name }}</td>
            <td>{{ $item->jabatan->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>