<?php

namespace App\Filament\Resources\ModerationActions\BanResource\Pages;

use App\Filament\Resources\ModerationActions\BanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBan extends CreateRecord
{
    protected static string $resource = BanResource::class;
}
