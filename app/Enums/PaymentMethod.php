<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentMethod: string implements HasLabel
{
    case CREDIT_CARD = 'credit_card';
    case DEBIT_CARD = 'debit_card';
    case PIX = 'pix';
    case CASH = 'cash';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CREDIT_CARD => 'Cartão de crédito',
            self::DEBIT_CARD => 'Cartão de débito',
            self::PIX => 'PIX',
            self::CASH => 'Dinheiro',
        };
    }
}
