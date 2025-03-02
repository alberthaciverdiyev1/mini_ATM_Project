<?php

namespace App\Services;

use App\Enums\Banknotes;
use App\Enums\PaymentSource;
use App\Enums\PaymentType;
use App\Http\Requests\PaymentRequest;
use App\Models\Account;
use App\Models\Payment;
use App\Traits\Balance;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ATMService
{
    use Balance;

    public function withdraw($accountId, $amount): JsonResponse
    {
        $account = Account::findOrFail($accountId);
        $ATMBalance = self::ATMBalance();

        $total_atm_balance = $ATMBalance['total_balance'] ?? 0;

        if ($amount > $total_atm_balance) {
            return response()->json(['message' => __('There are not enough funds in the ATM.')], 400);
        }

        if ($account->accountBalance() < $amount) {
            return response()->json(['message' => __('There are not enough funds in your account.')], 400);
        }

        $dispensed_banknotes = [];

        foreach (collect(Banknotes::cases())->sortByDesc(fn($case) => $case->value) as $case) {
            $banknote_value = $case->value;
            $available_quantity = $ATMBalance[$banknote_value]['quantity'] ?? 0;
            $needed_quantity = intdiv($amount, $banknote_value);

            if ($needed_quantity > $available_quantity) {
                $needed_quantity = $available_quantity;
            }

            if ($needed_quantity > 0) {
                $dispensed_banknotes[$banknote_value] = $needed_quantity;
                $amount -= ($needed_quantity * $banknote_value);
            }

            if ($amount == 0) {
                break;
            }
        }

        if ($amount > 0) {
            return response()->json(['message' => __('The ATM does not have banknotes of the appropriate denomination.')], 400);
        }

        $data = array_map(fn($banknote_value, $quantity) => [
            'account_id' => $accountId,
            'amount' => $banknote_value,
            'is_atm' => PaymentSource::USER,
            'type' => PaymentType::OUT,
            'quantity' => $quantity,
            'created_at' => now() //timestamp zamani elave etmir
        ], array_keys($dispensed_banknotes), $dispensed_banknotes);

        self::insertPayment($data);

        return response()->json([
            'message' => 'Withdrawal completed successfully.',
            'dispensed_banknotes' => $dispensed_banknotes,
            'remaining_balance' => $account->accountBalance()
        ]);
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public static function insertPayment($data): JsonResponse
    {
        $data = collect($data)->flatMap(function ($payment) {
            return array_fill(0, $payment['quantity'], [
                'account_id' => $payment['account_id'],
                'amount' => $payment['amount'],
                'is_atm' => $payment['is_atm'],
                'type' => $payment['type'],
                'created_at' => now() //timestamp zamani elave etmir
            ]);
        })->toArray();

        Payment::insert($data);

        return response()->json([
            'message' => __('Payment created successfully.'),
        ], 201);
    }
}

