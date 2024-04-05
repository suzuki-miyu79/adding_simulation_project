<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;

    protected $table = 'child_categories';
    protected $fillable = [
        'parent_category_id',
        'name',
    ];

    // Parent_category モデルとのリレーションシップ
    public function parent_categories()
    {
        return $this->belongsTo(ParentCategory::class);
    }
}
