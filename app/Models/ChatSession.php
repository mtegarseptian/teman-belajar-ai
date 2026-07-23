<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $fillable = ['session_token'];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at');
    }
}