<?php

namespace App\Filament\Widgets;

use App\Enums\TransactionStatus;
use App\Models\Donation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DonationOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $query = Donation::query();
        $qtyDonations = $query->count();
        $totalDonations = $query->sum('amount');
        $totalDonationsFormatted = number_format($totalDonations / 100, 2, ',', '.');

        $averageDonation = $qtyDonations > 0 ? ($totalDonations / 100) / $qtyDonations : 0;
        $averageDonationFormatted = number_format($averageDonation, 2, ',', '.');

        $totalReceived = $query->clone()->where('status', TransactionStatus::APPROVED)->sum('amount');
        $totalReceivedFormatted = number_format($totalReceived / 100, 2, ',', '.');

        $totalPending = $query->clone()->where('status', TransactionStatus::PENDING)->sum('amount');
        $totalPendingFormatted = number_format($totalPending / 100, 2, ',', '.');

        return [
            Stat::make('Quantidade de Doações', $qtyDonations),
            Stat::make('Total de Doações Realizadas', 'R$ ' . $totalDonationsFormatted),
            Stat::make('Média por Doação', 'R$ ' . $averageDonationFormatted),
            Stat::make('Total de Doações Processadas', 'R$ ' . $totalReceivedFormatted),
            Stat::make('Total de Doações a Receber', 'R$ ' . $totalPendingFormatted),
        ];
    }
}
