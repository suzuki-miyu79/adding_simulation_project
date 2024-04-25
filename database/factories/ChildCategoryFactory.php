<?php

namespace Database\Factories;

use App\Models\ParentCategory;
use App\Models\ChildCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChildCategory>
 */
class ChildCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ChildCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ParentCategoryのデータを生成してデータベースに保存
        $parentCategory = ParentCategory::factory()->create();

        return [
            'parent_category_id' => $parentCategory->id,
            'name' => $this->faker->text(5),
        ];
    }
}
