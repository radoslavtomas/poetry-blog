<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AuthorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Name')
                    ->required(),
                    
                KeyValue::make('bio')
                    ->label('Bio (Translations)')
                    ->keyLabel('Language Code')
                    ->valueLabel('Bio Text')
                    ->addable(false)
                    ->deletable(false)
                    ->default(['sk' => '', 'en' => ''])
                    ->required(),
                    
                FileUpload::make('image_path')
                    ->label('Author Image')
                    ->image()
                    ->directory('authors')
                    ->nullable(),
            ]);
    }
}
