<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchases';
    protected $fillable = [
        'item_id',
        'buyer_user_id',
    ];

    // Item モデルとのリレーションシップ
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    // User モデルとのリレーションシップ
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_user_id');
    }
}
