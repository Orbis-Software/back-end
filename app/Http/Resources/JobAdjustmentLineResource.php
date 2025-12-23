<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobAdjustmentLineResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'job_id' => $this->job_id,
            'type' => $this->type,
            'description' => $this->description,
            'amount_delta' => $this->amount_delta,
            'currency' => $this->currency,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}
