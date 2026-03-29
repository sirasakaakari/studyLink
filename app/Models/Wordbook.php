<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wordbook extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function words()
    {
        return $this->hasMany(Word::class);
    }
}
