<?php

namespace App\Filament\Resources\Sources\Tables;

use App\Filament\Traits\TranslationHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SourcesTable
{
    use TranslationHelper;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->state(function ($record) {
                        return self::getTranslation($record->name);
                    })
                    ->searchable(),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'newspaper' => 'gray',
                        'magazine' => 'info',
                        'website' => 'success',
                        'other' => 'warning',
                    }),

                TextColumn::make('url')
                    ->limit(50),

                TextColumn::make('poems_count')
                    ->counts('poems')
                    ->label('Poems'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
