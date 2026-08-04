<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\ItRequest */
class ItRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'center_id' => $this->center_id,
            'requested_by' => $this->requested_by,
            'service_type' => $this->service_type,
            'equipment_id' => $this->equipment_id,
            'problem_description' => $this->problem_description,
            'error_messages' => $this->error_messages,
            'priority' => $this->priority,
            'status' => $this->status,
            'available_time' => $this->available_time,
            'resolution_notes' => $this->resolution_notes,
            'completion_date' => optional($this->completion_date)?->toDateString(),
            'notes' => $this->notes,
            'created_at' => optional($this->created_at)?->toDateTimeString(),
            'center' => $this->whenLoaded('center', fn () => [
                'id' => $this->center?->id,
                'name' => $this->center?->name,
            ]),
        ];
    }
}
