<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['title', 'description', 'time_limit'];

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }
}