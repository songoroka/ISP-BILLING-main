<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CustomersInfo;
use App\Models\PaymentTransaction;
use App\Services\Payments\TanzaniaPaymentService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    public function initiate(Request $request, TanzaniaPaymentService $payments)
    {
        $data = $request->validate([
            'customer_unique_id' => ['required', 'string', 'max:120'],
            'amount' => ['required', 'numeric', 'min:1', 'max:100000000'],
            'provider' => ['required', Rule::in(['selcom', 'mpesa_tz', 'beem_bpay', 'azampesa'])],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $customer = CustomersInfo::where('customer_unique_id', $data['customer_unique_id'])->firstOrFail();
        $transaction = $payments->initiate($customer, (float) $data['amount'], $data['provider'], $data['phone'] ?? null);

        return response()->json([
            'success' => true,
            'data' => $transaction,
        ], 201);
    }

    public function show(string $merchantReference)
    {
        $transaction = PaymentTransaction::where('merchant_reference', $merchantReference)->firstOrFail();

        return response()->json(['success' => true, 'data' => $transaction]);
    }

    public function check(string $merchantReference, TanzaniaPaymentService $payments)
    {
        $transaction = PaymentTransaction::where('merchant_reference', $merchantReference)->firstOrFail();
        $transaction = $payments->query($transaction);

        return response()->json(['success' => true, 'data' => $transaction]);
    }
}
