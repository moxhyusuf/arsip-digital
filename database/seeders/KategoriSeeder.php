<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            [
                'nama' => 'SPJ',
                'keterangan' => 'Surat Pertanggungjawaban',
            ],
            [
                'nama' => 'Surat Keterangan Ahli Waris',
                'keterangan' => 'Dokumen keterangan ahli waris',
            ],
            [
                'nama' => 'Izin Mendirikan Bangunan',
                'keterangan' => 'Dokumen izin mendirikan bangunan',
            ],
        ];

        foreach ($kategori as $item) {
            Kategori::create($item);
        }
    }
}
