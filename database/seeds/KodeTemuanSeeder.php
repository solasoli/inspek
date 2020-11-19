<?php

use App\Repository\Master\KodeRekomendasi;
use Illuminate\Database\Seeder;
use App\Repository\Master\KodeTemuan;

class KodeTemuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KodeTemuan::create([
            'id' => '1',
            'level' => '1',
            'id_parent' => '0',
            'kode' => '1',
            'temuan' => 'Temuan Ketidakpatuhan Terhadap Peraturan'
        ]);

        KodeTemuan::create([
            'id' => '2',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '01',
            'temuan' => 'Kerugian negara/daerah atau kerugian negara/daerah yang terjadi pada perusahaan milik negara/daerah'
        ]);

        KodeTemuan::create([
            'id' => '3',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '01',
            'temuan' => 'Belanja dan/atau pengadaan barang/jasa fiktif'
        ]);

        KodeTemuan::create([
            'id' => '4',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '02',
            'temuan' => 'Rekanan pengadaan barang/jasa tidak menyelesaikan pekerjaan'
        ]);

        KodeTemuan::create([
            'id' => '5',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '03',
            'temuan' => 'Kekurangan volume pekerjaan dan/atau barang'
        ]);

        KodeTemuan::create([
            'id' => '6',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '04',
            'temuan' => 'Kelebihan pembayaran selain kekurangan volume pekerjaan dan/atau barang'
        ]);

        KodeTemuan::create([
            'id' => '7',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '05',
            'temuan' => 'Pemahalan harga (Mark up)'
        ]);

        KodeTemuan::create([
            'id' => '8',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '06',
            'temuan' => 'Penggunaan uang/barang untuk kepentingan pribadi'
        ]);

        KodeTemuan::create([
            'id' => '9',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '07',
            'temuan' => 'Pembayaran honorarium dan/atau biaya perjalanan dinas ganda dan/atau melebihi standar yang ditetapkan'
        ]);

        KodeTemuan::create([
            'id' => '10',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '08',
            'temuan' => 'Spesifikasi barang/jasa yang diterima tidak sesuai dengankontrak'
        ]);

        KodeTemuan::create([
            'id' => '11',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '09',
            'temuan' => 'Belanja tidak sesuai atau melebihi ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '12',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '10',
            'temuan' => 'Pengembalian pinjaman/piutang atau dana bergulir macet'
        ]);

        KodeTemuan::create([
            'id' => '13',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '11',
            'temuan' => 'Kelebihan penetapan dan pembayaran restitusi pajak atau penetapan kompensasi kerugian'
        ]);

        KodeTemuan::create([
            'id' => '14',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '12',
            'temuan' => 'Penjualan/pertukaran/penghapusan aset negara/daerah tidak sesuai ketentuan dan merugikan negara/daerah'
        ]);

        KodeTemuan::create([
            'id' => '15',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '13',
            'temuan' => 'Pengenaan ganti kerugian negara belum/tidak dilaksanakan sesuai ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '16',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '14',
            'temuan' => 'Entitas belum/tidak melaksanakan tuntutan perbendaharaan (TP) sesuai ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '17',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '15',
            'temuan' => 'Penghapusan hak tagih tidak sesuai ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '18',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '16',
            'temuan' => 'Pelanggaran ketentuan pemberian diskon penjualan'
        ]);

        KodeTemuan::create([
            'id' => '19',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '17',
            'temuan' => 'Penentuan HPP (harga pokok pembelian) terlalu rendah sehingga penentuan harga jual lebih rendah dari yang seharusnya'
        ]);

        KodeTemuan::create([
            'id' => '20',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '18',
            'temuan' => 'Jaminan pelaksanaan dalam pelaksanaan pekerjaan, pemanfaatan barang dan pemberian fasilitas tidak dapat dicairkan'
        ]);

        KodeTemuan::create([
            'id' => '21',
            'level' => '3',
            'id_parent' => '2',
            'kode' => '19',
            'temuan' => 'Penyetoran penerimaan negara/daerah dengan bukti fiktif'
        ]);

        KodeTemuan::create([
            'id' => '22',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '02',
            'temuan' => 'Potensi kerugian negara/daerah atau kerugian negara/daerah yang terjadi pada perusahaan milik negara/daerah'
        ]);

        KodeTemuan::create([
            'id' => '23',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '01',
            'temuan' => 'Kelebihan pembayaran dalam pengadaan barang/jasa tetapi pembayaran pekerjaan belum dilakukan sebagian atau seluruhnya'
        ]);

        KodeTemuan::create([
            'id' => '24',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '02',
            'temuan' => 'Rekanan belum melaksanakan kewajiban pemeliharaan barang hasil pengadaan yang telah rusak selama masa pemeliharaan'
        ]);

        KodeTemuan::create([
            'id' => '25',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '03',
            'temuan' => 'Aset dikuasai pihak lain'
        ]);

        KodeTemuan::create([
            'id' => '26',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '04',
            'temuan' => 'Pembelian aset yang berstatus sengketa'
        ]);

        KodeTemuan::create([
            'id' => '27',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '05',
            'temuan' => 'Aset tidak diketahui keberadaannya'
        ]);

        KodeTemuan::create([
            'id' => '28',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '06',
            'temuan' => 'Pemberian jaminan pelaksanaan dalam pelaksanaan pekerjaan, pemanfaatan barang dan pemberian fasilitas tidak sesuai ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '29',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '07',
            'temuan' => 'Pihak ketiga belum melaksanakan kewajiban untuk menyerahkan aset kepada negara/daerah'
        ]);

        KodeTemuan::create([
            'id' => '30',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '08',
            'temuan' => 'Piutang/pinjaman atau dana bergulir yang berpotensi tidak tertagih'
        ]);

        KodeTemuan::create([
            'id' => '31',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '09',
            'temuan' => 'Penghapusan piutang tidak sesuai ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '32',
            'level' => '3',
            'id_parent' => '22',
            'kode' => '10',
            'temuan' => 'Pencairan anggaran pada akhir tahun anggaran untuk pekerjaan yang belum selesai'
        ]);

        KodeTemuan::create([
            'id' => '33',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '03',
            'temuan' => 'Kekurangan penerimaan negara/daerah atau perusahaan milik negara/ daerah'
        ]);

        KodeTemuan::create([
            'id' => '34',
            'level' => '3',
            'id_parent' => '33',
            'kode' => '01',
            'temuan' => 'Penerimaan negara/daerah atau denda keterlambatan pekerjaan belum/tidak ditetapkan dipungut/diterima/disetor ke kas negara/ daerah atau perusahaan milik negara/daerah'
        ]);

        KodeTemuan::create([
            'id' => '35',
            'level' => '3',
            'id_parent' => '33',
            'kode' => '02',
            'temuan' => 'Penggunaan langsung penerimaan negara/daerah
            '
        ]);

        KodeTemuan::create([
            'id' => '36',
            'level' => '3',
            'id_parent' => '33',
            'kode' => '03',
            'temuan' => 'Dana Perimbangan yang telah ditetapkan belum masuk ke kas daerah'
        ]);

        KodeTemuan::create([
            'id' => '37',
            'level' => '3',
            'id_parent' => '33',
            'kode' => '04',
            'temuan' => 'Penerimaan negara/daerah diterima atau digunakan oleh instansi yang tidak berhak'
        ]);

        KodeTemuan::create([
            'id' => '38',
            'level' => '3',
            'id_parent' => '33',
            'kode' => '05',
            'temuan' => 'Pengenaan tarif pajak/PNBP lebih rendah dari ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '39',
            'level' => '3',
            'id_parent' => '33',
            'kode' => '06',
            'temuan' => 'Koreksi perhitungan bagi hasil dengan KKKS'
        ]);

        KodeTemuan::create([
            'id' => '40',
            'level' => '3',
            'id_parent' => '33',
            'kode' => '07',
            'temuan' => 'Kelebihan pembayaran subsidi oleh pemerintah
            '
        ]);

        KodeTemuan::create([
            'id' => '41',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '04',
            'temuan' => 'Administrasi'
        ]);

        KodeTemuan::create([
            'id' => '42',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '01',
            'temuan' => 'Pertanggungjawaban tidak akuntabel (bukti tidak lengkap/tidak valid)'
        ]);

        KodeTemuan::create([
            'id' => '43',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '02',
            'temuan' => 'Pekerjaan dilaksanakan mendahului kontrak atau penetapan anggaran'
        ]);

        KodeTemuan::create([
            'id' => '44',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '03',
            'temuan' => 'Proses pengadaan barang/jasa tidak sesuai ketentuan (tidak menimbulkan kerugian negara'
        ]);

        KodeTemuan::create([
            'id' => '45',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '04',
            'temuan' => 'Pemecahan kontrak untuk menghindari pelelangan'
        ]);

        KodeTemuan::create([
            'id' => '46',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '05',
            'temuan' => 'Pelaksanaan lelang secara performa'
        ]);

        KodeTemuan::create([
            'id' => '47',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '06',
            'temuan' => 'Penyimpangan terhadap peraturan perundang-undangan bidang pengelolaan perlengkapan atau barang milik negara/daerah/perusahaan'
        ]);

        KodeTemuan::create([
            'id' => '48',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '07',
            'temuan' => 'Penyimpangan terhadap peraturan perundang-undangan bidang tertentu lainnya seperti kehutanan, pertambangan, perpajakan, dll'
        ]);

        KodeTemuan::create([
            'id' => '49',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '08',
            'temuan' => 'Koreksi perhitungan subsidi/kewajiban pelayanan umum'
        ]);

        KodeTemuan::create([
            'id' => '50',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '09',
            'temuan' => 'Pembentukan cadangan piutang, perhitungan penyusutan atau amortisasi tidak sesuai ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '51',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '10',
            'temuan' => 'Penyetoran penerimaan negara/daerah atau kas di bendaharawan ke kas negara/daerah melebihi batas waktu yang ditentukan'
        ]);

        KodeTemuan::create([
            'id' => '52',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '11',
            'temuan' => 'Pertanggung jawaban / penyetoran uang persediaan melebihi batas waktu yang ditentukan'
        ]);

        KodeTemuan::create([
            'id' => '53',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '12',
            'temuan' => 'Sisa kas di bendahara pengeluaran akhir tahun anggaran belum/tidak disetor ke kas negara/daerah'
        ]);

        KodeTemuan::create([
            'id' => '54',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '13',
            'temuan' => 'Pengeluaran investasi pemerintah tidak didukung bukti yang sah'
        ]);

        KodeTemuan::create([
            'id' => '55',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '14',
            'temuan' => 'Kepemilikan aset tidak/belum didukung bukti yang sah'
        ]);

        KodeTemuan::create([
            'id' => '56',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '15',
            'temuan' => 'Pengalihan anggaran antar MAK tidak sah
            '
        ]);

        KodeTemuan::create([
            'id' => '57',
            'level' => '3',
            'id_parent' => '41',
            'kode' => '16',
            'temuan' => 'Pelampauan pagu anggaran'
        ]);

        KodeTemuan::create([
            'id' => '58',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '05',
            'temuan' => 'Indikasi tindak pidana'
        ]);

        KodeTemuan::create([
            'id' => '59',
            'level' => '3',
            'id_parent' => '58',
            'kode' => '01',
            'temuan' => 'Indikasi tindak pidana korupsi'
        ]);

        KodeTemuan::create([
            'id' => '60',
            'level' => '3',
            'id_parent' => '58',
            'kode' => '02',
            'temuan' => 'Indikasi tindak pidana perbankan'
        ]);

        KodeTemuan::create([
            'id' => '61',
            'level' => '3',
            'id_parent' => '58',
            'kode' => '03',
            'temuan' => 'Indikasi tindak pidana perpajakan
            '
        ]);

        KodeTemuan::create([
            'id' => '62',
            'level' => '3',
            'id_parent' => '58',
            'kode' => '04',
            'temuan' => 'Indikasi tindak pidana kepabeanan'
        ]);

        KodeTemuan::create([
            'id' => '63',
            'level' => '3',
            'id_parent' => '58',
            'kode' => '05',
            'temuan' => 'Indikasi tindak pidana pasar modal'
        ]);

        KodeTemuan::create([
            'id' => '64',
            'level' => '3',
            'id_parent' => '58',
            'kode' => '06',
            'temuan' => 'Indikasi tindak pidana khusus lainnya'
        ]);

        KodeTemuan::create([
            'id' => '65',
            'level' => '1',
            'id_parent' => '0',
            'kode' => '2',
            'temuan' => 'Temuan kelemahan sistem pengendalian intern'
        ]);

        KodeTemuan::create([
            'id' => '66',
            'level' => '2',
            'id_parent' => '65',
            'kode' => '01',
            'temuan' => 'Kelemahan sistem pengendalian akuntansi dan pelaporan'
        ]);

        KodeTemuan::create([
            'id' => '67',
            'level' => '3',
            'id_parent' => '66',
            'kode' => '01',
            'temuan' => 'Pencatatan tidak/belum dilakukan atau tidak akurat'
        ]);

        KodeTemuan::create([
            'id' => '68',
            'level' => '3',
            'id_parent' => '66',
            'kode' => '02',
            'temuan' => 'Proses penyusunan laporan tidak sesuai ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '69',
            'level' => '3',
            'id_parent' => '66',
            'kode' => '03',
            'temuan' => 'Entitas terlambat menyampaikan laporan'
        ]);

        KodeTemuan::create([
            'id' => '70',
            'level' => '3',
            'id_parent' => '66',
            'kode' => '04',
            'temuan' => 'Sistem informasi akuntansi dan pelaporan tidak memadai'
        ]);

        KodeTemuan::create([
            'id' => '71',
            'level' => '3',
            'id_parent' => '66',
            'kode' => '05',
            'temuan' => 'Sistem informasi akuntansi dan pelaporan belum didukung SDM yang memadai'
        ]);

        KodeTemuan::create([
            'id' => '72',
            'level' => '2',
            'id_parent' => '65',
            'kode' => '02',
            'temuan' => 'Kelemahan sistem pengendalian pelaksanaan anggaran pendapatan dan belanja'
        ]);

        KodeTemuan::create([
            'id' => '73',
            'level' => '3',
            'id_parent' => '72',
            'kode' => '01',
            'temuan' => 'Perencanaan kegiatan tidak memadai'
        ]);

        KodeTemuan::create([
            'id' => '74',
            'level' => '3',
            'id_parent' => '72',
            'kode' => '02',
            'temuan' => 'Mekanisme pemungutan, penyetoran dan pelaporan serta penggunaan Penerimaan negara/daerah/perusahaan dan hibah tidak sesuai ketentuan'
        ]);

        KodeTemuan::create([
            'id' => '75',
            'level' => '3',
            'id_parent' => '72',
            'kode' => '03',
            'temuan' => 'Penyimpangan terhadap peraturan perundang-undangan bidang teknis tertentu atau ketentuan intern organisasi yang diperiksa tentang pendapatan dan belanja'
        ]);

        KodeTemuan::create([
            'id' => '76',
            'level' => '3',
            'id_parent' => '72',
            'kode' => '04',
            'temuan' => 'Pelaksanaan belanja di luar mekanisme APBN/APBD'
        ]);

        KodeTemuan::create([
            'id' => '77',
            'level' => '3',
            'id_parent' => '72',
            'kode' => '05',
            'temuan' => 'Penetapan/pelaksanaan kebijakan tidak tepat atau belum dilakukan berakibat hilangnya potensi penerimaan/pendapatan'
        ]);

        KodeTemuan::create([
            'id' => '78',
            'level' => '3',
            'id_parent' => '72',
            'kode' => '06',
            'temuan' => 'Penetapan/pelaksanaan kebijakan tidak tepat atau belum dilakukan berakibat peningkatan biaya /belanja'
        ]);

        KodeTemuan::create([
            'id' => '79',
            'level' => '3',
            'id_parent' => '72',
            'kode' => '07',
            'temuan' => 'Kelemahan pengelolaan fisik aset'
        ]);

        KodeTemuan::create([
            'id' => '80',
            'level' => '2',
            'id_parent' => '65',
            'kode' => '03',
            'temuan' => 'Kelemahan struktur pengendalian intern'
        ]);

        KodeTemuan::create([
            'id' => '81',
            'level' => '3',
            'id_parent' => '80',
            'kode' => '01',
            'temuan' => 'Entitas tidak memiliki SOP yang formal untuk suatu prosedur atau keseluruhan prosedur'
        ]);

        KodeTemuan::create([
            'id' => '82',
            'level' => '3',
            'id_parent' => '80',
            'kode' => '02',
            'temuan' => 'SOP yang ada pada entitas tidak berjalan secara optimal atau tidak ditaati'
        ]);

        KodeTemuan::create([
            'id' => '83',
            'level' => '3',
            'id_parent' => '80',
            'kode' => '03',
            'temuan' => 'Entitas tidak memiliki satuan pengawas intern'
        ]);

        KodeTemuan::create([
            'id' => '84',
            'level' => '3',
            'id_parent' => '80',
            'kode' => '04',
            'temuan' => 'Satuan pengawas intern yang ada tidak memadai atau tidak berjalan optimal'
        ]);

        KodeTemuan::create([
            'id' => '85',
            'level' => '3',
            'id_parent' => '80',
            'kode' => '05',
            'temuan' => 'Tidak ada pemisahan tugas dan fungsi yang memadai'
        ]);

        KodeTemuan::create([
            'id' => '86',
            'level' => '1',
            'id_parent' => '0',
            'kode' => '3',
            'temuan' => 'Temuan 3E'
        ]);

        KodeTemuan::create([
            'id' => '87',
            'level' => '2',
            'id_parent' => '86',
            'kode' => '01',
            'temuan' => 'Ketidakhematan/pemborosan/ketidakekonomisan'
        ]);

        KodeTemuan::create([
            'id' => '88',
            'level' => '3',
            'id_parent' => '87',
            'kode' => '01',
            'temuan' => 'Pengadaan barang/jasa melebihi kebutuhan'
        ]);

        KodeTemuan::create([
            'id' => '89',
            'level' => '3',
            'id_parent' => '87',
            'kode' => '02',
            'temuan' => 'Penetapan kualitas dan kuantitas barang/jasa yang digunakan tidak sesuai standar'
        ]);

        KodeTemuan::create([
            'id' => '90',
            'level' => '3',
            'id_parent' => '87',
            'kode' => '03',
            'temuan' => 'Pemborosan keuangan negara/daerah/perusahaan atau kemahalan harga'
        ]);

        KodeTemuan::create([
            'id' => '91',
            'level' => '2',
            'id_parent' => '86',
            'kode' => '02',
            'temuan' => 'Ketidakefisienan'
        ]);

        KodeTemuan::create([
            'id' => '92',
            'level' => '3',
            'id_parent' => '91',
            'kode' => '01',
            'temuan' => 'Penggunaan kuantitas input untuk satu satuan output lebih besar/tinggi dari yang seharusnya'
        ]);

        KodeTemuan::create([
            'id' => '93',
            'level' => '3',
            'id_parent' => '91',
            'kode' => '02',
            'temuan' => 'Penggunaan kualitas input untuk satu satuan output lebih tinggi dari seharusnya'
        ]);

        KodeTemuan::create([
            'id' => '94',
            'level' => '2',
            'id_parent' => '86',
            'kode' => '03',
            'temuan' => 'Ketidakefektifan'
        ]);

        KodeTemuan::create([
            'id' => '95',
            'level' => '3',
            'id_parent' => '94',
            'kode' => '01',
            'temuan' => 'Penggunaan anggaran tidak tepat sasaran/tidak sesuai peruntukan'
        ]);

        KodeTemuan::create([
            'id' => '96',
            'level' => '3',
            'id_parent' => '94',
            'kode' => '02',
            'temuan' => 'Pemanfaatan barang/jasa dilakukan tidak sesuai dengan rencana yang ditetapkan'
        ]);

        KodeTemuan::create([
            'id' => '97',
            'level' => '3',
            'id_parent' => '94',
            'kode' => '03',
            'temuan' => 'Barang yang dibeli belum/tidak dapat dimanfaatkan'
        ]);

        KodeTemuan::create([
            'id' => '98',
            'level' => '3',
            'id_parent' => '94',
            'kode' => '04',
            'temuan' => 'Pemanfaatan barang/jasa tidak berdampak terhadap pencapaian tujuan organisasi'
        ]);

        KodeTemuan::create([
            'id' => '99',
            'level' => '3',
            'id_parent' => '94',
            'kode' => '05',
            'temuan' => 'Pelaksanaan kegiatan terlambat/terhambat sehingga mempengaruhi pencapaian tujuan organisasi'
        ]);

        KodeTemuan::create([
            'id' => '100',
            'level' => '3',
            'id_parent' => '94',
            'kode' => '06',
            'temuan' => 'Pelayanan kepada masyarakat tidak optimal'
        ]);

        KodeTemuan::create([
            'id' => '101',
            'level' => '3',
            'id_parent' => '94',
            'kode' => '07',
            'temuan' => 'Fungsi atau tugas instansi yang diperiksa tidak diselenggarakan dengan baik termasuk target penerimaan tidak tercapai'
        ]);

        KodeRekomendasi::create([
            'id' => '102',
            'level' => '3',
            'id_parent' => '94',
            'kode' => '08',
            'rekomendasi' => 'Penggunaan biaya promosi/pemasaran tidak efektif'
        ]);

        KodeRekomendasi::create([
            'id' => '1',
            'level' => '1',
            'id_parent' => '0',
            'kode' => '00',
            'rekomendasi' => 'Kode Rekomendasi'
        ]);

        KodeRekomendasi::create([
            'id' => '2',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '01',
            'rekomendasi' => 'Penyetoran ke kas negara/daerah, kas BUMN/D, dan masyararakat'
        ]);

        KodeRekomendasi::create([
            'id' => '3',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '02',
            'rekomendasi' => 'Pengembalian barang kepada negara, daerah, BUMN/D, dan masyarakat'
        ]);

        KodeRekomendasi::create([
            'id' => '4',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '03',
            'rekomendasi' => 'Perbaikan fisik barang/jasa dalam proses pembangunan atau penggantian barang/jasa oleh rekanan'
        ]);

        KodeRekomendasi::create([
            'id' => '5',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '04',
            'rekomendasi' => 'Penghapusan barang milik negara/daerah '
        ]);

        KodeRekomendasi::create([
            'id' => '6',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '05',
            'rekomendasi' => 'Pelaksanaan sanksi administrasi kepegawaian '
        ]);

        KodeRekomendasi::create([
            'id' => '7',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '06',
            'rekomendasi' => 'Perbaikan laporan dan penertiban administrasi/kelengkapan administrasi'
        ]);

        KodeRekomendasi::create([
            'id' => '8',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '07',
            'rekomendasi' => 'Perbaikan sistem dan prosedur akuntansi dan pelaporan'
        ]);

        KodeRekomendasi::create([
            'id' => '9',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '08',
            'rekomendasi' => 'Peningkatan kualitas dan kuantitas sumber daya manusia pendukung sistem pengendalian'
        ]);

        KodeRekomendasi::create([
            'id' => '10',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '09',
            'rekomendasi' => 'Perubahan atau perbaikan prosedur, peraturan dan kebijakan '
        ]);

        KodeRekomendasi::create([
            'id' => '11',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '10',
            'rekomendasi' => 'Perubahan atau perbaikan struktur organisasi '
        ]);

        KodeRekomendasi::create([
            'id' => '12',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '11',
            'rekomendasi' => 'Koordinasi antar instansi termasuk juga penyerahan penanganan kasus kepada instansi yang berwenang '
        ]);

        KodeRekomendasi::create([
            'id' => '13',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '12',
            'rekomendasi' => 'Pelaksanaan penelitian oleh tim khusus atau audit lanjutan oleh unit pengawas intern '
        ]);

        KodeRekomendasi::create([
            'id' => '14',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '13',
            'rekomendasi' => 'Pelaksanaan sosialisasi '
        ]);

        KodeRekomendasi::create([
            'id' => '15',
            'level' => '2',
            'id_parent' => '1',
            'kode' => '14',
            'rekomendasi' => 'Lain-lain'
        ]);
    }
}
