<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TemplatesResource\Pages;
use App\Filament\Resources\TemplatesResource\RelationManagers;
use App\Models\Templates;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Notifications\Action;

class TemplatesResource extends Resource
{
    protected static ?string $model = Templates::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subtitle')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_template_id')
                    ->required()
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ])
                    ->columnSpan(3),
                Forms\Components\FileUpload::make('thumbnail')
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->maxSize(1024)
                    ->maxFiles(1)
                    ->columnSpan(4),
            ]);
    }

    public static function table(Table $table): Table
    {

        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('subtitle'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('builder')
                    ->url(fn (Model $record): string => "/builder/?file/q={$record->id}/mode/create")

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTemplates::route('/'),
            'create' => Pages\CreateTemplates::route('/create'),
            'edit' => Pages\EditTemplates::route('/{record}/edit'),
            'view' => Pages\ViewTemplates::route('/{record}/view'),
        ];
    }
}
