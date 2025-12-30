<?php

namespace App\Filament\Resources\Books\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
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
                    ->required()
                    ->afterStateHydrated(function ($component, $state) {
                        // Check if state is in JSON format (has 'sk', 'en' keys directly)
                        if (is_array($state) && array_key_exists('sk', $state)) {
                            // Convert JSON format to repeater format
                            $component->state([
                                ['lang' => 'sk', 'content' => $state['sk'] ?? ''],
                                ['lang' => 'en', 'content' => $state['en'] ?? ''],
                            ]);
                        }
                    })
                    ->dehydrateStateUsing(function ($state) {
                        if (!is_array($state)) {
                            return ['sk' => '', 'en' => ''];
                        }

                        $result = ['sk' => '', 'en' => ''];
                        foreach ($state as $item) {
                            if (isset($item['lang']) && isset($item['content'])) {
                                $result[$item['lang']] = $item['content'];
                            }
                        }

                        return $result;
                    }),

                FileUpload::make('pdf_path')
                    ->label('PDF File')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('books')
                    ->nullable(),
            ])->columns(1);
    }
}
