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
// use Illuminate\Foundation\Auth\User;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory()->times(3)->create();
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
            'nama_finishing' => 'Tanpa Finishing'
        ]);

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

        User::create([
            'username' => 'admin@gmail.com',
            'password' => Hash::make('12345'), // password
            'nama' => 'Saya Administrator',
            'tanggal_lahir' => '2000-01-01',
            'alamat' => 'Jalan Maju 1 Kali',
            'no_telp' => '08012028399',
            'pendidikan' => 'SMA',
            'id_level' => 1,
        ]);
        User::create([
            'username' => 'kasir@gmail.com',
            'password' => Hash::make('12345'), // password
            'nama' => 'Saya Kasir',
            'tanggal_lahir' => '2001-01-01',
            'alamat' => 'Jalan Merdeka 17 Agustus',
            'no_telp' => '08276733372',
            'pendidikan' => 'SMK',
            'id_level' => 4,
        ]);
        User::create([
            'username' => 'desainer@gmail.com',
            'password' => Hash::make('12345'), // password
            'nama' => 'Saya Desainer',
            'tanggal_lahir' => '2002-01-01',
            'alamat' => 'Jalan Jembatan Rusak No. 2',
            'no_telp' => '085233332372',
            'pendidikan' => 'SMK',
            'id_level' => 3,
        ]);
        User::create([
            'username' => 'operator@gmail.com',
            'password' => Hash::make('12345'), // password
            'nama' => 'Saya Operator',
            'tanggal_lahir' => '1999-01-01',
            'alamat' => 'Jalan Saja Dulu',
            'no_telp' => '0852309090',
            'pendidikan' => 'SMK',
            'id_level' => 5,
        ]);
        User::create([
            'username' => 'manajer@gmail.com',
            'password' => Hash::make('12345'), // password
            'nama' => 'Saya Manajer',
            'tanggal_lahir' => '1998-01-01',
            'alamat' => 'Jalan Menara No.90',
            'no_telp' => '08523090888',
            'pendidikan' => 'S1 Hukum',
            'id_level' => 2,
        ]);
    }
}