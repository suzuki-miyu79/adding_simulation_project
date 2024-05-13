<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            Parent_categorySeeder::class,
            Child_categorySeeder::class,
            ConditionSeeder::class,
            UserSeeder::class,
            ItemSeeder::class,
        ]);

        // ダミーデータを生成する
        Comment::factory(100)->create();

    }
}
