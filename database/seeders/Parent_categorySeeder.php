<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Parent_categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parent_categories = [
            '洋服',
            '美容',
            '健康',
        ];

        // データをテーブルに挿入
        foreach ($parent_categories as $parent_category) {
            DB::table('parent_categories')->insert([
                'name' => $parent_category,
            ]);
        }
    }
}
