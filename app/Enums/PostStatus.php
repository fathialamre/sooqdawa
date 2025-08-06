<?php

namespace App\Enums;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public function getLabel(): string
    {
        return match ($this) {
            self::DRAFT => __('messages.post.status.draft'),
            self::PUBLISHED => __('messages.post.status.published'),
            self::ARCHIVED => __('messages.post.status.archived'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::DRAFT => 'warning',
            self::PUBLISHED => 'success',
            self::ARCHIVED => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::DRAFT => 'heroicon-o-document-text',
            self::PUBLISHED => 'heroicon-o-check-circle',
            self::ARCHIVED => 'heroicon-o-archive-box',
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())->mapWithKeys(function ($status) {
            return [$status->value => $status->getLabel()];
        })->toArray();
    }

    public static function getIcons(): array
    {
        return collect(self::cases())->mapWithKeys(function ($status) {
            return [$status->value => $status->getIcon()];
        })->toArray();
    }

    public static function getColors(): array
    {
        return collect(self::cases())->mapWithKeys(function ($status) {
            return [$status->value => $status->getColor()];
        })->toArray();
    }
}