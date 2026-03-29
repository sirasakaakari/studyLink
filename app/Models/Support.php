<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_user_id',
        'comment',
        'stamp',
        'is_read' // ← 追加しておくと安全
    ];

    // 送信者
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 受信者
    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_user_id');
    }
}