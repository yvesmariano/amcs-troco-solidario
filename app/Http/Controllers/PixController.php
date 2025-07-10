<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\PagarmeService;

class PixController extends Controller
{
    public function generateQrCode(Request $request, PagarmeService $pixService): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
        ]);

        $amount = (int) $validated['amount'];

        $receipt = Receipt::create([
            'point_of_sale_id' => 1,
            'total' => $amount,
        ]);
        $data = $pixService->generateQrCode($receipt->uuid, $amount);

        $receipt->qr_code_content = $data['qr_code'];
        $receipt->external_id = $data['id'];
        $receipt->save();

        return response()->json($receipt, 201);
    }
}
