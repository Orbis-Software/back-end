<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\JobService;

class JobResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $jobService = app(JobService::class);

        $totalCosts = $jobService->totalCosts($this->resource);
        $totalRevenue = $jobService->totalRevenue($this->resource);
        $totalAdjustments = $jobService->totalAdjustments($this->resource);
        $grossProfit = $jobService->grossProfitWithAdjustments($this->resource);

        return [
            'id' => $this->id,
            'job_reference' => $this->job_reference,

            'client' => [
                'id' => $this->client->id,
                'name' => $this->client->name,
            ],

            'transport_mode' => $this->transport_mode,
            'origin' => optional($this->transports->first())->origin,
            'destination' => optional($this->transports->first())->destination,

            'status' => $this->status,
            'created_at' => $this->created_at?->toISOString(),
            'completed_at' => $this->completed_at?->toISOString(),

            'financials' => [
                'total_costs' => $totalCosts,
                'total_revenue' => $totalRevenue,
                'total_adjustments' => $totalAdjustments,
                'gross_profit' => $grossProfit,
            ],

            'costs' => $this->costLines,
            'revenue' => $this->revenueLines,
            'adjustments' => $this->adjustmentLines,
        ];
    }
}
