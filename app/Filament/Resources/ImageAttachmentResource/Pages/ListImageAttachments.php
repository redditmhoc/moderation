<?php

namespace App\Filament\Resources\ImageAttachmentResource\Pages;

use App\Filament\Resources\ImageAttachmentResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImageAttachments extends ListRecords
{
    protected static string $resource = ImageAttachmentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
