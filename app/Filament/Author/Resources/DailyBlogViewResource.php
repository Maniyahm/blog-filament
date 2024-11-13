<?php

namespace App\Filament\Author\Resources;

use App\Filament\Author\Resources\DailyBlogViewResource\Pages;
use App\Filament\Author\Resources\DailyBlogViewResource\RelationManagers;
use App\Models\DailyBlogView;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;


class DailyBlogViewResource extends Resource
{
    protected static ?string $model = DailyBlogView::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('blog.title')
                ->label('Blog Name')
                ->sortable(),
            TextColumn::make('view_date')
                ->label('View Date')
                ->dateTime('M d, Y')
                ->sortable(),
            TextColumn::make('view_count')
                ->label('View Count')
                ->sortable(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyBlogViews::route('/'),    
        
        ];
    }
    
}
