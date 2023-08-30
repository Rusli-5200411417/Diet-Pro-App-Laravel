<?php

namespace Database\Seeders;

use App\Models\Laporan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaporanSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Laporan::create([
            // 'id'=> 1,
            'id_user'=> 1,
            'id_makanan'=> 1,
            'jenis'=> 'makan siang',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
    }
}
