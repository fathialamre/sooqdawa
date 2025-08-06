<?php

namespace App\Filament\Resources\Banners\Tables;

use App\Enums\BannerType;
use App\Filament\Resources\Posts\PostResource;
use App\Filament\Resources\Departments\DepartmentResource;
use App\Models\Banner;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('messages.banner.table.columns.id'))
                    ->sortable()
                    ->searchable(),
                SpatieMediaLibraryImageColumn::make('banner_image')
                    ->label(__('messages.banner.table.columns.banner_image'))
                    ->collection('banner_image')
                    ->size(60)
                    ->square(),
                TextColumn::make('type')
                    ->label(__('messages.banner.table.columns.type'))
                    ->formatStateUsing(fn(BannerType $state): string => $state->getLabel())
                    ->badge()
                    ->color(fn(BannerType $state): string => $state->getColor())
                    ->icon(fn(BannerType $state): string => $state->getIcon())
                    ->searchable()
                    ->sortable(),
                TextColumn::make('model')
                    ->label(__('messages.banner.table.columns.model'))
                    ->formatStateUsing(function (?string $state): string {
                        if (!$state)
                            return '—';
                        return match ($state) {
                            'App\\Models\\Post' => 'Post',
                            'App\\Models\\Department' => 'Department',
                            default => class_basename($state),
                        };
                    })
                    ->color('primary')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(function ($record): ?string {
                        if (!$record->model_id || !$record->model) {
                            return null;
                        }

                        return match ($record->model) {
                            'App\\Models\\Post' => PostResource::getUrl('edit', ['record' => $record->model_id]),
                            'App\\Models\\Department' => DepartmentResource::getUrl('edit', ['record' => $record->model_id]),
                            default => null,
                        };
                    })
                    ->openUrlInNewTab()
                    ->searchable()
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('model')
                    ->label(__('messages.banner.table.columns.record'))
                    ->formatStateUsing(function ($state): string {
                        if (!$state)
                            return '—';
                        return match ($state) {
                            'App\\Models\\Post' => __('messages.banner.table.columns.show_post'),
                            'App\\Models\\Department' => __('messages.banner.table.columns.show_department'),
                            default => class_basename($state),
                        };
                    })
                    ->url(function ($record): ?string {
                        if (!$record->model_id || !$record->model) {
                            return null;
                        }

                        return match ($record->model) {
                            'App\\Models\\Post' => PostResource::getUrl('edit', ['record' => $record->model_id]),
                            'App\\Models\\Department' => DepartmentResource::getUrl('edit', ['record' => $record->model_id]),
                            default => null,
                        };
                    })
                    ->openUrlInNewTab()
                    ->color('info')
                    ->icon('heroicon-o-link')
                    ->limit(50)
                    ->placeholder('—')
                    ->searchable(),

                TextColumn::make('model_id')
                    ->label(__('messages.banner.table.columns.model_id'))
                    ->numeric()
                    ->searchable()
                    ->sortable()
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),


                TextColumn::make('external_link')
                    ->label(__('messages.banner.table.columns.external_link'))
                    ->url(fn($state): ?string => $state)
                    ->openUrlInNewTab()
                    ->color('info')
                    ->icon('heroicon-o-link')
                    ->limit(50)
                    ->placeholder('—')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->label(__('messages.banner.table.columns.is_active'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('created_at')
                    ->label(__('messages.banner.table.columns.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->since()
                ,
                TextColumn::make('updated_at')
                    ->label(__('messages.banner.table.columns.updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label(__('messages.banner.table.columns.deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('messages.banner.filters.type'))
                    ->options(BannerType::class),
                SelectFilter::make('is_active')
                    ->label(__('messages.banner.filters.is_active'))
                    ->options([
                        '1' => __('messages.common.active'),
                        '0' => __('messages.common.inactive'),
                    ]),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
