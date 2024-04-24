<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            '新品、未使用',
            '良好',
            '傷、汚れあり',
        ];

        // データをテーブルに挿入
        foreach ($conditions as $condition) {
            DB::table('conditions')->insert([
                'name' => $condition,
            ]);
        }

        // データをテスト用テーブルに挿入
        // foreach ($conditions as $condition) {
        //     DB::connection('mysql_test')->table('conditions')->insert([
        //         'name' => $condition,
        //     ]);
        // }
    }
}
