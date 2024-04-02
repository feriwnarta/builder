<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ComponentsResource\Pages;
use App\Filament\Resources\ComponentsResource\RelationManagers;
use App\Models\Component;
use App\Models\Components;
use Filament\Actions\ViewAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Notifications\Action;
use Nette\Utils\ImageColor;

class ComponentsResource extends Resource
{
    protected static ?string $model = Component::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('categories_id')
                    ->required()
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),
                Forms\Components\TextInput::make('label')
                    ->required()
                    ->minLength(3)
                    ->maxLength(100),
                Forms\Components\FileUpload::make('media')
                    ->label('Preview component')
                    ->required()
                    ->multiple()
                    ->image()
                    ->imageEditor()
                    ->maxSize(1024)
                    ->maxFiles(1)
                    ->columnSpan(4),
                Forms\Components\MarkdownEditor::make('content')
                    ->required()
                    ->columnSpan(4)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('media'),
                Tables\Columns\TextColumn::make('label')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListComponents::route('/'),
            'create' => Pages\CreateComponents::route('/create'),
            'edit' => Pages\EditComponents::route('/{record}/edit'),
            'view' => Pages\ViewComponent::route('/{record}/view'),
        ];
    }
}
