<?php

namespace App\Filament\Resources\Banners\Schemas;

use App\Models\Post;
use App\Enums\BannerType;
use App\Models\Department;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;


class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('messages.banner.form.section.basic'))
                    ->description(__('messages.banner.form.section.basic_description'))
                    ->schema([
                        Select::make('type')
                            ->label(__('messages.banner.fields.type'))
                            ->options(BannerType::class)
                            ->default(BannerType::NONE)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('model_id', null))
                            ->afterStateHydrated(function (Set $set, Get $get, $state) {
                                if ($state && in_array($state, [BannerType::POST, BannerType::DEPARTMENT])) {
                                    $modelClass = match ($state) {
                                        BannerType::POST => Post::class,
                                        BannerType::DEPARTMENT => Department::class,
                                        default => null,
                                    };
                                    $set('model', $modelClass);
                                }
                            }),

                        Select::make('model_id')
                            ->label(fn (Get $get) => match ($get('type')) {
                                BannerType::POST => __('messages.banner.fields.post'),
                                BannerType::DEPARTMENT => __('messages.banner.fields.department'),
                                default => 'Target',
                            })
                            ->options(function (Get $get): array {
                                return match ($get('type')) {
                                    BannerType::POST => Post::where('company', '!=', null)
                                        ->where('company', '!=', '')
                                        ->where('description', '!=', null)
                                        ->get()
                                        ->mapWithKeys(fn ($post) => [
                                            $post->id => "#{$post->id} - {$post->company} - " . Str::limit($post->description, 50)
                                        ])
                                        ->toArray(),
                                    BannerType::DEPARTMENT => Department::where('is_active', true)
                                        ->get()
                                        ->mapWithKeys(fn ($dept) => [
                                            $dept->id => "#{$dept->id} - {$dept->name}"
                                        ])
                                        ->toArray(),
                                    default => [],
                                };
                            })
                            ->searchable()
                            ->preload()
                            ->visible(fn (Get $get) => in_array($get('type'), [BannerType::POST, BannerType::DEPARTMENT]))
                            ->required(fn (Get $get) => in_array($get('type'), [BannerType::POST, BannerType::DEPARTMENT]))
                            ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                if ($state) {
                                    $modelClass = match ($get('type')) {
                                        BannerType::POST => Post::class,
                                        BannerType::DEPARTMENT => Department::class,
                                        default => null,
                                    };
                                    $set('model', $modelClass);
                                } else {
                                    $set('model', null);
                                }
                            }),

                        // Hidden field to ensure model gets saved
                        TextInput::make('model')
                            ->hidden()
                            ->dehydrated()
                            ->default(null)
                            ->required(fn (Get $get) => in_array($get('type'), [BannerType::POST, BannerType::DEPARTMENT])),

                        TextInput::make('external_link')
                            ->label(__('messages.banner.fields.external_link'))
                            ->url()
                            ->placeholder('https://example.com')
                            ->visible(fn (Get $get) => $get('type') === BannerType::EXTERNAL_LINK)
                            ->required(fn (Get $get) => $get('type') === BannerType::EXTERNAL_LINK),

                        Toggle::make('is_active')
                            ->label(__('messages.banner.fields.is_active'))
                            ->default(true)
                            ->required(),
                    ]),

                Section::make(__('messages.banner.form.section.image'))
                    ->description(__('messages.banner.form.section.image_description'))
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('banner_image')
                            ->label(__('messages.banner.fields.banner_image'))
                            ->collection('banner_image')
                            ->image()
                            ->maxSize(5120) // 5MB
                            ->columnSpanFull(),
                    ]),

            ]);
    }
}
