<table>
    <thead>
        <tr>
            <th rowspan='2'>Status</th>
            <th rowspan='2'>Kegiatan</th>
            <th rowspan='2'>Irban</th>
            <th rowspan='2'>Perangkat Daerah</th>
            <th rowspan='2'>Dari</th>
            <th rowspan='2'>Sampai</th>
            <th rowspan='2'>Anggaran</th>
            <th colspan='5'>Man Power</th>
        </tr>
        <tr>
            <th>Wakil Penganggung Jawab</th>
            <th>Pengendali Teknis</th>
            <th>Ketua Tim</th>
            <th>Anggota</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($program_kerja as $item)
            <tr>
                <td>{{ $item->type_pkpt == 1 ? 'PKPT' : 'NON-PKPT' }}</td>
                <td>{{ $item->kegiatan->nama }}</td>
                <td>{{ $item->wilayah->nama }}</td>
                <td>{{ $item->skpd->name }}</td>
                <td>{{ date("d-m-Y", strtotime($item->dari)) }}</td>
                <td>{{ date("d-m-Y", strtotime($item->sampai)) }}</td>
                <td>{{ number_format($item->anggaran, 0, ',', '.') }}</td>
                <td>{{ $item->jml_wakil_penanggung_jawab }}</td>
                <td>{{ $item->jml_pengendali_teknis }}</td>
                <td>{{ $item->jml_ketua_tim }}</td>
                <td>{{ $item->jml_anggota }}</td>
                <td>{{ $item->jml_man_power }}</td>
            </tr>
        @endforeach
    </tbody>
</table>