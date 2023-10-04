<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutputResource\Pages;
use App\Models\Output;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OutputResource extends Resource
{
    protected static ?string $model = Output::class;

    protected static ?string $modelLabel = 'saída';

    protected static ?string $pluralModelLabel = 'saídas';

    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-on-rectangle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Toggle::make('paid')
                    ->label('Pago')
                    ->onColor('success')
                    ->offColor('danger')
                    ->columnSpanFull(),
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
                Forms\Components\DatePicker::make('due_date')
                    ->label('Vencimento')
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
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Valor')
                    ->numeric(2, ',', '.')
                    ->prefix('R$ '),
                Tables\Columns\ToggleColumn::make('paid')
                    ->label('Pago?')
                    ->onColor('success')
                    ->offColor('danger'),
            ])
            ->filters([
                Tables\Filters\Filter::make('paid')
                    ->label('Pago')
                    ->toggle()
                    ->query(function (Builder $query): Builder {
                        return $query->where('paid', true);
                    }),
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
            'index' => Pages\ListOutputs::route('/'),
            'create' => Pages\CreateOutput::route('/create'),
            'edit' => Pages\EditOutput::route('/{record}/edit'),
        ];
    }
}
