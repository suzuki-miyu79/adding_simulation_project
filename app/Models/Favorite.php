<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';
    protected $fillable = [
        'user_id',
        'item_id',
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
