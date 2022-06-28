<?php

namespace Database\Seeders;

use App\Models\ModerationActions\Ban;
use App\Models\ModerationActions\Mute;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(10)->create();
        Ban::factory()->count(50)->discordOnly()->create();
        Ban::factory()->count(10)->permanent()->discordOnly()->create();
        Ban::factory()->count(25);
        Ban::factory()->count(5)->permanent()->create();
        Ban::factory()->permanent()->cannotAppeal()->create();
        Mute::factory()->count(35)->discordOnly()->create();
    }
}
