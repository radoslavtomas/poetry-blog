<?php

namespace App\Filament\Resources\Poems\Schemas;

use App\Filament\Traits\TranslationHelper;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PoemForm
{
    use TranslationHelper;

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

                Repeater::make('body')
                    ->label('Body (Translations)')
                    ->schema([
                        TextInput::make('lang')
                            ->label('Language Code')
                            ->required()
                            ->maxLength(2),
                        RichEditor::make('content')
                            ->label('Body Text')
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

                Select::make('book_id')
                    ->label('Book')
                    ->relationship('book', 'id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => self::getTranslation($record->title))
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
                    ->getOptionLabelFromRecordUsing(fn ($record) => self::getTranslation($record->name))
                    ->searchable()
                    ->nullable()
                    ->hidden(fn (callable $get) => $get('book_id')),
            ])->columns(1);
    }
}
