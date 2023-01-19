<?php

namespace App\Filament\Resources\ModerationActions\MuteResource\Pages;

use App\Filament\Resources\ModerationActions\MuteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMute extends CreateRecord
{
    protected static string $resource = MuteResource::class;
}
