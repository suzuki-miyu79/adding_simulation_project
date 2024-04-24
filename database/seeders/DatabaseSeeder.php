<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

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
        ]);

        // ダミーデータを生成する
        Item::factory(10)->create();

    }
}
