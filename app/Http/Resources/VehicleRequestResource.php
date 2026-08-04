<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\VehicleRequest */
class VehicleRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'request_number' => $this->request_number,
            'center_id' => $this->center_id,
            'requested_by' => $this->requested_by,
            'vehicle_id' => $this->vehicle_id,
            'driver_id' => $this->driver_id,
            'trip_purpose' => $this->trip_purpose,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'departure_datetime' => optional($this->departure_datetime)?->toDateTimeString(),
            'expected_return' => optional($this->expected_return)?->toDateTimeString(),
            'passenger_count' => $this->passenger_count,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_at' => optional($this->created_at)?->toDateTimeString(),
            'center' => $this->whenLoaded('center', fn () => [
                'id' => $this->center?->id,
                'name' => $this->center?->name,
            ]),
        ];
    }
}
