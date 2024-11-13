<?php

namespace App\Filament\User\Resources\BlogDetailResource\Pages;

use App\Filament\User\Resources\BlogDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlogDetails extends ListRecords
{
    protected static string $resource = BlogDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
