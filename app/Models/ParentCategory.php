<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParentCategory extends Model
{
    use HasFactory;

    protected $table = 'parent_categories';
    protected $fillable = [
        'name',
    ];

    // ChildCategory モデルとのリレーションシップ
    public function childCategories()
    {
        return $this->hasMany(ChildCategory::class);
    }
}
