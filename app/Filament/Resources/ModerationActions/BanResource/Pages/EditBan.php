<?php

namespace App\Filament\Resources\ModerationActions\BanResource\Pages;

use App\Filament\Resources\ModerationActions\BanResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBan extends EditRecord
{
    protected static string $resource = BanResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
