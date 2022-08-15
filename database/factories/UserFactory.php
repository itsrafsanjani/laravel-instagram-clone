<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     *
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'username' => $this->faker->unique()->userName,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'phone_number' => $this->faker->phoneNumber(),
            'phone_number_verified_at' => now(),
            'otp' => random_int(100000, 999999),
            'otp_created_at' => now(),
            'website' => $this->faker->url,
            'bio' => $this->faker->realText(150),
            'gender' => $this->faker->randomElement(['male', 'female', 'others']),
        ];
    }
}
