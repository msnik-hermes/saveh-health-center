<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\FacilityRequest */
class FacilityRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'request_number' => $this->request_number,
            'center_id' => $this->center_id,
            'requested_by' => $this->requested_by,
            'facility_type' => $this->facility_type,
            'location' => $this->location,
            'description' => $this->description,
            'priority' => $this->priority,
            'status' => $this->status,
            'preferred_time' => optional($this->preferred_time)?->toDateTimeString(),
            'completion_date' => optional($this->completion_date)?->toDateString(),
            'cost' => $this->cost,
            'notes' => $this->notes,
            'created_at' => optional($this->created_at)?->toDateTimeString(),
            'center' => $this->whenLoaded('center', fn () => [
                'id' => $this->center?->id,
                'name' => $this->center?->name,
            ]),
        ];
    }
}
