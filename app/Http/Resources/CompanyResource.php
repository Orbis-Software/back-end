<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        $logoPath = $this->logo;

        return [
            'id'                  => $this->id,

            // Identity
            'legal_name'          => $this->legal_name,
            'trading_name'        => $this->trading_name,
            'registration_number' => $this->registration_number,

            // Addresses
            'registered_address'  => $this->registered_address,
            'operational_address' => $this->operational_address,

            // Preferences
            'default_currency'    => $this->default_currency,
            'language'            => $this->language,        // can be null depending on DB
            'time_zone'           => $this->time_zone,

            'logo'                => $logoPath,

            // Branding
            'logo_url'            => $logoPath ? asset('storage/' . ltrim($logoPath, '/')) : null,

            // Status
            'status'              => $this->status,

            // Timestamps (match your UserResource format)
            'created_at'          => $this->created_at?->toISOString(),
            'updated_at'          => $this->updated_at?->toISOString(),
        ];
    }
}
