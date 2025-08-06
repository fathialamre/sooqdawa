<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('PostTabs')
                    ->tabs([
                        Tab::make(__('messages.post.form.section.basic'))
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Select::make('department_id')
                                    ->label(__('messages.post.form.fields.department_id'))
                                    ->relationship('department', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                TextInput::make('company')
                                    ->label(__('messages.post.form.fields.company'))
                                    ->maxLength(255),

                                TextInput::make('activity')
                                    ->label(__('messages.post.form.fields.activity'))
                                    ->maxLength(255),
                                    Select::make('status')
                                    ->label(__('messages.post.form.fields.status'))
                                    ->options(PostStatus::getOptions())
                                    ->required()
                                    ->default(PostStatus::DRAFT->value),

                                Textarea::make('description')
                                    ->label(__('messages.post.form.fields.description'))
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull(),

                                    

                                TagsInput::make('tags')
                                    ->label(__('messages.post.form.fields.tags'))
                                    ->placeholder('أضف علامة واضغط Enter')
                                    ->columnSpanFull(),
                            ])
                            ->columns(2),

                        Tab::make(__('messages.post.form.section.location'))
                            ->icon('heroicon-o-map-pin')
                            ->schema([
                                Select::make('country_id')
                                    ->label(__('messages.post.form.fields.country_id'))
                                    ->relationship('country', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                Select::make('city_id')
                                    ->label(__('messages.post.form.fields.city_id'))
                                    ->relationship('city', 'name')
                                    ->searchable()
                                    ->preload(),

                                Textarea::make('address')
                                    ->label(__('messages.post.form.fields.address'))
                                    ->rows(2)
                                    ->columnSpanFull(),

                                TextInput::make('phone')
                                    ->label(__('messages.post.form.fields.phone'))
                                    ->tel()
                                    ->maxLength(20),
                            ])
                            ->columns(2),

                        Tab::make(__('messages.post.form.section.pricing'))
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                TextInput::make('price')
                                    ->label(__('messages.post.form.fields.price'))
                                    ->numeric()
                                    ->step(0.01)
                                    ->minValue(0),

                                Select::make('currency')
                                    ->label(__('messages.post.form.fields.currency'))
                                    ->options([
                                        'د.ل' => __('messages.post.currency.lyds'),
                                        'دولار' => __('messages.post.currency.usd'),
                                        'يورو' => __('messages.post.currency.eur'),
                                    ]),
                            ])
                            ->columns(2),

                        Tab::make(__('messages.post.form.section.media'))
                            ->icon('heroicon-o-photo')
                            ->schema([
                                SpatieMediaLibraryFileUpload::make('images')
                                    ->label(__('messages.post.form.fields.images'))
                                    ->collection('images')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->imageEditor()
                                    ->imagePreviewHeight('200')
                                    ->maxFiles(10)
                                    ->maxSize(size: 5120) // 5MB
                                    ->panelLayout('grid')
                                    ->helperText('يمكنك رفع حتى 10 صور للمنشور'),
                            ]),

                       
                    ])
                    ->activeTab(1)
                    ->persistTab()
                    ->columnSpanFull()
                    ->id('post-form-tabs'),
            ]);
    }
}
