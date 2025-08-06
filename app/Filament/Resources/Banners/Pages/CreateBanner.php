<?php

namespace App\Filament\Resources\Banners\Pages;

use App\Enums\BannerType;
use App\Filament\Resources\Banners\BannerResource;
use App\Models\Department;
use App\Models\Post;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure model field is set based on type and model_id
        if (isset($data['type']) && isset($data['model_id']) && $data['model_id']) {
            $type = $data['type'];
            $typeValue = $type instanceof BannerType ? $type->value : $type;
            
            $data['model'] = match ($typeValue) {
                BannerType::POST->value => Post::class,
                BannerType::DEPARTMENT->value => Department::class,
                default => null,
            };
        }

        return $data;
    }
} 