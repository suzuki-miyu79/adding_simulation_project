<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = [
        'item_id',
        'user_id',
        'comment',
    ];

    // Item モデルとのリレーションシップ
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // User モデルとのリレーションシップ
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
