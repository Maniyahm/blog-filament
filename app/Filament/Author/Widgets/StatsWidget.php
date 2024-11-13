<?php
namespace App\Filament\Widgets;

use App\Models\Blog;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsWidget extends BaseWidget
{
    protected static ?string $heading = 'Statistics Overview';
    protected static ?int $sort = 1;
    protected function getCards(): array
    {
        return [
            Card::make('Total Blogs', Blog::where('user_id', auth()->id())->count()),
            Card::make('Approved Blogs', Blog::where('user_id', auth()->id())->where('status', 'approved')->count()),
            Card::make('Pending Approval', Blog::where('user_id', auth()->id())->where('status', 'unapproved')->count()),
        ];
    }
    
}
