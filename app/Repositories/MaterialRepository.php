<?php

namespace App\Repositories;

use App\Models\Material;

/**
 * MaterialRepository
 *
 * Tanggung jawab SATU: semua query ke tabel materials.
 * Placeholder — belum aktif. Akan diimplementasikan pada tahap Knowledge Base.
 */
class MaterialRepository
{
    /**
     * Cari materi berdasarkan keyword.
     * Placeholder — belum aktif.
     *
     * @param  string  $keyword
     * @return \Illuminate\Database\Eloquent\Collection
     */
    /**
     * Cari materi berdasarkan keyword atau query dari pengguna.
     *
     * @param  string  $userMessage
     * @param  int  $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function searchByKeyword(string $userMessage, int $limit = 3)
    {
        $userMessage = strtolower(trim($userMessage));

        if (empty($userMessage)) {
            return collect();
        }

        // Stopwords Bahasa Indonesia sederhana untuk dibersihkan dari pencarian
        $stopwords = [
            'apa', 'apakah', 'mengapa', 'kenapa', 'bagaimana', 'bagaimanakah', 'siapa', 
            'dimana', 'ke', 'di', 'dari', 'dan', 'atau', 'yang', 'ini', 'itu', 'saya', 
            'kamu', 'anda', 'bisa', 'tolong', 'jelaskan', 'tentang', 'adalah', 'yaitu', 
            'merupakan', 'secara', 'untuk', 'dengan', 'ada', 'bila', 'jika', 'kalau'
        ];

        // Tokenisasi kata
        $words = preg_split('/\s+/', preg_replace('/[^\w\s]/u', '', $userMessage));
        $keywords = array_filter($words, function ($w) use ($stopwords) {
            return strlen($w) >= 3 && !in_array($w, $stopwords);
        });

        if (empty($keywords)) {
            // Jika semua kata adalah stopword, gunakan kata asli jika panjangnya >= 3
            $keywords = array_filter($words, fn($w) => strlen($w) >= 3);
        }

        if (empty($keywords)) {
            return Material::active()->limit($limit)->get();
        }

        // Query materi yang mengandung kata kunci pada title, category, atau content
        $query = Material::active()->where(function ($q) use ($keywords) {
            foreach ($keywords as $kw) {
                $q->orWhere('title', 'LIKE', "%{$kw}%")
                  ->orWhere('category', 'LIKE', "%{$kw}%")
                  ->orWhere('content', 'LIKE', "%{$kw}%");
            }
        });

        $results = $query->limit($limit)->get();

        // Fallback jika tidak ada kata kunci spesifik yang cocok, ambil materi utama
        if ($results->isEmpty()) {
            return Material::active()->limit(2)->get();
        }

        return $results;
    }

    /**
     * Ambil semua materi yang aktif.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllActive()
    {
        return Material::active()->get();
    }
}