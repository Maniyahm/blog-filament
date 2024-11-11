<?php

namespace App\Filament\Author\Resources;

// use App\Filament\Author\Resources\AuthorBlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;
use App\Filament\Author\Resources\AblogResource\Pages;
use Filament\Tables\Filters\SelectFilter;

class AblogResource extends Resource
{
protected static ?string $model = Blog::class;

protected static ?string $navigationIcon = 'heroicon-o-document-text';
protected static ?string $navigationGroup = 'Author Blog Management';

public static function form(Forms\Form $form): Forms\Form
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
                ->relationship('category', 'name')
                ->required(),

            Forms\Components\TextInput::make('tag')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->required(),
        ]);
}

public static function table(Tables\Table $table): Tables\Table
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
            Forms\Components\TextInput::make('location')
                ->label('Location')
                ->required()
                ->maxLength(255),
            TextColumn::make('tag')
                ->sortable()
                ->searchable(),

            TextColumn::make('created_at')
                ->label('Created At')
                ->dateTime()
                ->sortable(),
        ])
        ->filters([
            SelectFilter::make('status')
                ->label('Approval Status')
                ->options([
                    'approved' => 'Approved',
                    'unapproved' => 'Unapproved',
                ])
                ->default(null) // Optional: set a default value if needed
        ])
        
        
        ->modifyQueryUsing(function ($query) {
            // Restrict authors to only see their own blogs
            $query->where('user_id', auth()->id());
        })
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}


protected static function boot()
{
    parent::boot();

    // Set the 'status' to 'unapproved' automatically when an author creates a blog
    static::creating(function (Blog $blog) {
        if (auth()->check() && auth()->user()->hasRole('author')) {
            $blog->status = 'unapproved';
            $blog->user_id = auth()->id();
        }
    });
}

public static function getPages(): array
{
    return [
        'index' => Pages\ListAblogs::route('/'),
        'create' => Pages\CreateAblog::route('/create'),
        'edit' => Pages\EditAblog::route('/{record}/edit'),
    ];
}
}