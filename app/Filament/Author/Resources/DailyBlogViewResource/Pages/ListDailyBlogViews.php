<?php

namespace App\Filament\Author\Resources\DailyBlogViewResource\Pages;

use App\Filament\Author\Resources\DailyBlogViewResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyBlogViews extends ListRecords
{
    protected static string $resource = DailyBlogViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
