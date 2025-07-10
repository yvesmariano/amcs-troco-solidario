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
     * Gera um QR Code Pix
     *
     * @param int $amount
     * @param int $expiresIn
     * @param string $description
     * @return array
     */
    public function generateQrCode(string $code, int $amount, int $expiresIn = 3600, string $description = 'Pagamento via Pix'): array
    {
        $request = $this->client->post('/orders', [
            "items" => [[
                "amount" => $amount,
                "description" => $description,
                "code" => $code,
                "quantity" => 1
            ]],
            'customer' => [
                'name' => 'Yves Cabral Mariano',
                'email' => 'yvescmariano@gmail.com',
                'type' => 'individual',
                'document' => '11398842478',
                'phones' => [
                    'home_phone' => [
                    'country_code' => '55',
                    'number' => '999777762',
                    'area_code' => '84',
                ],
            ],
            'payments' => [[
                'payment_method' => 'pix',
                'pix' => [
                    'expires_in' => now()->addSeconds($expiresIn)->toIso8601String(),
                ],
            ]],
            ]
        ]);

        if ($request->failed()) {
            throw new \Exception('Erro ao gerar QR Code Pix: ' . $request->body());
        }

        $transaction = $request->json();
        $charge = $transaction['charges'][0] ?? null;
        $lastTransaction = $charge['last_transaction'] ?? null;

        return [
            'id' => $transaction['id'] ?? null,
            'code' => $transaction['code'] ?? null,
            'amount' => $transaction['amount'] ?? null,
            'status' => $transaction['status'] ?? null,
            'qr_code' => $lastTransaction['qr_code'] ?? null,
            'qr_code_url' => $lastTransaction['qr_code_url'] ?? null,
            'expires_at' => $lastTransaction['expires_at'] ?? null,
        ];
    }
}
