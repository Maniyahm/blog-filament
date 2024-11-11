<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\BlogResource\Pages;
use App\Filament\User\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('location')->label('Location')->sortable()->searchable(),
                TextColumn::make('tag')->label('Tag'),
            ])
            ->filters([
                SelectFilter::make('location')
                    ->label('Location')
                    ->options(
                        Blog::whereNotNull('location')
                            ->pluck('location', 'location')
                            ->unique()
                            ->filter()
                    ),
                SelectFilter::make('tag')
                    ->label('Tag')
                    ->options(
                        Blog::whereNotNull('tag')
                            ->pluck('tag', 'tag')
                            ->unique()
                            ->filter()
                    ),
            ])
            ->modifyQueryUsing(fn ($query) => $query->where('status', 'approved'))
            // ->actions([
            //     Tables\Actions\ViewAction::make(),
            // ]);
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Blog $record): string => route('blog.view', $record)), // Use custom route
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
    public static function getView(): string
    {
    return 'filament.user-panel.pages.blog-view';
    }

}
