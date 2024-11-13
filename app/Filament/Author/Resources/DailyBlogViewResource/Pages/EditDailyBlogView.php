<?php

namespace App\Filament\Author\Resources\DailyBlogViewResource\Pages;

use App\Filament\Author\Resources\DailyBlogViewResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyBlogView extends EditRecord
{
    protected static string $resource = DailyBlogViewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
