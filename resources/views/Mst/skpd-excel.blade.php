<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($skpd as $data)
        <tr>
            <td>{{ $data->name }}</td>
            <td>{{ $data->pimpinan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>