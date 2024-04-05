<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $fillable = [
        'child_category_id',
        'condition_id',
        'name',
        'description',
        'price',
        'image',
        'seller_user_id',
    ];

    // Child_category モデルとのリレーションシップ
    public function child_category()
    {
        return $this->belongsTo(ChildCategory::class, 'child_category_id');
    }

    // Condition モデルとのリレーションシップ
    public function condition()
    {
        return $this->belongsTo(Condition::class, 'condition_id');
    }

    // User モデルとのリレーションシップ
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_user_id');
    }

    // Purchase モデルとのリレーションシップ
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    // Comment モデルとのリレーションシップ
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Favorite モデルとのリレーションシップ
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
