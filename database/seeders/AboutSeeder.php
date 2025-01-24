<?php

namespace Database\Seeders;

use App\Models\About;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'judul_website' => 'Toko Sayur',
            'logo' => 'logo.png',
            'deskripsi' => 'Toko Sayur Freshy Fresh',
            'alamat' => 'Jl. Karadenan No. 7',
            'email' => 'rena@gmail.com',
            'telepon' => '081234567890',
            'atas_nama' => 'Rena Adsaef Selis Ramina',
            'no_rekening' => '081234567890'
        ]);
    }
}
