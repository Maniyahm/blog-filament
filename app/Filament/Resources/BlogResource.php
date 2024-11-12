<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog Management';

    public static function form(Forms\Form $form): Forms\Form // Use Filament\Forms\Form instead of Filament\Resources\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->maxLength(255),

                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->nullable(),
                    
                Forms\Components\Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name') // Assumes category has a 'name' attribute
                    ->required(),

                Forms\Components\TextInput::make('tag')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('location')
                    ->label('Location')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Select::make('status')
                    ->options([
                        'unapproved' => 'Unapproved',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('unapproved')
                    ->required(),

                Forms\Components\Textarea::make('description')
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table // Use Filament\Tables\Table instead of Filament\Resources\Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Author Name'),


                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)) // Capitalize the state
                    ->colors([
                        'primary' => 'unapproved',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),
                

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'unapproved' => 'Unapproved',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
