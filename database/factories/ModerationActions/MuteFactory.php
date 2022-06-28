<?php

namespace Database\Factories\ModerationActions;

use App\Enums\PlatformEnum;
use App\Models\ImageAttachment;
use App\Models\ModerationActions\Mute;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MuteFactory extends Factory
{
    protected $model = Mute::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'reddit_username' => $this->faker->userName,
            'discord_username' => "{$this->faker->userName}#{$this->faker->randomNumber(4)}",
            "discord_id" => 235088799074484224,
            "aliases" => $this->faker->userName,
            "start_at" => now()->subMinutes(15),
            "end_at" => now()->addHours(12),
            "responsible_user_id" => User::all()->random()->id,
            "summary" => $this->faker->sentence,
            "comments" => $this->faker->realText,
            "evidence" => $this->faker->url,
            "platforms" => PlatformEnum::Both,
        ];
    }

    /**
     * Indicate the ban is Reddit only.
     *
     * @return static
     */
    public function redditOnly()
    {
        return $this->state(function () {
            return [
                'platforms' => PlatformEnum::Reddit,
            ];
        });
    }

    /**
     * Indicate the ban is Discord only.
     *
     * @return static
     */
    public function discordOnly()
    {
        return $this->state(function () {
            return [
                'platforms' => PlatformEnum::Discord,
            ];
        });
    }

    public function configure()
    {
        return $this->afterCreating(function (Mute $mute) {
            ImageAttachment::create([
                'id' => Str::uuid(),
                'caption' => $this->faker->sentence,
                'url' => $this->faker->imageUrl,
                'user_id' => $mute->responsible_user_id,
                'attachable_type' => 'App\\Models\\ModerationActions\\Mute',
                'attachable_id' => $mute->id
            ]);
        });
    }
}
