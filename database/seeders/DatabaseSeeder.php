<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\Level;
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
        // Level
        Level::create([
            'nama_level' => 'Administrator'
        ]);

        Level::create([
            'nama_level' => 'Manajer'
        ]);

        Level::create([
            'nama_level' => 'Desainer'
        ]);

        Level::create([
            'nama_level' => 'Kasir'
        ]);

        Level::create([
            'nama_level' => 'Operator'
        ]);

        Level::create([
            'nama_level' => 'Pelanggan'
        ]);

        // Mesin
        Mesin::create([
            'jenis_mesin' => 'Indoor'
        ]);

        Mesin::create([
            'jenis_mesin' => 'Outdoor'
        ]);

        Mesin::create([
            'jenis_mesin' => 'Digital Offset'
        ]);

        // Satuan
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
        
        // Bahan
        Bahan::create([
            'nama_bahan' => 'Backlite'
        ]);

        // Barang
        Barang::create([
            'nama_barang' => 'Sapnduk',
            'id_bahan' => '1',
            'id_mesin' => '1',
            'id_satuan' => '1',
            'harga' => '20000'
        ]);
    }
}
