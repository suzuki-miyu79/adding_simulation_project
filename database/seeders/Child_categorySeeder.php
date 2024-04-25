<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Child_categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $child_categories = [
            [
                'parent_category_id' => 1,
                'name' => 'メンズ',
            ],
            [
                'parent_category_id' => 1,
                'name' => 'レディース',
            ],
            [
                'parent_category_id' => 2,
                'name' => '漫画、コミック',
            ],
            [
                'parent_category_id' => 2,
                'name' => '雑誌',
            ],
            [
                'parent_category_id' => 3,
                'name' => 'テレビゲーム',
            ],
            [
                'parent_category_id' => 3,
                'name' => 'カードゲーム',
            ],
        ];

        // データをテーブルに挿入
        foreach ($child_categories as $child_category) {
            DB::table('child_categories')->insert($child_category);
        }
    }
}
