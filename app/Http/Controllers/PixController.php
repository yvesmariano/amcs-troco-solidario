<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PixService;

class PixController extends Controller
{
    public function generateQrCode(Request $request, PixService $pixService): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'expires_in' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $amount = (int) $validated['amount'];
        $expiresIn = $validated['expires_in'] ?? 3600;
        $description = $validated['description'] ?? 'Pagamento via Pix';

        $pixData = $pixService->generateQrCode($amount, $expiresIn, $description);

        return response()->json($pixData);
    }
}
