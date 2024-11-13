<?php
namespace App\Filament\Author\Widgets;

use App\Models\Comment;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class LatestCommentsWidget extends BaseWidget
{
    protected static ?int $sort = 2; 

    protected function getTableQuery(): Builder
    {
        // Modify this query to fetch the latest comments as per your requirements
        return Comment::latest()->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('blog.name')
                ->label('Author')
                ->sortable(),

            TextColumn::make('content')
                ->label('Comment')
                ->limit(50) // Truncate long comments to 50 characters
                ->sortable(),

            TextColumn::make('created_at')
                ->label('Date')
                ->dateTime('M d, Y') // Format the date as "Month Day, Year"
                ->sortable(),
        ];
    }
}

