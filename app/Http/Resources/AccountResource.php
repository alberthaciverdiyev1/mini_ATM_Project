<?php

namespace App\Http\Resources;

use App\Enums\PaymentType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class  AccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "account_id" => $this->account_id,
            'user' => new UserResource($this->whenLoaded('user')),
            "date" => $this->created_at->toDateString(),

        ];
    }

}
