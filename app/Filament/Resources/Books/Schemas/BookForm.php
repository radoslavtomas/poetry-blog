<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookForm
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
                    
                FileUpload::make('cover')
                    ->label('Cover Image')
                    ->image()
                    ->directory('books')
                    ->nullable(),
                    
                TextInput::make('publishing_year')
                    ->label('Publishing Year')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(2100)
                    ->required(),
                    
                KeyValue::make('publishing_house')
                    ->label('Publishing House (Translations)')
                    ->keyLabel('Language Code')
                    ->valueLabel('Publisher Name')
                    ->addable(false)
                    ->deletable(false)
                    ->default(['sk' => '', 'en' => ''])
                    ->required(),
                    
                KeyValue::make('description')
                    ->label('Description (Translations)')
                    ->keyLabel('Language Code')
                    ->valueLabel('Description')
                    ->addable(false)
                    ->deletable(false)
                    ->default(['sk' => '', 'en' => ''])
                    ->required(),
                    
                FileUpload::make('pdf_path')
                    ->label('PDF File')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('books')
                    ->nullable(),
            ]);
    }
}
