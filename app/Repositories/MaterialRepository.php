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
    public function searchByKeyword(string $keyword)
    {
        // TODO: implementasi full-text search atau LIKE query
        // Contoh nanti:
        // return Material::active()
        //     ->where('content', 'LIKE', "%{$keyword}%")
        //     ->limit(3)
        //     ->get();

        return collect();
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