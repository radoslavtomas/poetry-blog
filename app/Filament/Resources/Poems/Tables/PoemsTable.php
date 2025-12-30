<?php

namespace App\Filament\Resources\Poems\Tables;

use App\Filament\Traits\TranslationHelper;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PoemsTable
{
    use TranslationHelper;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->state(function ($record) {
                        return self::getTranslation($record->title);
                    })
                    ->searchable(),

                TextColumn::make('book.title')
                    ->state(function ($record) {
                        if (!$record || !$record->book) return '-';
                        return self::getTranslation($record->book->title);
                    })
                    ->label('Book')
                    ->sortable(),

                TextColumn::make('source.name')
                    ->state(function ($record) {
                        if (!$record || !$record->source) return '-';
                        return self::getTranslation($record->source->name);
                    })
                    ->label('Source')
                    ->sortable(),

                TextColumn::make('position_in_book')
                    ->label('Position')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('book_id')
                    ->relationship('book', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => self::getTranslation($record->title))
                    ->label('Book'),

                SelectFilter::make('source_id')
                    ->relationship('source', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => self::getTranslation($record->name))
                    ->label('Source'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
