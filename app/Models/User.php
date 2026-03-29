<?php

namespace App\Models;
use App\Models\User;

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
        ];
    }

    public function index()
    {
        $users = User::where('id', '!=', auth()->id())->get();
    
        return view('dashboard', compact('users'));
    }
    // -----------------------------
    // 追加部分: 単語帳とのリレーション
    // -----------------------------
    public function wordbooks()
    {
        return $this->hasMany(Wordbook::class);
    }
    // フォローしているユーザー
    public function followings()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'follower_id',
            'following_id'
        )->withTimestamps();
    }

    // フォローされているユーザー
    public function followers()
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'following_id',
            'follower_id'
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

    // 誰に応援したか
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
                    ->where('follows.follower_id', $userId) // ← テーブル名を明示
                    ->exists();
            });
    }
}