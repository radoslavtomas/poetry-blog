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
                    ->state(function ($record) {
                        // Get the raw bio data from the record
                        $bio = $record->bio;

                        if (empty($bio)) {
                            return 'N/A';
                        }

                        // Convert ArrayObject or object to array if needed
                        if (is_object($bio)) {
                            $bio = json_decode(json_encode($bio), true);
                        }

                        if (!is_array($bio)) {
                            return 'N/A';
                        }

                        // Handle new format: [{"lang":"sk","content":"..."},{"lang":"en","content":"..."}]
                        // Try Slovak first
                        foreach ($bio as $item) {
                            if (is_array($item) && isset($item['lang']) && $item['lang'] === 'sk' && isset($item['content'])) {
                                return strip_tags($item['content']);
                            }
                        }

                        // Fallback to first item with content
                        if (is_array($bio[0]) && isset($bio[0]['content'])) {
                            return strip_tags($bio[0]['content']);
                        }

                        return 'N/A';
                    })
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
