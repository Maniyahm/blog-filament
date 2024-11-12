<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class Privacy extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Privacy Policy';
    protected static ?string $slug = 'privacy-policy';
    protected static ?string $title = 'Privacy Policy';
    protected static ?int $navigationSort = 2; // Position in the sidebar
    protected static ?string $navigationGroup = 'Information';
    protected static ?string $panel = 'User'; // Explicitly set panel

    public function getView(): string
    {
        return 'filament.user.pages.privacy';
    }
}
