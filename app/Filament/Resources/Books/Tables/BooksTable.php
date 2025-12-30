<?php

namespace App\Filament\Resources\Books\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BooksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover')
                    ->disk('public'),
                    
                TextColumn::make('title')
                    ->formatStateUsing(fn ($state, $record) => is_array($state) ? ($state['sk'] ?? $state['en'] ?? 'N/A') : ($record->title['sk'] ?? $record->title['en'] ?? 'N/A'))
                    ->searchable(),
                    
                TextColumn::make('publishing_year')
                    ->label('Year')
                    ->sortable(),
                    
                TextColumn::make('publishing_house')
                    ->formatStateUsing(fn ($state, $record) => is_array($state) ? ($state['sk'] ?? $state['en'] ?? 'N/A') : ($record->publishing_house['sk'] ?? $record->publishing_house['en'] ?? 'N/A'))
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
