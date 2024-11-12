<?php

namespace App\Filament\User\Resources;

use App\Filament\User\Resources\BlogResource\Pages;
use App\Filament\User\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\ImageColumn;

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
                // Define a custom grid column layout for a card view
                Grid::make()
                    ->columns(1)
                    ->schema([
                        ImageColumn::make('image')
                        ->label('Image')
                        ->extraAttributes([
                            'class' => 'w-full h-64 object-cover mb-4', // Full width, fixed height, cover style
                            'style' => 'border-radius: 8px;', // Rounded edges for styling
                        ]),
                        
                    TextColumn::make('title')
                        ->label('Title')
                        ->sortable()
                        ->searchable()
                        ->formatStateUsing(fn ($state) => "<h3 class='font-semibold text-lg'>{$state}</h3>")
                        ->html(),
                    
                    TextColumn::make('category.name') // Access the name attribute from the related Category model
                        ->label('Category')
                        ->sortable()
                        ->searchable()
                        ->formatStateUsing(fn ($state) => "<h3 class='font-semibold text-lg'>{$state}</h3>")
                        ->html(),
                    TextColumn::make('location')
                        ->label('Location')
                        ->sortable()
                        ->searchable()
                        ->formatStateUsing(fn ($state) => "<p class='text-gray-600'><strong>Location:</strong> {$state}</p>")
                        ->html(),
    
                    TextColumn::make('tag')
                        ->label('Tag')
                        ->formatStateUsing(fn ($state) => "<p class='text-gray-600'><strong>Tag:</strong> {$state}</p>")
                        ->html(),
    
                    TextColumn::make('status')
                        ->label('Status')
                        ->formatStateUsing(fn ($state) => "<span class='badge badge-primary'>{$state}</span>")
                        ->html(),
                ])
            ])
                    
            ->contentGrid([
                'gridTemplateColumns' => 'repeat(3, minmax(0, 1fr))', // Adjust the number of columns
                'gap' => '1.5rem', // Space between cards
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->options(
                        Category::all()->pluck('name', 'id')->toArray()
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
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (Blog $record): string => route('blog.view', $record)),
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
