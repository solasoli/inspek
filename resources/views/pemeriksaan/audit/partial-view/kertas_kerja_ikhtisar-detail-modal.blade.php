<div>
    <section>
        <h5>Judul Kondisi</h5>
        <div class='kode_temuan_cover'>
            <br>
            <h6>Kode Temuan</h6>

            @php
            $valueLevelJk1 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 1)->first();
            $valueLevelJk2 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 2)->first();
            $valueLevelJk3 = $data->kode_temuan->where('tipe','judul_kondisi')->where('level', 3)->first();
            @endphp
            <ul class="list-unstyled">
                <li>{{ $valueLevelJk1->kode_temuan->kode }}. {{ $valueLevelJk1->kode_temuan->temuan }}</li>
                <li>{{ !is_null($valueLevelJk2) ? $valueLevelJk2->kode_temuan->kode : ''}}. {{ !is_null($valueLevelJk2) ? $valueLevelJk2->kode_temuan->temuan : ''}}</li>
                <li>{{ !is_null($valueLevelJk3) ? $valueLevelJk3->kode_temuan->kode : ''}}. {{ !is_null($valueLevelJk3) ? $valueLevelJk3->kode_temuan->temuan : ''}}</li>
            </ul>
        </div>
        <h6>Judul Kondisi</h6>
        {!! $data->judul_kondisi !!}
    </section>
    <hr>
    <section>
        <h5>Uraian Kondisi</h5>
        <div class='kode_temuan_cover'>
            <br>
            <h6>Kode Temuan</h6>
            @php
            $valueLevelUk1 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 1)->first();
            $valueLevelUk2 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 2)->first();
            $valueLevelUk3 = $data->kode_temuan->where('tipe','uraian_kondisi')->where('level', 3)->first();

            @endphp
            <ul class="list-unstyled">
                <li>{{ $valueLevelUk1->kode_temuan->kode }}. {{ $valueLevelUk1->kode_temuan->temuan }}</li>
                <li>{{ !is_null($valueLevelUk2) ? $valueLevelUk2->kode_temuan->kode : ''}}. {{ !is_null($valueLevelUk2) ? $valueLevelUk2->kode_temuan->temuan : ''}}</li>
                <li>{{ !is_null($valueLevelUk3) ? $valueLevelUk3->kode_temuan->kode : ''}}. {{ !is_null($valueLevelUk3) ? $valueLevelUk3->kode_temuan->temuan : ''}}</li>
            </ul>
        </div>
        <h6>Uraian Kondisi</h6>
        {!! $data->uraian_kondisi !!}
    </section>
    <hr>
    <section>
        <h5>Kriteria</h5>
        {!! $data->kriteria !!}
    </section>
    <hr>
    <section>
        <h5>Sebab</h5>
        {!! $data->sebab !!}
    </section>
    <hr>
    <section>
        <h5>Akibat</h5>
        {!! $data->akibat !!}
    </section>
    <hr>
    <section>
        <h5>Rekomendasi</h5>
        <br>
        <div class='kode_rekomendasi_cover'>
            <h6>Kode Rekomendasi</h6>
            @php
            $valueLevelKk1 = $data->kode_rekomendasi->where('level', 1)->first();
            $valueLevelKk2 = $data->kode_rekomendasi->where('level', 2)->first();
            @endphp
            <ul class="list-unstyled">
                <li>{{ $valueLevelKk1->kode_rekomendasi->kode }}. {{ $valueLevelKk1->kode_rekomendasi->rekomendasi }}
                </li>
                <li>{{ $valueLevelKk2->kode_rekomendasi->kode }}. {{ $valueLevelKk2->kode_rekomendasi->rekomendasi }}
                </li>
            </ul>
        </div>
        <h6>Rekomendasi</h6>
        {!! $data->rekomendasi !!}
    </section>

</div>
