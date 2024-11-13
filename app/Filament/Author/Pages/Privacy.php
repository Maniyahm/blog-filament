<?php

namespace App\Filament\Author\Pages;

use Filament\Pages\Page;

class Privacy extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 2; 
    protected static string $view = 'filament.author.pages.privacy';
    protected static ?string $navigationGroup = 'Links';
}
