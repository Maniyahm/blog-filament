<?php

namespace App\Filament\User\Resources\BlogDetailResource\Pages;

use App\Filament\User\Resources\BlogDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogDetail extends CreateRecord
{
    protected static string $resource = BlogDetailResource::class;
}
