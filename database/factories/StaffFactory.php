<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    protected $model = Staff::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => bcrypt('123456'),
            'contact' => $this->faker->phoneNumber,
            'image' => $this->faker->imageUrl(),
            'additional_contact' => $this->faker->phoneNumber,
            'nid' => $this->faker->unique()->randomNumber(),
            'is_active' => $this->faker->boolean,
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
