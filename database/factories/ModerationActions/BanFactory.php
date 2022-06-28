<?php

namespace Database\Factories\ModerationActions;

use App\Enums\PlatformEnum;
use App\Models\ImageAttachment;
use App\Models\ModerationActions\Ban;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BanFactory extends Factory
{
    protected $model = Ban::class;

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
            "start_at" => now(),
            "end_at" => now()->addMonth(),
            "responsible_user_id" => User::all()->random()->id,
            "summary" => $this->faker->sentence,
            "comments" => $this->faker->realText,
            "evidence" => $this->faker->url,
            "permanent" => false,
            "platforms" => PlatformEnum::Both,
            "user_can_appeal" => true
        ];
    }

    /**
     * Indicate that the ban is permanent.
     *
     * @return static
     */
    public function permanent()
    {
        return $this->state(function () {
            return [
                'end_at' => null,
                'permanent' => true
            ];
        });
    }

    /**
     * Indicate the user cannot appeal.
     *
     * @return static
     */
    public function cannotAppeal()
    {
        return $this->state(function () {
            return [
                'user_can_appeal' => false,
            ];
        });
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
        return $this->afterCreating(function (Ban $ban) {
            ImageAttachment::create([
                'id' => Str::uuid(),
                'caption' => $this->faker->sentence,
                'url' => $this->faker->imageUrl,
                'user_id' => $ban->responsible_user_id,
                'attachable_type' => 'App\\Models\\ModerationActions\\Ban',
                'attachable_id' => $ban->id
            ]);
        });
    }
}
