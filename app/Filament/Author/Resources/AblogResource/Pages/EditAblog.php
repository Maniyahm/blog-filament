<?php

namespace App\Filament\Author\Resources\AblogResource\Pages;

use App\Filament\Author\Resources\AblogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAblog extends EditRecord
{
    protected static string $resource = AblogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
