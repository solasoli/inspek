<table>
    <thead>
    <tr>
        <th>Nama PD</th>
        <th>Pimpinan</th>
        <th>Wilayah Kerja</th>
    </tr>
    </thead>
    <tbody>
    @foreach($skpd as $data)
        <tr>
            <td>{{ $data->name }}</td>
            <td>{{ $data->pimpinan }}</td>
            <td>{{ $data->wilayah->nama }}</td>
        </tr>
    @endforeach
    </tbody>
</table>