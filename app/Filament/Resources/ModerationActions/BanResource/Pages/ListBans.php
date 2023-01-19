<?php

namespace App\Filament\Resources\ModerationActions\BanResource\Pages;

use App\Filament\Resources\ModerationActions\BanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBans extends ListRecords
{
    protected static string $resource = BanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
