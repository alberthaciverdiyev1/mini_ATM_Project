<?php

namespace App\Http\Resources;

use App\Enums\PaymentSource;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Filament\Resources\AccountResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'account' => new AccountResource($this->whenLoaded('account_id')),
            'amount' => $this->amount,
            'type' => $this->type->name,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
