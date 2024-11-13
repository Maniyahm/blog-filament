<?php

namespace App\Filament\Author\Resources\BlogResource\Pages;

use App\Filament\Author\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;
}
