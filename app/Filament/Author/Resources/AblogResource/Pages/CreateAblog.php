<?php

namespace App\Filament\Author\Resources\AblogResource\Pages;

use App\Filament\Author\Resources\AblogResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAblog extends CreateRecord
{
    protected static string $resource = AblogResource::class;
}
