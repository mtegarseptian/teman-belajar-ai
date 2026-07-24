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
     *
     * @param  string  $userMessage
     * @return string
     */
    public function getRelevantContext(string $userMessage): string
    {
        $materials = $this->materialRepository->searchByKeyword($userMessage);

        if ($materials->isEmpty()) {
            return '';
        }

        $contextLines = [];
        foreach ($materials as $material) {
            $categoryTag = !empty($material->category) ? " [Kategori: {$material->category}]" : '';
            $contextLines[] = "=== {$material->title}{$categoryTag} ===\n{$material->content}";
        }

        return implode("\n\n", $contextLines);
    }
}