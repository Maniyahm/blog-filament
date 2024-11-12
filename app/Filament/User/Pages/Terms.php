<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class Terms extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Terms of Service';
    protected static ?string $slug = 'terms-of-service';
    protected static ?string $title = 'Terms of Service';
    protected static ?int $navigationSort = 3; // Position in the sidebar
    protected static ?string $navigationGroup = 'Information';
    protected static ?string $panel = 'User'; // Explicitly set panel

    public function getView(): string
    {
        return 'filament.user.pages.terms';
    }
}
