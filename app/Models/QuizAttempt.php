<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    protected $fillable = [
        'session_token',
        'quiz_id',
        'score',
        'total_questions',
        'answers',
        'completed_at',
    ];

    protected $casts = [
        'answers'      => 'array',
        'completed_at' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}