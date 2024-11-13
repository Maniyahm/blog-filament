<?php

namespace App\Filament\Author\Resources\DailyBlogViewResource\Pages;

use App\Filament\Author\Resources\DailyBlogViewResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyBlogView extends CreateRecord
{
    protected static string $resource = DailyBlogViewResource::class;
}
