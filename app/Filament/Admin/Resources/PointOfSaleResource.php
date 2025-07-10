<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PointOfSaleResource\Pages;
use App\Filament\Admin\Resources\PointOfSaleResource\RelationManagers;
use App\Models\PointOfSale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PointOfSaleResource extends Resource
{
    protected static ?string $model = PointOfSale::class;

    protected static ?string $label = 'Ponto de Doação';

    protected static ?string $pluralLabel = 'Pontos de Doação';

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nome do Ponto de Doação')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Digite o nome do ponto de doação'),
                Forms\Components\TextInput::make('business_name')
                    ->label('Razão Social')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('registration_number')
                    ->label('CNPJ')
                    ->required()
                    ->maxLength(14),
                Forms\Components\Select::make('manager_id')
                    ->label('Gerente')
                    ->relationship('manager', 'name')
                    ->required(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('registration_number')
                    ->label('CNPJ')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('manager.name')
                    ->label('Gerente')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListPointOfSales::route('/'),
            'create' => Pages\CreatePointOfSale::route('/create'),
            'view' => Pages\ViewPointOfSale::route('/{record}'),
            'edit' => Pages\EditPointOfSale::route('/{record}/edit'),
        ];
    }
}
