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
    protected static function getTranslation($state): string
    {
        if (!is_array($state)) {
            return 'N/A';
        }
        
        // Check if it's repeater format: [{"lang":"sk","content":"..."}, ...]
        if (isset($state[0]) && is_array($state[0]) && isset($state[0]['lang'])) {
            // Try to find Slovak translation
            foreach ($state as $item) {
                if (isset($item['lang']) && $item['lang'] === 'sk' && isset($item['content'])) {
                    return strip_tags($item['content']);
                }
            }
            // Fallback to first available
            foreach ($state as $item) {
                if (isset($item['content'])) {
                    return strip_tags($item['content']);
                }
            }
            return 'N/A';
        }
        
        // Old format: {"sk": "...", "en": "..."}
        return $state['sk'] ?? $state['en'] ?? 'N/A';
    }
    
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')
                    ->label('Cover')
                    ->disk('public'),
                    
                TextColumn::make('title')
                    ->formatStateUsing(function ($state) {
                        return self::getTranslation($state);
                    })
                    ->searchable(),
                    
                TextColumn::make('publishing_year')
                    ->label('Year')
                    ->sortable(),
                    
                TextColumn::make('publishing_house')
                    ->formatStateUsing(function ($state) {
                        return self::getTranslation($state);
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
