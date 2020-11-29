<?php

use App\Repository\SuratPerintah\SuratPerintahStatus;
use Illuminate\Database\Seeder;

class SuratPerintahStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SuratPerintahStatus::create([
            'id' => 1,
            'code' => 'draft',
            'description' => 'Menunggu Persetujuan Ketua Tim',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);



        SuratPerintahStatus::create([
            'id' => 2,
            'code' => 'review_audit',
            'description' => 'Perlu Di Revisi Auditor',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);



        SuratPerintahStatus::create([
            'id' => 3,
            'code' => 'approved_audit',
            'description' => 'Sudah Di Setujui Ketua Tim',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);



        SuratPerintahStatus::create([
            'id' => 4,
            'code' => 'review_nhp',
            'description' => 'Perlu Di Revisi Ketua Tim',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);



        SuratPerintahStatus::create([
            'id' => 5,
            'code' => 'approved_nhp',
            'description' => 'Sudah Di Setujui Pengendali Teknis',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);



        SuratPerintahStatus::create([
            'id' => 6,
            'code' => 'review_lhp',
            'description' => 'Perlu Di Revisi Pengendali Teknis',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);



        SuratPerintahStatus::create([
            'id' => 7,
            'code' => 'approved_lhp',
            'description' => 'Sudah Di Setujui Inspektur',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);
    }
}
