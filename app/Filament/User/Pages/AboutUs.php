<?php

namespace App\Filament\User\Pages;

use Filament\Pages\Page;

class AboutUs extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static ?string $navigationLabel = 'About Us';
    protected static ?string $slug = 'about-us';
    protected static ?string $title = 'About Us';
    protected static ?int $navigationSort = 1; // Position in the sidebar
    protected static ?string $navigationGroup = 'Information';
    protected static ?string $panel = 'User'; // Explicitly set panel

    public function getView(): string
    {
        return 'filament.user.pages.about-us';
    }
}
