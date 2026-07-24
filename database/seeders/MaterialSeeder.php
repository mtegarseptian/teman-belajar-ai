<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'title' => 'Pengenalan Sistem Organisasi Kehidupan',
                'slug' => 'pengenalan-sistem-organisasi-kehidupan',
                'category' => 'organisasi_kehidupan',
                'content' => <<<TEXT
Terdapat sekitar 30-37 triliun sel di dalam tubuh manusia, mulai dari kulit hingga otak. Bentuk sel sangat bervariasi:
- Sel saraf dapat memanjang hingga lebih dari 1 meter (ekor sel saraf disebut akson).
- Sel darah merah berbentuk cakram pipih.
- Sel otot berbentuk panjang dan kuat.

Sel meregenerasi diri melalui pembelahan sel:
- Sel kulit berganti setiap beberapa minggu.
- Sel dinding usus berganti setiap beberapa hari.
- Sel darah merah diproduksi terus-menerus di sumsum tulang belakang.

Hirarki Organisasi Kehidupan dari unit terkecil hingga terbesar:
Sel -> Jaringan -> Organ -> Sistem Organ -> Organisme (Individu).
TEXT,
                'status' => 'active',
            ],
            [
                'title' => 'Sel Prokariotik dan Sel Eukariotik',
                'slug' => 'sel-prokariotik-dan-eukariotik',
                'category' => 'sel',
                'content' => <<<TEXT
Sel adalah satuan unit struktural & fungsional terkecil makhluk hidup.
Sejarah Teori Sel:
- Robert Hooke (1665): Menciptakan istilah 'sel' saat mengamati sel gabus mati.
- Anton Von Leeuwenhoek: Pertama kali melihat dan mendeskripsikan sel hidup.
- Robert Brown: Menemukan nukleus.
- Schleiden & Schwann (1855): Mengusulkan teori sel untuk menjelaskan konsep sifat seluler organisme hidup.

Jenis Sel:
1. Sel Prokariotik: Sel primitif tanpa inti sel yang terikat membran dan tanpa organel terikat membran (seperti mitokondria atau plastida). Diameter 1-10 µm. Contoh: Bakteri, Cyanobacteria (alga hijau-biru), Mycoplasma (PPLO). Bakteri berkembang biak dengan pembelahan dan sebagian bersifat patogen.
2. Sel Eukariotik: Memiliki nukleus terikat membran dan kompartementalisasi organel sitoplasma. Terbagi dalam 4 kingdom: Protista, Fungi, Plantae, dan Animalia.
TEXT,
                'status' => 'active',
            ],
            [
                'title' => 'Perbedaan Sel Tumbuhan dan Sel Hewan',
                'slug' => 'perbedaan-sel-tumbuhan-dan-hewan',
                'category' => 'sel',
                'content' => <<<TEXT
Perbedaan Sel Tumbuhan dan Sel Hewan:
1. Sel Tumbuhan memiliki:
   - Dinding Sel: Lapisan luar kaku dari selulosa untuk kekuatan mekanik & menahan tekanan turgor.
   - Plastida / Kloroplas: Organel untuk fotosintesis menyerap cahaya matahari.
   - Vakuola Besar: Menyimpan cairan, enzim, dan mempertahankan tekanan turgor.
   - Tidak memiliki sentriol.
2. Sel Hewan memiliki:
   - Sentrosom / Sentriol: Sepasang struktur silinder mikrotubulus untuk pembelahan sel.
   - Lisosom: Unit daur ulang & pencernaan seluler.
   - Tidak memiliki dinding sel dan kloroplas. Vakuola sangat kecil atau tidak ada.
TEXT,
                'status' => 'active',
            ],
            [
                'title' => 'Organel-Organel Sel dan Fungsinya',
                'slug' => 'organel-organel-sel-dan-fungsinya',
                'category' => 'organel',
                'content' => <<<TEXT
Fungsi Organel Sel:
1. Mitokondria: Pembangkit listrik sel. Mengubah energi kimia makanan menjadi ATP melalui respirasi sel. Terdiri dari membran luar, membran dalam (memiliki lipatan krista), dan matriks (cairan & DNA untai ganda).
2. Retikulum Endoplasma (RE): Sistem transportasi internal sel.
   - RE Kasar (REK): Mengandung ribosom, memproduksi dan mengangkut protein untuk sekresi.
   - RE Halus (REH): Tanpa ribosom, memproduksi lipid/fosfolipid & mendetoksifikasi racun/obat.
3. Ribosom: Dibentuk di nukleolus, berfungsi memproduksi protein dari asam amino. Terdiri dari subunit besar dan subunit kecil.
4. Lisosom: Petugas kebersihan sel (sel hewan). Membawa enzim hidrolitik untuk mendaur ulang organel rusak atau menghancurkan benda asing/bakteri.
5. Nukleus (Inti Sel): CEO sel yang menyimpan DNA dan memberi perintah aktivitas sel. Saat pembelahan berupa kromosom rapat; di waktu lain berupa kromatin longgar.
6. Sitoskeleton: Kerangka sel (mikrotubulus, mikrofilamen, filamen intermediet) yang memberi bentuk, pergerakan, dan transportasi sel.
7. Sentrosom & Sentriol: Sepasang struktur silinder dari mikrotubulus pada sel hewan untuk pembelahan sel.
8. Badan Golgi (Aparatus Golgi): Memodifikasi, membungkus, dan mendistribusikan protein/lipid dari REK menjadi vesikel, serta membentuk lisosom & bahan dinding sel tumbuhan.
9. Vakuola: Ruang terikat membran penyimpan enzim/cairan dan penjaga tekanan turgor sel tumbuhan.
10. Kloroplas: Organel penyerap energi cahaya untuk fotosintesis (mengandung pigmen klorofil, tilakoid, grana, dan stroma).
11. Membran Sel: Pelindung semipermeabel fleksibel (model mosaik fluida fosfolipid bilayer) yang mengatur keluar masuknya molekul.
12. Dinding Sel: Pelindung luar kaku dari selulosa pada tumbuhan untuk menahan tekanan osmotik & turgor.
TEXT,
                'status' => 'active',
            ],
            [
                'title' => 'Transportasi Sel: Difusi, Osmosis, dan Tekanan Turgor',
                'slug' => 'transportasi-sel-difusi-osmosis-turgor',
                'category' => 'transportasi_sel',
                'content' => <<<TEXT
Mekanisme Transportasi Sel melalui Membran Semipermeabel:
1. Transpor Pasif (Tanpa energi ATP):
   - Difusi: Perpindahan zat (gas/cairan seperti sirup) dari tempat konsentrasi tinggi (pekat) ke konsentrasi rendah (encer) hingga merata.
   - Osmosis: Perpindahan molekul AIR melewati membran semipermeabel dari larutan encer (banyak air / hipotonis) menuju larutan pekat (sedikit air / hipertonis).
2. Transpor Aktif (Memerlukan energi ATP):
   - Perpindahan molekul/ion melawan gradien konsentrasi (dari konsentrasi rendah ke tinggi), contohnya Pompa Natrium-Kalium (Na+/K+).
3. Tekanan Turgor:
   - Tekanan air di dalam vakuola sel tumbuhan terhadap dinding sel. Cukup air = tekanan turgor tinggi (daun segar & renyah). Kurang air = tekanan turgor rendah (daun layu & lemas).
4. Plasmolisis:
   - Peristiwa keluarnya air dari dalam sel tumbuhan secara osmosis ketika berada di lingkungan hipertonis (misal larutan garam pekat), menyebabkan sel kehilangan air dan mengkerut sehingga tumbuhan makin layu.
TEXT,
                'status' => 'active',
            ],
            [
                'title' => 'Jaringan, Organ, dan Sistem Organ',
                'slug' => 'jaringan-organ-dan-sistem-organ',
                'category' => 'organisasi_kehidupan',
                'content' => <<<TEXT
Hierarki Organisasi Kehidupan Tingkat Lanjut:
1. Jaringan: Kumpulan sel dengan bentuk dan fungsi yang sama.
   - Jaringan Hewan / Manusia: Jaringan Epitel (pelapis/kulit), Jaringan Ikat/Konektif (tulang/darah/tendon), Jaringan Otot (penggerak), Jaringan Saraf (komunikasi/neuron).
   - Jaringan Tumbuhan: Jaringan Meristem (sel aktif membelah), Jaringan Epidermis, Jaringan Parenkim (mesofil), Jaringan Pengangkut (Xilem & Floem).
2. Organ: Kumpulan beberapa jaringan yang bekerja sama menjalankan fungsi spesifik. Ilmu yang mempelajari struktur jaringan pada organ disebut Histologi.
   - Contoh Organ Hewan: Lambung (terdiri dari jaringan epitel, ikat, otot, dan saraf).
   - Contoh Organ Tumbuhan: Daun (terdiri dari epidermis, parenkim, dan pengangkut).
3. Sistem Organ: Kumpulan beberapa organ berbeda yang bekerja sama secara kompleks (misal: Sistem Pencernaan, Pernafasan, Peredaran Darah, Saraf, Ekskresi, Rangka, Otot, Endokrin, Reproduksi, Imun).
4. Organisme / Individu: Makhluk hidup utuh hasil persatuan seluruh sistem organ (contoh: Manusia, Hewan, Tumbuhan).
TEXT,
                'status' => 'active',
            ],
            [
                'title' => 'Studi Kasus & Eksperimen: Sayuran Kulkas & Misteri Kangkung Romi',
                'slug' => 'studi-kasus-eksperimen-osmosis-kangkung',
                'category' => 'studi_kasus',
                'content' => <<<TEXT
Studi Kasus & Eksperimen Sains Nyata:
1. Percobaan "Segarkan Kembali Kangkung Layu":
   - Fenomena: Kangkung layu direndam dalam air dingin/es selama 30-60 menit.
   - Fakta Ilmiah: Air di luar sel masuk ke dalam sel kangkung yang pekat secara OSMOSIS. Sel kangkung kembali penuh air (mengalami TEKANAN TURGOR) sehingga kangkung kembali segar dan garing.
2. Misteri Kangkung Romi (Merendam di Air Garam):
   - Fenomena: Romi merendam kangkung layu di air es + 5 sendok makan garam dapur (larutan hipertonis 5-8%). Kangkung justru makin layu, keriput, dan lemas.
   - Fakta Ilmiah: Air di dalam sel kangkung tersedot keluar menuju larutan garam secara OSMOSIS. Peristiwa sel mengkerut akibat kehilangan air ini disebut PLASMOLISIS.
3. Mengapa Sayuran di Kulkas Cepat Layu?
   - Udara dingin kulkas memiliki kelembapan sangat rendah. Air di dalam sel sayuran menguap ke udara kulkas, menurunkan tekanan turgor sehingga sayur layu.
4. Solusi Membungkus Sayur dengan Tisu / Kain Katun:
   - Tisu/kain katun menyerap embun/kelembapan berlebih di dalam kemasan plastik, mengurangi risiko pembusukan oleh bakteri/jamur sekaligus menjaga kelembapan mikro di sekitar sayur.
5. Percobaan Kentang & Wortel di Larutan Garam:
   - Kentang di air biasa: tetap keras & massa sedikit bertambah (air masuk).
   - Kentang di larutan garam 5-8%: menjadi lunak & massa berkurang (air keluar secara osmosis).
TEXT,
                'status' => 'active',
            ],
            [
                'title' => 'Proyek STEM: Vegetable Fresh Box (Project-Based Learning)',
                'slug' => 'proyek-stem-vegetable-fresh-box',
                'category' => 'proyek_stem',
                'content' => <<<TEXT
Panduan Proyek STEM "Vegetable Fresh Box" (Wadah Penyimpanan Sayur Awet & Hemat Tisu):
- Science: Mengaplikasikan konsep Osmosis Sel & Tekanan Turgor untuk menjaga kesegaran sayuran daun di kulkas tanpa tisu berlebih.
- Technology: Menggunakan kamera smartphone (fitur Time-Lapse) untuk merekam perendaman/kesegaran, serta Spreadsheet / Excel untuk mencatat grafik tingkat kesegaran (skala kuantitatif 1-5).
- Engineering: Merancang wadah plastik bekas dengan media pelembab ulang (spons/kain damp) dan membuat ventilasi udara (lubang kecil menggunakan paku hangat/solder) untuk mencegah jamur akibat uap berlebih.
- Mathematics:
  1. Menghitung rasio luas lubang ventilasi vs volume wadah (Contoh: wadah 1 liter memerlukan 4 lubang berdiameter 0.5 cm).
  2. Membuat grafik garis perkembangan kesegaran harian (Hari ke-1 s/d Hari ke-3).
  3. Analisis Biaya: Menghitung total biaya wadah buatan sendiri vs wadah pabrikan toko online.
TEXT,
                'status' => 'active',
            ],
            [
                'title' => 'Bank Soal & Pembahasan Literasi Sains (Materi Sel & Osmosis)',
                'slug' => 'bank-soal-literasi-sains-sel-osmosis',
                'category' => 'soal_evaluasi',
                'content' => <<<TEXT
Soal & Pembahasan Kuis Literasi Sains IPA SMP:
Soal 1: Penyebab utama sayuran menjadi layu di kulkas adalah...
- Kunci & Penjelasan: Karena suhu rendah menyebabkan kapasitas udara dalam kulkas makin turun (kering), menyebabkan sel kehilangan air sehingga tekanan turgor menurun.

Soal 2: Mengapa larutan garam konsentrasi tinggi (8%) menyebabkan sayuran lebih cepat layu?
- Kunci & Penjelasan: Garam menyebabkan air keluar dari sel sayuran melalui proses osmosis (Plasmolisis).

Soal 3: Mengapa kentang yang direndam dalam larutan garam (NaCl) menjadi lebih lunak?
- Kunci & Penjelasan: Air keluar dari sel kentang menuju larutan garam melalui proses osmosis.

Soal 4: Hipotesis penggunaan tisu saat menyimpan sayur di kulkas:
- Kunci & Penjelasan: Sayuran yang dibungkus tisu lebih awet karena tisu menyerap kelembapan/embun berlebih yang dapat melembabkan wadah dan mengurangi pertumbuhan mikroorganisme pembusuk.

Soal 5: Cara terbaik kantin sekolah menyimpan sayuran agar tidak cepat busuk/layu:
- Kunci & Penjelasan: Membungkus sayuran menggunakan kain katun/tisu bersih sebelum disimpan di kulkas untuk mempertahankan kelembapan dan mencegah pembusukan.

Faktor yang memengaruhi masa simpan sayuran: Suhu penyimpanan, jenis kemasan, kelembapan lingkungan penyimpanan, dan laju respirasi sayuran.
TEXT,
                'status' => 'active',
            ],
        ];

        foreach ($materials as $mat) {
            Material::updateOrCreate(
                ['slug' => $mat['slug']],
                $mat
            );
        }
    }
}
