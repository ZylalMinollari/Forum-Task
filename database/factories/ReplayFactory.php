<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Replay;
use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplayFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Replay::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body'          => $this->faker->text(),
            'author_id'     => $attributes['author_id'] ?? User::factory()->create()->id(),
            'replyable_id'  => $attributes['replyable_id'] ?? Thread::factory()->create()->id(),
            'replyable_type' => Thread::TABLE,
        ];
    }
}
