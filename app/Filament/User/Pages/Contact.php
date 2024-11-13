<?php

namespace App\Filament\User\Pages;

use Filament\Forms;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Models\ContactUs;
use Filament\Notifications\Notification;

class Contact extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Contact Us';
    protected static string $view = 'filament.user.pages.contact';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Information';
    
    public $name;
    public $email;
    public $reason;
    public $subject;

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->required(),
             
            
            Forms\Components\TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),
            
            Forms\Components\Select::make('reason')
                ->label('Reason')
                ->options([
                    'support' => 'Support',
                    'feedback' => 'Feedback',
                    'sales' => 'Sales',
                    'other' => 'Other',
                ])
                ->required(),
            
            Forms\Components\TextInput::make('subject')
                ->label('Subject')
                ->required(),
        ];
    }

    public function submit(): void
    {
        ContactUs::create([
            'name' => $this->name,
            'email' => $this->email,
            'reason' => $this->reason,
            'subject' => $this->subject,
        ]);

        // Provide feedback to the user
        Notification::make()
        ->title('Success')
        ->body('Your message has been sent successfully!')
        ->success()
        ->send();
    }

    protected function getActions(): array
    {
        return [
            \Filament\Pages\Actions\ButtonAction::make('Submit')
                ->action('submit')
                ->label('Submit Form')
                ->button(),
        ];
    }
}
