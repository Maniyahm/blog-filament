<?php

namespace App\Filament\Author\Pages;

use Filament\Pages\Page;

class about extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.author.pages.about';
    protected static ?string $navigationGroup = 'Links';
}
