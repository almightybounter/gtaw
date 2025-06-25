<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Note Factory - FOR TESTING PURPOSES ONLY
 * 
 * This factory is used to generate test data during development and testing.
 * It is NOT used in production deployments.
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-3 months', 'now');
        return [
            'title' => $this->faker->sentence(4),
            'content' => $this->faker->paragraphs(3, true),
            'user_id' => null,
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }

    public function long(): static
    {
        return $this->state(fn (array $attributes) => [
            'content' => $this->faker->paragraphs(10, true),
        ]);
    }

    public function recent(): static
    {
        return $this->state(function (array $attributes) {
            $createdAt = $this->faker->dateTimeBetween('-1 week', 'now');
            return [
                'created_at' => $createdAt,
                'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
            ];
        });
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
