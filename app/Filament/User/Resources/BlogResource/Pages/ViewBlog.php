<?php
namespace App\Filament\User\Resources\BlogResource\Pages;

use App\Filament\User\Resources\BlogResource;
use App\Models\Reaction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Pages\Actions\ButtonAction;
use Barryvdh\DomPDF\Facade\Pdf;

class ViewBlog extends ViewRecord
{
    protected static string $resource = BlogResource::class;

    protected function getActions(): array
    {
        $blogUrl = url()->current(); 

        return [
            ButtonAction::make('react')
                ->label('😊') 
                ->color('primary')
                ->modalHeading('Choose a Reaction')
                ->modalWidth('sm')
                ->modalActions([
                    ButtonAction::make('like')
                        ->label('👍')
                        ->action(fn () => $this->addReaction('like'))
                        ->close(),
                    ButtonAction::make('happy')
                        ->label('😊')
                        ->action(fn () => $this->addReaction('happy'))
                        ->close(),
                    ButtonAction::make('sad')
                        ->label('😢')
                        ->action(fn () => $this->addReaction('sad'))
                        ->close(),
                    ButtonAction::make('motivating')
                        ->label('💪')
                        ->action(fn () => $this->addReaction('motivating'))
                        ->close(),
                ]),

            ButtonAction::make('share')
                ->label('📤 Share') 
                ->color('primary')
                ->modalHeading('Share on Social Media')
                ->modalWidth('sm')
                ->modalActions([
                    ButtonAction::make('share_whatsapp')
                        ->label('WhatsApp')
                        ->url("https://wa.me/?text=" . urlencode($blogUrl)) 
                        ->openUrlInNewTab(),
                    ButtonAction::make('share_facebook')
                        ->label('Facebook')
                        ->url("https://www.facebook.com/sharer/sharer.php?u=" . urlencode($blogUrl)) 
                        ->openUrlInNewTab(),
                    ButtonAction::make('share_twitter')
                        ->label('Twitter')
                        ->url("https://twitter.com/intent/tweet?url=" . urlencode($blogUrl))
                        ->openUrlInNewTab(),
                ]),

            ButtonAction::make('download')
                ->label('⬇️ Download') 
                ->action('downloadBlog')
                ->color('primary')
        ];
    }

    protected function addReaction(string $reactionType): void
    {
        $reaction = Reaction::firstOrCreate(['blog_id' => $this->record->id]);
        $reaction->increment($reactionType);
        $reaction->save();
    }

    public function downloadBlog()
    {
        $blog = $this->record;
        $pdf = Pdf::loadView('pdf.blog', ['blog' => $blog]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $blog->title . '.pdf');
    }
}
