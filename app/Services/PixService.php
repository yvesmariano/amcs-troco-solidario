<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PagarmeService
{
    protected $client;

    public function __construct()
    {
        $this->client = Http::withBasicAuth(
            config('services.pagarme.api_key'),
            ''
        )->baseUrl(config('services.pagarme.base_url'));
    }

    /**
     * Gera um QR Code Pix usando o SDK do Pagar.me
     *
     * @param int $amount
     * @param int $expiresIn
     * @param string $description
     * @return array
     */
    public function generateQrCode(int $amount, int $expiresIn = 3600, string $description = 'Pagamento via Pix'): array
    {
        $transaction = $this->client->transactions()->create([
            'amount' => $amount,
            'payment_method' => 'pix',
            'pix_expiration_date' => now()->addSeconds($expiresIn)->toIso8601String(),
            'postback_url' => null,
            'metadata' => [
                'description' => $description,
            ],
        ]);

        return [
            'qr_code' => $transaction->getPixQrCode(),
            'qr_code_url' => $transaction->getPixQrCodeUrl(),
            'expires_at' => $transaction->getPixExpirationDate(),
        ];
    }
}
