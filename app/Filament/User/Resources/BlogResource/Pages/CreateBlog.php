<?php

namespace App\Filament\User\Resources\BlogResource\Pages;

use App\Filament\User\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;
}
