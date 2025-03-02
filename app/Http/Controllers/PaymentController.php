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

    public function list()
    {
//        $payments = Payment::whereNull('deleted_at')->get();
        $payments = Payment::all();
        return PaymentResource::collection($payments);
    }

    public function store(PaymentRequest $request)
    {
        $validatedData = $request->validated();
        return $this->atmService->insertPayment($validatedData);
    }

    public function withdraw(WithdrawRequest $request)
    {
        $validatedData = $request->validated();
        return $this->atmService->withdraw($validatedData['account_id'], $validatedData['amount']);
    }
}
