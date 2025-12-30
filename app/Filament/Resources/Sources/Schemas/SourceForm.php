<?php

namespace App\Filament\Resources\Sources\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                KeyValue::make('name')
                    ->label('Name (Translations)')
                    ->keyLabel('Language Code')
                    ->valueLabel('Source Name')
                    ->addable(false)
                    ->deletable(false)
                    ->default(['sk' => '', 'en' => ''])
                    ->required(),
                    
                Select::make('type')
                    ->label('Type')
                    ->options([
                        'newspaper' => 'Newspaper',
                        'magazine' => 'Magazine',
                        'website' => 'Website',
                        'other' => 'Other',
                    ])
                    ->required(),
                    
                TextInput::make('url')
                    ->label('URL')
                    ->url()
                    ->nullable(),
            ]);
    }
}
