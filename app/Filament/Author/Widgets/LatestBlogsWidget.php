<?php

namespace App\Filament\Author\Widgets;

use App\Models\Blog;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class LatestBlogsWidget extends BaseWidget
{
    protected static ?int $sort = 3; 

    protected function getTableQuery(): Builder
    {
        // Query to get the latest 5 blogs, without filtering by user
        return Blog::latest()->take(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('title')
                ->label('Title')
                ->sortable(),

            TextColumn::make('status')
                ->label('Status')
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime('M d, Y') // Format the date as "Month Day, Year"
                ->sortable(),
        ];
    }
}
