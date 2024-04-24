<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            '本、雑誌',
            'ゲーム',
        ];

        // データをテーブルに挿入
        foreach ($parent_categories as $parent_category) {
            DB::table('parent_categories')->insert([
                'name' => $parent_category,
            ]);
        }

        // データをテスト用テーブルに挿入
        // foreach ($parent_categories as $parent_category) {
        //     DB::connection('mysql_test')->table('parent_categories')->insert([
        //         'name' => $parent_category,
        //     ]);
        // }
    }
}
