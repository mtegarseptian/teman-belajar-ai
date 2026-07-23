<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category',
        'status',
    ];

    /**
     * Scope untuk mengambil materi yang aktif saja.
     * Nanti dipakai oleh KnowledgeService.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}