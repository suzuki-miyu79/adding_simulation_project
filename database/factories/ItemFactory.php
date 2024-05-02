<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\ChildCategory;
use App\Models\Condition;
use App\Models\User;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ChildCategory と Condition のデータを生成してデータベースに保存
        $childCategory = ChildCategory::factory()->create();
        $condition = Condition::factory()->create();
        $user = User::factory()->create();

        return [
            'child_category_id' => $childCategory->id,
            'condition_id' => $condition->id,
            'name' => $this->faker->text(5),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomNumber(4),
            'image' => $this->faker->imageUrl(),
            'seller_user_id' => $user->id
        ];
    }
}
