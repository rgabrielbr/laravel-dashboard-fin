<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InputResource\Pages;
use App\Models\Input;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InputResource extends Resource
{
    protected static ?string $model = Input::class;

    protected static ?string $modelLabel = 'entrada';

    protected static ?string $pluralModelLabel = 'entradas';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-left-on-rectangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('account_id')
                    ->label('Conta')
                    ->relationship('account', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('title')
                    ->label('Título')
                    ->required()
                    ->columnSpan(1),
                Forms\Components\TextInput::make('value')
                    ->label('Valor')
                    ->numeric()
                    ->prefix('R$')
                    ->maxValue(42949672.95)
                    ->required()
                    ->columnSpan(1),
                Forms\Components\DatePicker::make('date')
                    ->label('Data')
                    ->required()
                    ->columnSpan(1),
                Forms\Components\Textarea::make('description')
                    ->label('Descrição')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Título')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->numeric(2, ',', '.')
                    ->prefix('R$ '),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('account_id')
                    ->label('Conta')
                    ->relationship('account', 'name')
                    ->preload()
                    ->searchable(),
            ])
            ->actions([
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
            'index' => Pages\ListInputs::route('/'),
            'create' => Pages\CreateInput::route('/create'),
            'edit' => Pages\EditInput::route('/{record}/edit'),
        ];
    }
}
