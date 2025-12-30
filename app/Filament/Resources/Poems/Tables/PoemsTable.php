<?php

namespace App\Filament\Resources\Poems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PoemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->formatStateUsing(fn ($state, $record) => is_array($state) ? ($state['sk'] ?? $state['en'] ?? 'N/A') : ($record->title['sk'] ?? $record->title['en'] ?? 'N/A'))
                    ->searchable(),
                    
                TextColumn::make('book.title')
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state['sk'] ?? $state['en'] ?? '-') : '-')
                    ->label('Book')
                    ->sortable(),
                    
                TextColumn::make('source.name')
                    ->formatStateUsing(fn ($state) => is_array($state) ? ($state['sk'] ?? $state['en'] ?? '-') : '-')
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
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->title['sk'] ?? $record->title['en'] ?? 'Unknown')
                    ->label('Book'),
                    
                SelectFilter::make('source_id')
                    ->relationship('source', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name['sk'] ?? $record->name['en'] ?? 'Unknown')
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
