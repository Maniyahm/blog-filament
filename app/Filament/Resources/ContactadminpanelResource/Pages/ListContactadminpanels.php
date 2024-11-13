<?php

namespace App\Filament\Resources\ContactadminpanelResource\Pages;

use App\Filament\Resources\ContactadminpanelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContactadminpanels extends ListRecords
{
    protected static string $resource = ContactadminpanelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
