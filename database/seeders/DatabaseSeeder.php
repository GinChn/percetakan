<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Kategori;
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
        
        Kategori::create([
            'jenis_mesin' => 'Indoor'
        ]);

        Kategori::create([
            'jenis_mesin' => 'Outdoor'
        ]);

        Kategori::create([
            'jenis_mesin' => 'Digital Offset'
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

        Produk::create([
            'nama_produk' => 'Sapnduk',
            'jenis_bahan' => 'Fl180',
            'id_kategori_mesin' => '1',
            'id_satuan' => '1',
            'harga' => '20000'
        ]);
    }
}
