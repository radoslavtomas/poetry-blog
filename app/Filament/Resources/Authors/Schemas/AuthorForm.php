<?php

namespace App\Filament\Resources\Authors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
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

                Repeater::make('bio')
                    ->label('Bio (Translations)')
                    ->schema([
                        TextInput::make('lang')
                            ->label('Language Code')
                            ->required()
                            ->maxLength(2)
                            ->default(fn ($state, $record) => $state ?? 'sk'),
                        RichEditor::make('content')
                            ->label('Bio Content')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                                'link',
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

                FileUpload::make('image_path')
                    ->label('Author Image')
                    ->image()
                    ->directory('authors')
                    ->nullable(),
            ])->columns(1);
    }
}
