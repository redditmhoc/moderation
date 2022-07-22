<?php

namespace Database\Factories;

use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class NoteFactory extends Factory
{
    protected $model = Note::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'reddit_username' => $this->faker->userName,
            'discord_username' => "{$this->faker->userName}#{$this->faker->randomNumber(4)}",
            "discord_id" => 235088799074484224,
            'content' => $this->faker->paragraph(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'responsible_user_id' => User::all()->random()->id
        ];
    }
}
