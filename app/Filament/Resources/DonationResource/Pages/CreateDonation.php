<?php

namespace App\Filament\Resources\DonationResource\Pages;

use App\Filament\Resources\DonationResource;
use App\Models\Receipt;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDonation extends CreateRecord
{
    protected static string $resource = DonationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if ($data['pay_now']) {
            Receipt::create([
                'total' => $data['amount'],
                'point_of_sale_id' => $data['point_of_sale_id'] ?? null,
                'operator_id' => $data['operator_id'] ?? null,
            ]);
        }

        unset($data['pay_now']);
        return $data;
    }
}
