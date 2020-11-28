<?php

use App\Repository\Pemeriksaan\KertasKerjaStatus;
use Illuminate\Database\Seeder;

class KertasKerjaStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        KertasKerjaStatus::create([
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

        KertasKerjaStatus::create([
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

        KertasKerjaStatus::create([
            'id' => 3,
            'code' => 'approved_audit',
            'description' => 'Telah Disetujui Ketua Tim',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);

        KertasKerjaStatus::create([
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

        KertasKerjaStatus::create([
            'id' => 5,
            'code' => 'approved_nhp',
            'description' => 'Telah Di Setujui Pengendali Teknis',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);

        KertasKerjaStatus::create([
            'id' => 6,
            'code' => 'review_lhp',
            'description' => 'Perlu Di Review Pengendali Teknis',
            'created_at' => NULL,
            'created_by' => 0,
            'updated_at' => NULL,
            'updated_by' => 0,
            'deleted_at' => NULL,
            'deleted_by' => 0,
            'is_deleted' => 0
        ]);

        KertasKerjaStatus::create([
            'id' => 7,
            'code' => 'approved_lhp',
            'description' => 'Telah Di Setujui Inspektur',
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
