<?php

namespace Database\Seeders;

use App\Models\ModerationActions\Ban;
use Illuminate\Database\Seeder;

class BanSeeder extends Seeder
{
    public function run()
    {
        Ban::factory()->count(4)->create();
        Ban::factory()->permanent()->create();
        Ban::factory()->discordOnly()->create();
    }
}
