<?php

namespace App\Filament\Resources\ContactadminpanelResource\Pages;

use App\Filament\Resources\ContactadminpanelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactadminpanel extends EditRecord
{
    protected static string $resource = ContactadminpanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
