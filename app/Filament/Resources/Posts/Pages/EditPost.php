<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    public function getTitle(): string
    {
        return __('messages.post.pages.edit.title') . ' #' . $this->getRecord()->id;
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();
        
        // Update the last breadcrumb to include the post ID
        $lastKey = array_key_last($breadcrumbs);
        if ($lastKey !== null) {
            $breadcrumbs[$lastKey] = __('messages.post.pages.edit.title') . ' #' . $this->getRecord()->id;
        }
        
        return $breadcrumbs;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
