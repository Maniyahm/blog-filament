<?php

namespace App\Filament\Author\Resources\AblogResource\Pages;

use App\Filament\Author\Resources\AblogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAblogs extends ListRecords
{
    protected static string $resource = AblogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
