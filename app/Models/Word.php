<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['word', 'meaning', 'wordbook_id'];

    public function wordbook()
    {
        return $this->belongsTo(Wordbook::class);
    }
}
