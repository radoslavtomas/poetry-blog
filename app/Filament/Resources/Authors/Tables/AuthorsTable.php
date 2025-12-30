<?php

namespace App\Filament\Resources\Authors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AuthorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Image')
                    ->disk('public')
                    ->circular(),
                    
                TextColumn::make('name')
                    ->searchable(),
                    
                TextColumn::make('bio')
                    ->formatStateUsing(fn ($state, $record) => is_array($state) ? ($state['sk'] ?? $state['en'] ?? 'N/A') : ($record->bio['sk'] ?? $record->bio['en'] ?? 'N/A'))
                    ->limit(100),
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
