<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ReceiptResource\Pages;
use App\Filament\Admin\Resources\ReceiptResource\RelationManagers;
use App\Models\Receipt;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class ReceiptResource extends Resource
{
    protected static ?string $model = Receipt::class;

    protected static ?string $label = 'Recibo';

    protected static ?string $pluralLabel = 'Recibos';

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    
    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Tables\Columns\TextColumn::make('uuid')
                //     ->label('ID')
                //     ->searchable()
                //     ->sortable(),
                Tables\Columns\TextColumn::make('pointOfSale.name')
                    ->label('Ponto de Doação'),
                MoneyColumn::make('total')
                    ->label('Valor Total'),
                Tables\Columns\TextColumn::make('created_at')
                   ->label('Data da Solicitação')
                   ->dateTime('d/m/Y H:i:s'),
                Tables\Columns\TextColumn::make('paid_at')
                   ->label('Data do Pagamento')
                   ->placeholder('Não Pago')
                   ->dateTime('d/m/Y H:i:s'),
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
            'index' => Pages\ListReceipts::route('/'),
            'view' => Pages\ViewReceipt::route('/{record}'),
            'edit' => Pages\EditReceipt::route('/{record}/edit'),
        ];
    }
}
