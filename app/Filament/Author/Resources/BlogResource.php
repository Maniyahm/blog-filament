<?php

namespace App\Filament\Author\Resources;

use App\Filament\Author\Resources\BlogResource\Pages;
use App\Models\Blog;
use App\Models\DailyBlogView;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\BlogApprovedNotification;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Blog Management';

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

                Forms\Components\TagsInput::make('tags')
                    ->placeholder('Add a tag')
                    ->required()
                    ->separator(','),
                
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('location')
                    ->label('Location')
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
                    ->label('Author Name')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
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

                Action::make('downloadReport')
                    ->label('Download Blog Report')
                    ->action(function (Blog $record) {
                        $data = DailyBlogView::where('blog_id', $record->id)
                            ->orderBy('view_date', 'asc')
                            ->get(['blog_id', 'view_date', 'view_count']);
                        $svgContent = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
                        $svgContent .= '<svg xmlns="http://www.w3.org/2000/svg" width="800" height="400">';
                        $svgContent .= '
                            <style>
                                .header { font-size: 14px; fill: #333; font-weight: bold; }
                                .row { font-size: 12px; fill: #333; }
                                .title { font-size: 16px; fill: #333; text-anchor: middle; font-weight: bold; }
                            </style>';
                        $svgContent .= '<text x="400" y="30" class="title">Blog ' . $record->id . ' - View Report</text>';
                        $svgContent .= '<text x="50" y="60" class="header">Blog ID</text>';
                        $svgContent .= '<text x="300" y="60" class="header">View Date</text>';
                        $svgContent .= '<text x="550" y="60" class="header">View Count</text>';
                        $y = 90; 
                        foreach ($data as $entry) {
                            $viewDate = Carbon::parse($entry->view_date)->format('M d, Y');
                            
                            $svgContent .= "<text x='50' y='{$y}' class='row'>{$entry->blog_id}</text>";
                            $svgContent .= "<text x='300' y='{$y}' class='row'>{$viewDate}</text>";
                            $svgContent .= "<text x='550' y='{$y}' class='row'>{$entry->view_count}</text>";
                            
                            $y += 20; 
                        }
                        $svgContent .= '</svg>';
                        $fileName = "blog_{$record->id}_view_report.svg";
                        $filePath = public_path("reports/{$fileName}");
                
                        if (!file_exists(public_path('reports'))) {
                            mkdir(public_path('reports'), 0777, true);
                        }                
                        file_put_contents($filePath, $svgContent);
                        return Response::download($filePath, $fileName, [
                            'Content-Type' => 'image/svg+xml',
                            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                        ]);
                    })
                    ->requiresConfirmation()
                    ->color('primary') 
                     
            ])
            // ->actions([
            //     Action::make('approve')
            //         ->label('Approve Blog')
            //         ->action(function ($record) {
            //             // Update the blog status
            //             $record->update(['status' => 'approved']);
    
            //             // Find admins to notify
            //             $admins = User::where('role', 'admin')->get();
    
            //             // Send the BlogApprovedNotification to each admin
            //             Notification::send($admins, new BlogApprovedNotification($record));
    
            //             // Show a success notification in Filament
            //             Filament::notify('success', 'Blog approved and admins notified.');
            //         })
            //         ->requiresConfirmation()
            //         ->color('success'),
            // ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    public static function exportLast30DaysReport($blogId)
    {
        $date = now()->subDays(30);
        
        $data = DailyBlogView::where('blog_id', $blogId)
            ->where('view_date', '>=', $date)
            ->orderBy('view_date', 'desc')
            ->get(['view_date', 'view_count']);

        $csvContent = "Date,View Count\n";
        foreach ($data as $entry) {
            $csvContent .= "{$entry->view_date},{$entry->view_count}\n";
        }

        $fileName = "blog_{$blogId}_last_30_days_report.csv";

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
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
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }
}
