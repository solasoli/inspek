<table>
    <thead>
        <tr>
            <th>Irban</th>
            <th>Kegiatan</th>
            <th>Sasaran</th>
            <th>Dari</th>
            <th>Sampai</th>
            @if ($is_avail_no == 1)
                <th>No Surat</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
            <tr>
                <td>{{ $item->wilayah->implode('nama', ', ') }}</td>
                <td>{{ $item->kegiatan->nama }}</td>
                <td>{{ $item->program_kerja->sasaran }}</td>
                <td>{{ date('d-m-Y', strtotime($item->dari)) }}</td>
                <td>{{ date('d-m-Y', strtotime($item->sampai)) }}</td>
                @if ($is_avail_no == 1)
                    <td>{{ $item->no_surat }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
