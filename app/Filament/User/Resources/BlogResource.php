<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\BlogResource\Pages;
use App\Models\Blog;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\ImageColumn;
use Filament\Infolists\Components;
use Filament\Infolists\Infolist;
use App\Filament\User\Resources\BlogResource\Pages\ViewBlog;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Define fields for the form here
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Grid::make()
                    ->columns(1)
                    ->schema([
                        Grid::make()
                            ->columns(['image' => 1, 'info' => 4]) 
                            ->schema([
                                ImageColumn::make('image')
                                    ->label('Image')
                                    ->extraAttributes([
                                        'style' => 'border-radius: 8px;',
                                    ])
                                    ->visible(fn ($record) => $record && $record->image), 

                                Grid::make()
                                    ->columns(1)
                                    ->schema([
                                        TextColumn::make('title')
                                            ->label('Title')
                                            ->sortable()
                                            ->searchable()
                                            ->formatStateUsing(fn ($state) => "
                                                <div class='flex'>
                                                    <span class='font-semibold text-gray-700 mr-1'>Title:</span>
                                                    <span class='text-blue-600'>{$state}</span>
                                                </div>
                                            ")
                                            ->html(),

                                        TextColumn::make('category.name')
                                            ->label('Category')
                                            ->sortable()
                                            ->searchable()
                                            ->formatStateUsing(fn ($state) => "
                                                <div class='flex'>
                                                    <span class='font-semibold text-gray-700 mr-1'>Category:</span>
                                                    <span class='inline-block bg-blue-100 text-blue-800 rounded-full px-2 py-1 text-sm'>{$state}</span>
                                                </div>
                                            ")
                                            ->html(),

                                        TextColumn::make('location')
                                            ->label('Location')
                                            ->sortable()
                                            ->searchable()
                                            ->formatStateUsing(fn ($state) => "
                                                <div class='flex'>
                                                    <span class='font-semibold text-gray-700 mr-1'>Location:</span>
                                                    <span class='text-gray-600'>{$state}</span>
                                                </div>
                                            ")
                                            ->html(),

                                        TextColumn::make('tag')
                                            ->label('Tag')
                                            ->formatStateUsing(fn ($state) => "
                                                <div class='flex'>
                                                    <span class='font-semibold text-gray-700 mr-1'>Tag:</span>
                                                    <span class='text-gray-500'>{$state}</span>
                                                </div>
                                            ")
                                            ->html(),

                                        // Details button
                                        TextColumn::make('details')
                                            ->label('')
                                            ->formatStateUsing(fn () => "
                                                <div class='mt-2'>
                                                    <button class='bg-orange-500 text-white py-1 px-4 rounded-md'>Details</button>
                                                </div>
                                            ")
                                            ->html(),
                                    ])
                                    ->extraAttributes([
                                        'class' => 'ml-4 flex flex-col justify-start space-y-2', // Spacing between text items
                                    ]),
                            ])
                            ->extraAttributes([
                                'class' => 'flex items-center bg-white rounded-lg shadow p-4 space-x-4',
                                'style' => 'border: 1px solid #e5e7eb;', 
                            ]),
                    ])
            ])
            ->contentGrid(['md' => 3]) 
            ->paginationPageOptions([5, 10, 15])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->options(Category::all()->pluck('name', 'id')->toArray()),

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
            ->actions([
                Tables\Actions\ViewAction::make('view')
                ->label('View')
                ->url(fn (Blog $record): string => ViewBlog::getUrl(['record' => $record->id]))
                ->icon('heroicon-o-eye')
                ->color('primary')
                ->openUrlInNewTab(false)
            ]);
            // ->recordurl(function($record){
            //     if($record->trashed()){
            //         return null;
            //     }
            //      return pages\ViewBlog::getUrl([$record->id]);
            // }); 
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make()
                    ->schema([
                        Components\Split::make([
                            Components\Grid::make(2)
                                ->schema([
                                    Components\Group::make([
                                        Components\TextEntry::make('title'),
                                        Components\TextEntry::make('slug'),
                                        Components\TextEntry::make('created_at')
                                            ->badge()
                                            ->date()
                                            ->color('success'),
                                    ]),
                                    Components\Group::make([
                                        Components\TextEntry::make('status'),
                                        Components\TextEntry::make('Category.name'),
                                    ]),
                                ]),
                            Components\ImageEntry::make('image')
                                ->hiddenLabel()
                                ->grow(false),
                        ])->from('lg'),
                    ]),
                Components\Section::make('Content')
                    ->schema([
                        Components\TextEntry::make('description')
                            ->prose()
                            ->markdown()
                            ->hiddenLabel(),
                    ])
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
            'show'=>pages\ViewBlog::route('/{record}/show'),
        ];
    }

    public static function getView(): string
    {
        return 'filament.user-panel.pages.blog-view';
    }
}
