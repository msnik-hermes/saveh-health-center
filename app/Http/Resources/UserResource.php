<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_active' => (bool) $this->is_active,
            'center_id' => $this->center_id,
            'employee_id' => $this->employee_id,
            'center' => $this->whenLoaded('center', fn () => [
                'id' => $this->center?->id,
                'name' => $this->center?->name,
                'code' => $this->center?->code,
            ]),
            'employee' => $this->whenLoaded('employee', fn () => [
                'id' => $this->employee?->id,
                'first_name' => $this->employee?->first_name,
                'last_name' => $this->employee?->last_name,
                'personnel_code' => $this->employee?->personnel_code,
            ]),
        ];
    }
}
