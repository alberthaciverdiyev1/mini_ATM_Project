<?php

namespace App\Http\Controllers;

use App\Enums\PaymentSource;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use Illuminate\Validation\Rules\Enum;

class PaymentController extends Controller
{
    public function list()
    {
//        $payments = Payment::whereNull('deleted_at')->get();
        $payments = Payment::all();
        return PaymentResource::collection($payments);
    }

    public function store(PaymentRequest $request)
    {
        $validatedData = $request->validated();
        $accountId = $request->input('account_id');
        $amount = $validatedData['amount'];
        $type = $validatedData['type'];

        if ($type === PaymentType::OUT) {
            $totals = Payment::where('account_id', $accountId)
                ->whereIn('type', [PaymentType::IN, PaymentType::OUT])
                ->selectRaw('sum(case when type = ? then amount else 0 end) as total_in', [PaymentType::IN])
                ->selectRaw('sum(case when type = ? then amount else 0 end) as total_out', [PaymentType::OUT])
                ->first();

            $in = $totals->total_in ?? 0;
            $out = $totals->total_out ?? 0;

            if (($in - $out) - $amount < 0) {
                return response()->json([
                    'message' => 'Insufficient balance for the transaction.',
                ], 400);
            }
        }

        Payment::create($validatedData);

        return response()->json([
            'message' => 'Payment created successfully.',
        ], 201);
    }

}
