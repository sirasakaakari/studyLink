<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'target_value',
        'current_value',
        'is_completed',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
