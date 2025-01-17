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
            'judul_website' => 'Zako',
            'logo' => 'logo.png',
            'deskripsi' => 'ashiap zaky bin fery',
            'alamat' => 'Jl. Karadenan No. 7',
            'email' => 'zaky@gmail.com',
            'telepon' => '081234567890',
            'atas_nama' => 'Achmad Zaky',
            'no_rekening' => '081234567890'
        ]);
    }
}
