<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Enum\TimeZoneEnum;
use Ramsey\Uuid\Type\Time;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Model>
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $timeZones = TimeZoneEnum::cases();
        $chosenTimeZoneId = rand(0, sizeof($timeZones) -1);
        $chosenTimeZone = $timeZones[$chosenTimeZoneId];

        return [
            User::FIRSTNAME => fake()->firstName(),
            User::LASTNAME => fake()->lastName(),
            User::EMAIL => fake()->unique()->safeEmail(),
            User::EMAIL_VERIFIED_AT => now(),
            User::PASSWORD => static::$password ??= Hash::make('password'),
            User::REMEMBER_TOKEN => Str::random(10),
            User::TIMEZONE => $chosenTimeZone->value
        ];
    }
}
