<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPost extends ViewRecord
{
    protected static string $resource = PostResource::class;

    public function getTitle(): string
    {
        return __('messages.post.pages.view.title') . ' #' . $this->getRecord()->id;
    }

    public function getBreadcrumbs(): array
    {
        $breadcrumbs = parent::getBreadcrumbs();
        
        // Update the last breadcrumb to include the post ID
        $lastKey = array_key_last($breadcrumbs);
        if ($lastKey !== null) {
            $breadcrumbs[$lastKey] = __('messages.post.pages.view.title') . ' #' . $this->getRecord()->id;
        }
        
        return $breadcrumbs;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
