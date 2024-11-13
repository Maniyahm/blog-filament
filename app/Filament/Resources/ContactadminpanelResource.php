<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactadminpanelResource\Pages;
use App\Filament\Resources\ContactadminpanelResource\RelationManagers;
use App\Models\ContactUs;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;

class ContactadminpanelResource extends Resource
{
    protected static ?string $model = Contactus::class;


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
                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('reason')
                    ->label('Reason')
                    ->sortable(),

                TextColumn::make('subject')
                    ->label('Subject')
                    ->limit(50), 

                TextColumn::make('created_at')
                    ->label('Submitted On')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('reason')
                    ->options([
                        'support' => 'Support',
                        'feedback' => 'Feedback',
                        'sales' => 'Sales',
                        'other' => 'Other',
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), 
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
            'index' => Pages\ListContactadminpanels::route('/'),
        ];
    }
}
