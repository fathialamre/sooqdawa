<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum BannerType: string implements HasLabel, HasColor, HasIcon
{
    case POST = 'post';
    case DEPARTMENT = 'department';
    case EXTERNAL_LINK = 'external_link';
    case NONE = 'none';

    public function getLabel(): string
    {
        return match ($this) {
            self::POST => __('messages.banner.types.post'),
            self::DEPARTMENT => __('messages.banner.types.department'),
            self::EXTERNAL_LINK => __('messages.banner.types.external_link'),
            self::NONE => __('messages.banner.types.none'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::POST => 'success',
            self::DEPARTMENT => 'warning',
            self::EXTERNAL_LINK => 'info',
            self::NONE => 'gray',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::POST => 'heroicon-o-document-text',
            self::DEPARTMENT => 'heroicon-o-building-office',
            self::EXTERNAL_LINK => 'heroicon-o-link',
            self::NONE => 'heroicon-o-minus',
        };
    }
}