<?php

namespace App\Http\Controllers;

use App\Enums\PaymentSource;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Http\Resources\PaymentResource;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function list()
    {
//        $payments = Payment::whereNull('deleted_at')->get();
        $payments = Payment::all();
        return PaymentResource::collection($payments);
    }

    public function store()
    {
        Payment::create([
            'account_id' => 1,
            'amount' => 250.75,
            'type' => PaymentType::IN,
            'source' => PaymentSource::ATM,
            'status' => PaymentStatus::ACTIVE
        ]);

    }
}
