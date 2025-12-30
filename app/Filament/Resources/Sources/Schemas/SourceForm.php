<?php

namespace App\Filament\Resources\Sources\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Repeater::make('name')
                    ->label('Name (Translations)')
                    ->schema([
                        TextInput::make('lang')
                            ->label('Language Code')
                            ->required()
                            ->maxLength(2),
                        RichEditor::make('content')
                            ->label('Source Name')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                            ]),
                    ])
                    ->defaultItems(2)
                    ->default([
                        ['lang' => 'sk', 'content' => ''],
                        ['lang' => 'en', 'content' => ''],
                    ])
                    ->addable(false)
                    ->deletable(false)
                    ->reorderable(false)
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => strtoupper($state['lang'] ?? 'Translation'))
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
