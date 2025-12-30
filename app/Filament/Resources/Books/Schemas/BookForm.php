<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BookForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Repeater::make('title')
                    ->label('Title (Translations)')
                    ->schema([
                        TextInput::make('lang')
                            ->label('Language Code')
                            ->required()
                            ->maxLength(2),
                        RichEditor::make('content')
                            ->label('Title')
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

                Repeater::make('publishing_house')
                    ->label('Publishing House (Translations)')
                    ->schema([
                        TextInput::make('lang')
                            ->label('Language Code')
                            ->required()
                            ->maxLength(2),
                        RichEditor::make('content')
                            ->label('Publisher Name')
                            ->required()
                            ->toolbarButtons([
                                'bold',
                                'italic',
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

                Repeater::make('description')
                    ->label('Description (Translations)')
                    ->schema([
                        TextInput::make('lang')
                            ->label('Language Code')
                            ->required()
                            ->maxLength(2),
                        RichEditor::make('content')
                            ->label('Description')
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

                FileUpload::make('pdf_path')
                    ->label('PDF File')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('books')
                    ->nullable(),
            ])->columns(1);
    }
}
