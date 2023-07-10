<?php

namespace Database\Seeders;

use App\Models\Bahan;
use App\Models\Level;
use App\Models\Mesin;
use App\Models\Barang;
use App\Models\Satuan;
use App\Models\Status;
use App\Models\Finishing;
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

        // Status Pesanan
        Status::create([
            'status' => 'Belum Selesai'
        ]);

        Status::create([
            'status' => 'Selesai'
        ]);
        
        // Bahan
        Bahan::create([
            'nama_bahan' => 'Backlite'
        ]);

        Bahan::create([
            'nama_bahan' => 'Ap260'
        ]);

        Bahan::create([
            'nama_bahan' => 'Bontax'
        ]);

        // Finishing
        Finishing::create([
            'nama_finishing' => 'Lem Keliling'
        ]);

        Finishing::create([
            'nama_finishing' => 'Lem Ujung'
        ]);

        Finishing::create([
            'nama_finishing' => 'Lebih'
        ]);

        Finishing::create([
            'nama_finishing' => 'Selongsong'
        ]);

        // Barang
        Barang::create([
            'nama_barang' => 'Spanduk',
            'id_bahan' => '1',
            'id_mesin' => '2',
            'satuan' => 'Meter',
            'harga' => '20000'
        ]);

        Barang::create([
            'nama_barang' => 'Ap260',
            'id_bahan' => '2',
            'id_mesin' => '3',
            'satuan' => 'Lembar',
            'harga' => '10000'
        ]);

        Barang::create([
            'nama_barang' => 'Stiker Bontax',
            'id_bahan' => '3',
            'id_mesin' => '3',
            'satuan' => 'Lembar',
            'harga' => '80000'
        ]);
    }
}
