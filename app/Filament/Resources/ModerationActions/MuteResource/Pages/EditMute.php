<?php

namespace App\Filament\Resources\ModerationActions\MuteResource\Pages;

use App\Filament\Resources\ModerationActions\MuteResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMute extends EditRecord
{
    protected static string $resource = MuteResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
