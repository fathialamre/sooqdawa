<?php

namespace App\Filament\Resources\SavedPosts\Schemas;

use App\Models\Post;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class SavedPostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('SavedPostTabs')
                    ->tabs([
                        Tab::make(__('messages.saved_post.form.section.basic.title'))
                            ->icon('heroicon-o-bookmark')
                            ->schema([
                                Select::make('user_id')
                                    ->label(__('messages.saved_post.form.fields.user'))
                                    ->options(User::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->placeholder(__('messages.saved_post.form.placeholders.select_user')),
                                
                                Select::make('post_id')
                                    ->label(__('messages.saved_post.form.fields.post'))
                                    ->options(Post::all()->pluck('description', 'id'))
                                    ->searchable()
                                    ->required()
                                    ->placeholder(__('messages.saved_post.form.placeholders.select_post')),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
