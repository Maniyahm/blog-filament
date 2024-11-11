<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Blogs', Blog::count()),
            Card::make('Total Authors', User::role('author')->count()), // Assuming Spatie roles
            Card::make('Total Users', User::count()),
        ];
    }
}
