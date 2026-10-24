<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Schema;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Mengisi tabel photos dengan data foto asli dari proyek React.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('photos')->truncate();
        Schema::enableForeignKeyConstraints();

        $photos = [
            [
                'photo_id'     => 1,
                'title'        => 'Angkutan Pelabuhan',
                'slug'         => 'angkutan-pelabuhan-1',
                'category_id'  => 2, // Pelabuhan
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['angkutan', 'pelabuhan', 'mobil', 'perbukitan']),
                'w'            => 1067,
                'h'            => 1600,
                'price'        => 85000.00,
                'img'          => 'photos/angkutan-pelabuhan.jpg',
                'downloads'    => 0,
                'description'  => 'Foto suasana angkutan logistik dan lalu lintas di kawasan dermaga pelabuhan.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 2,
                'title'        => 'Cerobong Asap Kapal',
                'slug'         => 'cerobong-asap-kapal-2',
                'category_id'  => 2, // Pelabuhan
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['cerobong', 'asap', 'kapal', 'langit']),
                'w'            => 1067,
                'h'            => 1600,
                'price'        => 85000.00,
                'img'          => 'photos/cerobong-asap-kapal.jpg',
                'downloads'    => 0,
                'description'  => 'Cerobong asap kapal feri berlayar melintasi selat dengan latar langit cerah.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 3,
                'title'        => 'Cerobong',
                'slug'         => 'cerobong-3',
                'category_id'  => 2, // Pelabuhan
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['cerobong', 'kapal', 'biru']),
                'w'            => 1067,
                'h'            => 1600,
                'price'        => 85000.00,
                'img'          => 'photos/cerobong.jpg',
                'downloads'    => 0,
                'description'  => 'Detail struktur cerobong kapal feri berlatar biru cerah.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 4,
                'title'        => 'Ibuk Penjual',
                'slug'         => 'ibuk-penjual-4',
                'category_id'  => 1, // Pasar
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['pasar', 'penjual', 'payung', 'motor']),
                'w'            => 1600,
                'h'            => 1067,
                'price'        => 85000.00,
                'img'          => 'photos/ibuk-penjual.jpg',
                'downloads'    => 0,
                'description'  => 'Aktivitas ibu pedagang pasar tradisional di pagi hari dengan payung pelindung.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 5,
                'title'        => 'Meja Dirumput',
                'slug'         => 'meja-dirumput-5',
                'category_id'  => 5, // Alam
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['meja', 'rumput', 'taman', 'pantai']),
                'w'            => 1067,
                'h'            => 1600,
                'price'        => 85000.00,
                'img'          => 'photos/meja-dirumput.jpg',
                'downloads'    => 0,
                'description'  => 'Meja kayu di atas hamparan rumput hijau asri menghadap pesisir.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 6,
                'title'        => 'Memarkir',
                'slug'         => 'memarkir-6',
                'category_id'  => 3, // Jalanan
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['parkir', 'motor', 'hujan', 'pasar']),
                'w'            => 1600,
                'h'            => 1067,
                'price'        => 85000.00,
                'img'          => 'photos/memarkir.jpg',
                'downloads'    => 0,
                'description'  => 'Deretan motor terparkir rapi di bahu jalan raya saat suasana gerimis.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 7,
                'title'        => 'Menunggu',
                'slug'         => 'menunggu-7',
                'category_id'  => 3, // Jalanan
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['menunggu', 'jas hujan', 'warung', 'hujan']),
                'w'            => 1600,
                'h'            => 1067,
                'price'        => 85000.00,
                'img'          => 'photos/menunggu.jpg',
                'downloads'    => 0,
                'description'  => 'Warga berteduh di depan ruko pinggir jalan menunggu hujan reda.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 8,
                'title'        => 'Menyetir',
                'slug'         => 'menyetir-8',
                'category_id'  => 3, // Jalanan
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['menyetir', 'mobil', 'pengemudi', 'hujan']),
                'w'            => 1600,
                'h'            => 1067,
                'price'        => 85000.00,
                'img'          => 'photos/menyetir.jpg',
                'downloads'    => 0,
                'description'  => 'Perspektif dari dalam mobil saat mengemudi di jalanan basah.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 9,
                'title'        => 'Orang Menggunakan Jas Hujan',
                'slug'         => 'orang-menggunakan-jas-hujan-9',
                'category_id'  => 3, // Jalanan
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['jas hujan', 'hujan', 'motor', 'payung']),
                'w'            => 1600,
                'h'            => 1067,
                'price'        => 85000.00,
                'img'          => 'photos/orang-menggunakan-jas-hujan.jpg',
                'downloads'    => 0,
                'description'  => 'Pengendara motor melaju di tengah rintik hujan dengan jas hujan warna-warni.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 10,
                'title'        => 'Pedagang Menyebrang',
                'slug'         => 'pedagang-menyebrang-10',
                'category_id'  => 1, // Pasar
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['pedagang', 'menyebrang', 'jalan', 'hujan']),
                'w'            => 1600,
                'h'            => 1067,
                'price'        => 85000.00,
                'img'          => 'photos/pedagang-menyebrang.jpg',
                'downloads'    => 0,
                'description'  => 'Pedagang pasar tradisional membawa barang dagangan menyeberang jalanan basah.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 11,
                'title'        => 'Pedagang',
                'slug'         => 'pedagang-11',
                'category_id'  => 1, // Pasar
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['pedagang', 'pasar', 'keranjang', 'hujan']),
                'w'            => 1600,
                'h'            => 1067,
                'price'        => 85000.00,
                'img'          => 'photos/pedagang.jpg',
                'downloads'    => 0,
                'description'  => 'Potret penjual buah dan sayur di sudut pasar rakyat.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 12,
                'title'        => 'Pelampung Darurat',
                'slug'         => 'pelampung-darurat-12',
                'category_id'  => 2, // Pelabuhan
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['pelampung', 'kapal', 'laut', 'darurat']),
                'w'            => 1067,
                'h'            => 1600,
                'price'        => 85000.00,
                'img'          => 'photos/pelampung-darurat.jpg',
                'downloads'    => 0,
                'description'  => 'Pelampung keselamatan oranye yang terpasang di dinding dek kapal penumpang.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 13,
                'title'        => 'Pembeli',
                'slug'         => 'pembeli-13',
                'category_id'  => 1, // Pasar
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['pembeli', 'pasar', 'payung', 'motor']),
                'w'            => 1600,
                'h'            => 1067,
                'price'        => 85000.00,
                'img'          => 'photos/pembeli.jpg',
                'downloads'    => 0,
                'description'  => 'Interaksi hangat antara pedagang dan pembeli di pasar tradisional.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'photo_id'     => 14,
                'title'        => 'Tempat Pemangku',
                'slug'         => 'tempat-pemangku-14',
                'category_id'  => 4, // Budaya
                'photographer' => 'I Made Arya Dipa',
                'tags'         => json_encode(['pemangku', 'pura', 'bale', 'bali']),
                'w'            => 1067,
                'h'            => 1600,
                'price'        => 85000.00,
                'img'          => 'photos/tempat-pemangku.jpg',
                'downloads'    => 0,
                'description'  => 'Bangunan bale pemangku dengan arsitektur ukiran tradisional Bali yang sakral.',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        DB::table('photos')->insert($photos);
    }
}
