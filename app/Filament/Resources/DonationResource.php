<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Filament\Resources\DonationResource\RelationManagers;
use App\Models\Donation;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Infolists\Components\MoneyEntry;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $label = 'Doação';

    protected static ?string $pluralLabel = 'Doações';

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                MoneyInput::make('amount')
                    ->label('Valor')
                    ->required()
                    ->minValue(1)
                    ->decimals(2)
                    ->maxValue(10000)
                    ->placeholder('Digite o valor da doação'),
                Forms\Components\Select::make('payment_method')
                    ->label('Método de pagamento')
                    ->default('pix')
                    ->options([
                        'credit_card' => 'Cartão de crédito',
                        'debit_card' => 'Cartão de débito',
                        'pix' => 'PIX',
                        'cash' => 'Dinheiro',
                    ])
                    ->required(),
                Forms\Components\Select::make('point_of_sale_id')
                    ->label('Ponto de Doação')
                    ->relationship('pointOfSale', 'name')
                    ->required()
                    ->searchable()
                    ->placeholder('Selecione um ponto de doação'),
                Toggle::make('pay_now')
                    ->label('Pagar agora')
                    ->default(true)
                    ->helperText('Se desmarcado, a doação será registrada, mas não será processada imediatamente.'),
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['uuid'];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('uuid')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                MoneyColumn::make('amount')
                    ->label('Valor')
                    ->sortable()
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

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Dados do doador')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('customer.name')
                            ->label('Nome')
                            ->placeholder('Não informado'),
                        TextEntry::make('customer.document')
                            ->label('CPF')
                            ->placeholder('Não informado'),
                    ]),
                
                Section::make('Dados da doação')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('point_of_sale.name')
                            ->label('Ponto de Doação')
                            ->placeholder('Não informado'),
                        TextEntry::make('operator.name')
                            ->label('Operador')
                            ->placeholder('Não informado'),
                        TextEntry::make('uuid')
                            ->label('ID'),
                        TextEntry::make('status')
                            ->label('Status'),
                        MoneyEntry::make('amount')
                            ->label('Valor'),
                        TextEntry::make('payment_method')
                            ->label('Método de pagamento')
                            ->placeholder('Não informado'),
                        TextEntry::make('created_at')
                            ->label('Doado em')
                            ->placeholder('Não informado')
                            ->dateTime(),
                        TextEntry::make('received_at')
                            ->label('Recebido em')
                            ->placeholder('Não informado')
                            ->dateTime(),
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
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'view' => Pages\ViewDonation::route('/{record}'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }
}
