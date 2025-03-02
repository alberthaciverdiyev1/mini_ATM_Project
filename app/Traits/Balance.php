<?php

namespace App\Traits;

use App\Enums\Banknotes;
use App\Enums\PaymentType;
use App\Models\Payment;

trait Balance
{
    public function accountBalance(): int
    {
        $totals = Payment::where('account_id', $this->id)
            ->whereIn('type', [PaymentType::IN, PaymentType::OUT])
            ->where('is_atm', 0)
            ->selectRaw('sum(case when type = ? then amount else 0 end) as total_in', [PaymentType::IN])
            ->selectRaw('sum(case when type = ? then amount else 0 end) as total_out', [PaymentType::OUT])
            ->first();

        $in = $totals->total_in ?? 0;
        $out = $totals->total_out ?? 0;
        return $in - $out;
    }

    public function ATMBalance(): array
    {
        $data = [];
        $total_balance = 0;
        foreach (Banknotes::cases() as $banknote) {

            $totals = Payment::where('is_atm', 1)
                ->whereIn('type', [PaymentType::IN, PaymentType::OUT])
                ->where('amount', $banknote->value)
                ->selectRaw('
                sum(case when type = ? then amount else 0 end) as total_in,
                sum(case when type = ? then amount else 0 end) as total_out
            ', [PaymentType::IN, PaymentType::OUT])
                ->first();

            $in = $totals->total_in ?? 0;
            $out = $totals->total_out ?? 0;
            $balance = $in - $out;
            $total_balance += $balance;
            $data[$banknote->value] = [
                'balance' => $balance,
                'banknote' => $banknote->value,
                'quantity' => $balance > 0 ? (int)($balance / $banknote->value) : 0,
            ];
        }

        $data["total_balance"] = $total_balance;

        return $data;
    }

}
