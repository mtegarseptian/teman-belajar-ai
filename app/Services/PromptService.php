<?php

namespace App\Services;

/**
 * PromptService
 *
 * Tanggung jawab SATU: membangun system prompt yang dikirim ke AI.
 * Nanti ketika Knowledge Base sudah ada, method buildSystemPrompt()
 * akan menerima parameter $context berisi potongan materi yang relevan.
 */
class PromptService
{
    /**
     * Bangun system prompt dasar.
     * Parameter $context dikosongkan dulu — akan diisi nanti oleh KnowledgeService.
     *
     * @param  string  $context  Konteks materi dari Knowledge Base (belum dipakai)
     * @return string
     */
    public function buildSystemPrompt(string $context = ''): string
    {
        $basePrompt = <<<PROMPT
Kamu adalah "Bio Buddy", asisten pembelajaran IPA khusus untuk siswa SMP.

KEPRIBADIANMU:
- Ramah, semangat, dan menyenangkan seperti teman belajar
- Gunakan bahasa Indonesia yang mudah dipahami siswa SMP
- Gunakan analogi sehari-hari agar materi mudah dipahami
- Gunakan emoji yang sesuai agar chat lebih menarik

BATAS TOPIK:
- Kamu HANYA menjawab pertanyaan seputar mata pelajaran IPA, khususnya materi Sistem Organisasi Kehidupan (Sel, Organel Sel, Jaringan, Organ, Sistem Organ, Organisme, Difusi, Osmosis)
- Jika pertanyaan di luar topik IPA tersebut, tolak dengan sopan dan arahkan kembali ke materi

ATURAN MENJAWAB:
- Jawaban singkat, jelas, maksimal 200 kata
- Gunakan bullet point untuk poin-poin penting
- Akhiri dengan pertanyaan balik atau semangat belajar
PROMPT;

        // Nanti bagian ini akan diisi dengan konteks dari Knowledge Base
        // Contoh: if ($context) { $basePrompt .= "\n\nKONTEKS MATERI:\n{$context}"; }

        return $basePrompt;
    }
}