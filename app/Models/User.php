<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_guest', // ← 追加
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_guest' => 'boolean', // ← 追加
        ];
    }

    // ゲスト削除時に関連データも全削除
    protected static function booted()
    {
        static::deleting(function ($user) {
            if ($user->is_guest) {
                $user->wordbooks()->each(function ($wordbook) {
                    $wordbook->words()->delete();
                    $wordbook->delete();
                });
                $user->goals()->delete();
                $user->notifications()->delete();
                $user->followings()->detach();
                $user->followers()->detach();
            }
        });
    }

    // 単語帳
    public function wordbooks()
    {
        return $this->hasMany(Wordbook::class);
    }

    // 目標 ← 追加
    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    // フォローしているユーザー
    public function followings()
    {
        return $this->belongsToMany(
            User::class, 'follows', 'follower_id', 'following_id'
        )->withTimestamps();
    }

    // フォローされているユーザー
    public function followers()
    {
        return $this->belongsToMany(
            User::class, 'follows', 'following_id', 'follower_id'
        )->withTimestamps();
    }

    // すでにフォローしているか？
    public function isFollowing($userId): bool
    {
        return $this->followings()->where('following_id', $userId)->exists();
    }

    public function supportsReceived()
    {
        return $this->hasMany(Support::class, 'target_user_id');
    }

    public function supportsGiven()
    {
        return $this->hasMany(Support::class, 'user_id');
    }

    public function mutualFollows()
    {
        $userId = $this->id;

        return $this->followings()
            ->get()
            ->filter(function ($following) use ($userId) {
                return $following->followers()
                    ->where('follows.follower_id', $userId)
                    ->exists();
            });
    }
}