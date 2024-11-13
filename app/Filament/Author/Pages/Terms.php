<?php

namespace App\Filament\Author\Pages;

use Filament\Pages\Page;

class Terms extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 3; 
    protected static string $view = 'filament.author.pages.terms';
    protected static ?string $navigationGroup = 'Links';
}
