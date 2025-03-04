<?php

namespace App\Http\Controllers;

use App\Enums\PaymentSource;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Http\Requests\AccountRequest;
use App\Http\Resources\AccountResource;
use App\Http\Resources\PaymentResource;
use App\Models\Account;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AccountController
{
    public function list()
    {
        $accounts = Account::whereNull('deleted_at')->get();
        return AccountResource::collection($accounts);
    }

    public function store(AccountRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        Account::create($validatedData);

        return response()->json([
            'message' => 'Account created successfully.',
        ], 201);
    }

    public function show($id)
    {
        $account = Account::with('user')->findOrFail($id);

        return new AccountResource($account);
    }

    public function history(Account $account): JsonResponse
    {
        $payments = Payment::where('account_id', $account->id)->get();
        return response()->json([
            'status' => ResponseAlias::HTTP_OK,
            'data' => PaymentResource::collection($payments),
        ]);
    }

}
