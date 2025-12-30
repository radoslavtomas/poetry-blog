<?php

namespace App\Filament\Resources\Books\Tables;

use App\Filament\Traits\TranslationHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BooksTable
{
    use TranslationHelper;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover')
                    ->disk('public'),

                TextColumn::make('title')
                    ->state(function ($record) {
                        return self::getTranslation($record->title);
                    })
                    ->searchable(),

                TextColumn::make('publishing_year')
                    ->label('Year')
                    ->sortable(),

                TextColumn::make('publishing_house')
                    ->state(function ($record) {
                        return self::getTranslation($record->publishing_house);
                    })
                    ->label('Publisher'),

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
            ])
            ->defaultSort('publishing_year', 'desc');
    }
}
