<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWordResult extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'word_id', 'mistake_count', 'rank'];
}
