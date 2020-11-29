<?php

use Illuminate\Database\Seeder;
use App\Repository\ACL\Menu;

class MenuSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {

    Menu::create([
      'id' => 1,
      'id_parent' => 0,
      'have_child' => 1,
      'level' => 1,
      'nama' => 'Master',
      'url' => '#',
      'slug' => 'mst',
      'created_at' => '2020-11-10 13:08:43',
      'created_by' => 1,
      'updated_at' => '2020-11-10 13:08:43',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 2,
      'id_parent' => 1,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Perangkat Daerah',
      'url' => '/mst/skpd',
      'slug' => 'mst_skpd',
      'created_at' => '2020-11-10 13:09:18',
      'created_by' => 1,
      'updated_at' => '2020-11-10 13:09:18',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 3,
      'id_parent' => 1,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Data Pegawai',
      'url' => '/mst/pegawai',
      'slug' => 'mst_pegawai',
      'created_at' => '2020-11-10 13:09:43',
      'created_by' => 1,
      'updated_at' => '2020-11-10 13:09:43',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 4,
      'id_parent' => 1,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Struktur Organigram',
      'url' => '/mst/struktur',
      'slug' => 'mst_struktur',
      'created_at' => '2020-11-10 13:10:40',
      'created_by' => 1,
      'updated_at' => '2020-11-10 13:10:40',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 5,
      'id_parent' => 1,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Kegiatan',
      'url' => '/mst/kegiatan',
      'slug' => 'mst_kegiatan',
      'created_at' => '2020-11-10 13:10:55',
      'created_by' => 1,
      'updated_at' => '2020-11-10 13:10:55',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 6,
      'id_parent' => 1,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Program Kerja',
      'url' => '/mst/program_kerja',
      'slug' => 'mst_program_kerja',
      'created_at' => '2020-11-10 13:11:21',
      'created_by' => 1,
      'updated_at' => '2020-11-10 13:11:21',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 7,
      'id_parent' => 0,
      'have_child' => 1,
      'level' => 1,
      'nama' => 'Surat Perintah',
      'url' => '#',
      'slug' => 'sp',
      'created_at' => '2020-11-10 14:01:30',
      'created_by' => 1,
      'updated_at' => '2020-11-10 14:01:30',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 8,
      'id_parent' => 7,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Buat Surat Perintah',
      'url' => '/pkpt/surat_perintah',
      'slug' => 'sp_surat_perintah',
      'created_at' => '2020-11-10 14:02:01',
      'created_by' => 1,
      'updated_at' => '2020-11-10 14:03:17',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 9,
      'id_parent' => 7,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Penomeran Surat',
      'url' => '/pkpt/surat_perintah/nomer',
      'slug' => 'sp_penomeran_surat',
      'created_at' => '2020-11-10 16:04:00',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:04:00',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 10,
      'id_parent' => 7,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Kalender Kerja',
      'url' => '/pkpt/surat_perintah/kalendar',
      'slug' => 'sp_kalender_kerja',
      'created_at' => '2020-11-10 16:04:45',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:04:45',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 11,
      'id_parent' => 0,
      'have_child' => 1,
      'level' => 1,
      'nama' => 'Pemeriksaan',
      'url' => '#',
      'slug' => 'pemeriksaan',
      'created_at' => '2020-11-10 16:05:40',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:05:40',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 12,
      'id_parent' => 11,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Penentuan Sasaran Tujuan',
      'url' => '/pemeriksaan/sasaran-tujuan',
      'slug' => 'sasaran_tujuan',
      'created_at' => '2020-11-10 16:07:03',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:07:03',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 13,
      'id_parent' => 11,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Program Kerja Audit',
      'url' => '/pemeriksaan/program-kerja-audit',
      'slug' => 'program_kerja_audit',
      'created_at' => '2020-11-10 16:07:42',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:07:42',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 14,
      'id_parent' => 11,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Melakukan Audit',
      'url' => '/pemeriksaan/audit',
      'slug' => 'audit',
      'created_at' => '2020-11-10 16:09:03',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:09:03',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 15,
      'id_parent' => 11,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Laporan NHP',
      'url' => '/pemeriksaan/laporan_nhp',
      'slug' => 'laporan_nhp',
      'created_at' => '2020-11-10 16:09:40',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:11:08',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 16,
      'id_parent' => 11,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Laporan LHP',
      'url' => '/pemeriksaan/laporan_lhp',
      'slug' => 'laporan_lhp',
      'created_at' => '2020-11-10 16:10:29',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:10:29',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 17,
      'id_parent' => 0,
      'have_child' => 1,
      'level' => 1,
      'nama' => 'Tindak Lanjut',
      'url' => '#',
      'slug' => 'tinjut',
      'created_at' => '2020-11-10 16:12:09',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:13:27',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 18,
      'id_parent' => 17,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Matrik Tindak Lanjut',
      'url' => '/tindak_lanjut/matrik',
      'slug' => 'tindak_lanjut_matrik',
      'created_at' => '2020-11-10 16:13:12',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:13:12',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 20,
      'id_parent' => 0,
      'have_child' => 1,
      'level' => 1,
      'nama' => 'Angka Kredit',
      'url' => '#',
      'slug' => 'angkre',
      'created_at' => '2020-11-10 16:16:49',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:17:02',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 21,
      'id_parent' => 20,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Penilaian Angka Kredit',
      'url' => '/angka-kredit/tim-penilai/penilaian-angka-kredit',
      'slug' => 'angkre_penilaian',
      'created_at' => '2020-11-10 16:18:08',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:18:08',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 22,
      'id_parent' => 0,
      'have_child' => 0,
      'level' => 1,
      'nama' => 'Upload Kode Bank',
      'url' => '/upload_kode_rekening',
      'slug' => 'upload_kode_bank',
      'created_at' => '2020-11-10 16:25:41',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:25:41',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 23,
      'id_parent' => 0,
      'have_child' => 1,
      'level' => 1,
      'nama' => 'RKA',
      'url' => '#',
      'slug' => 'rka',
      'created_at' => '2020-11-10 16:26:16',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:26:16',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 24,
      'id_parent' => 23,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'rka',
      'url' => '/rka',
      'slug' => 'rka_rka',
      'created_at' => '2020-11-10 16:26:41',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:26:41',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);

    Menu::create([
      'id' => 25,
      'id_parent' => 11,
      'have_child' => 0,
      'level' => 2,
      'nama' => 'Penomeran LHP',
      'url' => '/pemeriksaan/laporan_lhp/penomeran_lhp',
      'slug' => 'nomer_lhp',
      'created_at' => '2020-11-10 16:04:00',
      'created_by' => 1,
      'updated_at' => '2020-11-10 16:04:00',
      'updated_by' => 1,
      'deleted_at' => NULL,
      'deleted_by' => 0,
      'is_deleted' => 0
    ]);
  }
}
