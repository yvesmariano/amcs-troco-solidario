<?php

namespace App\Filament\Operator\Resources\DonationResource\Pages;

use App\Models\Receipt;
use App\Filament\Operator\Resources\DonationResource;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;

class CreateDonation extends CreateRecord
{
    protected static string $resource = DonationResource::class;

    protected bool $shouldIssueReceipt = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $operator = Auth::user()->operator;
        $data['point_of_sale_id'] = $data['point_of_sale_id'] ?? $operator->point_of_sale_id;
        $data['operator_id'] = $data['operator_id'] ?? $operator->point_of_sale_id;

        $this->shouldIssueReceipt = $data['pay_now'];
        unset($data['pay_now']);
        return $data;
    }

    public function afterCreate(): void
    {
        if (!$this->shouldIssueReceipt) {
            return;
        }

        $receipt = Receipt::create([
            'total' => $this->record->amount,
            'point_of_sale_id' => $this->record->point_of_sale_id,
            'operator_id' => $this->record->operator_id,
        ]);

        $receipt->donations()->attach($this->record->id);
    }
}
