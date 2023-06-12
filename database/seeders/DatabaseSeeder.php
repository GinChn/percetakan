<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\Mesin;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
        Mesin::create([
            'jenis_mesin' => 'Indoor'
        ]);

        Mesin::create([
            'jenis_mesin' => 'Outdoor'
        ]);

        Mesin::create([
            'jenis_mesin' => 'Digital Offset'
        ]);

        Bahan::create([
            'nama_bahan' => 'Backlite'
        ]);

        Satuan::create([
            'nama_satuan' => 'Meter'
        ]);

        Satuan::create([
            'nama_satuan' => 'Pcs'
        ]);

        Satuan::create([
            'nama_satuan' => 'Box'
        ]);

        Satuan::create([
            'nama_satuan' => 'Lembar'
        ]);

        Barang::create([
            'nama_barang' => 'Sapnduk',
            'id_bahan' => '1',
            'id_mesin' => '1',
            'id_satuan' => '1',
            'harga' => '20000'
        ]);
    }
}
