<?php

namespace App\Http\Controllers;

use App\Enums\PaymentSource;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Http\Requests\PaymentRequest;
use App\Http\Requests\WithdrawRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Services\ATMService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rules\Enum;

class PaymentController
{
    private ATMService $atmService;

    /**
     * @param ATMService $atmService
     */
    public function __construct(ATMService $atmService)
    {
        $this->atmService = $atmService;
    }

    public function store(PaymentRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        return $this->atmService->insertPayment($validatedData);
    }

    public function withdraw(WithdrawRequest $request)
    {
        $validatedData = $request->validated();
        return $this->atmService->withdraw($validatedData['account_id'], $validatedData['amount']);
    }

    public function destroy(Payment $payment): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['message' => __('Only admins can perform this operation.')], 403);
        }

        $payment->delete();

        return response()->json(
            ['message' => __('Payment successfully removed.')],200);
    }

}
