<?php

namespace App\Filament\Resources\Poems\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PoemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                KeyValue::make('title')
                    ->label('Title (Translations)')
                    ->keyLabel('Language Code')
                    ->valueLabel('Title')
                    ->addable(false)
                    ->deletable(false)
                    ->default(['sk' => '', 'en' => ''])
                    ->required(),
                    
                KeyValue::make('body')
                    ->label('Body (Translations)')
                    ->keyLabel('Language Code')
                    ->valueLabel('Body Text')
                    ->addable(false)
                    ->deletable(false)
                    ->default(['sk' => '', 'en' => ''])
                    ->required(),
                    
                Select::make('book_id')
                    ->label('Book')
                    ->relationship('book', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->title['sk'] ?? $record->title['en'] ?? 'Unknown')
                    ->searchable()
                    ->nullable()
                    ->reactive(),
                    
                TextInput::make('position_in_book')
                    ->label('Position in Book')
                    ->numeric()
                    ->nullable()
                    ->hidden(fn (callable $get) => !$get('book_id')),
                    
                Select::make('source_id')
                    ->label('Source')
                    ->relationship('source', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->name['sk'] ?? $record->name['en'] ?? 'Unknown')
                    ->searchable()
                    ->nullable()
                    ->hidden(fn (callable $get) => $get('book_id')),
            ]);
    }
}
