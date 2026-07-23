<?php

namespace App\Services;

use App\Repositories\MaterialRepository;

/**
 * KnowledgeService
 *
 * Tanggung jawab SATU: mengambil konteks materi yang relevan
 * dari Knowledge Base untuk disisipkan ke prompt AI.
 *
 * Saat ini BELUM aktif — method getRelevantContext() mengembalikan
 * string kosong. Akan diimplementasikan pada tahap Knowledge Base.
 */
class KnowledgeService
{
    public function __construct(
        protected MaterialRepository $materialRepository
    ) {}

    /**
     * Ambil konteks materi yang relevan berdasarkan pertanyaan user.
     * Placeholder — belum aktif.
     *
     * @param  string  $userMessage
     * @return string
     */
    public function getRelevantContext(string $userMessage): string
    {
        // TODO: implementasi pencarian materi relevan (keyword search / vector search)
        // Contoh nanti:
        // $materials = $this->materialRepository->searchByKeyword($userMessage);
        // return $materials->pluck('content')->implode("\n\n");

        return '';
    }
}