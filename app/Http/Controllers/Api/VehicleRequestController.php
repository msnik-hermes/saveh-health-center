<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleRequestResource;
use App\Models\User;
use App\Models\VehicleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VehicleRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $items = VehicleRequest::query()
            ->with('center')
            ->when($user->center_id, fn ($q) => $q->where('center_id', $user->center_id))
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => VehicleRequestResource::collection($items->items()),
            'meta' => [
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'per_page' => $items->perPage(),
                'total' => $items->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $data = $request->validate([
            'center_id' => ['nullable', 'integer', 'exists:centers,id'],
            'requested_by' => ['nullable', 'integer', 'exists:employees,id'],
            'vehicle_id' => ['nullable', 'integer', 'exists:vehicles,id'],
            'driver_id' => ['nullable', 'integer', 'exists:drivers,id'],
            'trip_purpose' => ['required', 'string'],
            'origin' => ['required', 'string', 'max:255'],
            'destination' => ['required', 'string', 'max:255'],
            'departure_datetime' => ['required', 'date'],
            'expected_return' => ['nullable', 'date', 'after:departure_datetime'],
            'passenger_count' => ['nullable', 'integer', 'min:1', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $centerId = $data['center_id'] ?? $user->center_id;
        $requestedBy = $data['requested_by'] ?? $user->employee_id;

        if (! $centerId || ! $requestedBy) {
            return response()->json([
                'success' => false,
                'message' => 'center_id و requested_by الزامی هستند (یا باید روی کاربر تنظیم شده باشند).',
            ], 422);
        }

        $item = VehicleRequest::query()->create([
            'request_number' => 'VEH-'.now()->format('ymd').'-'.Str::upper(Str::random(4)),
            'center_id' => $centerId,
            'requested_by' => $requestedBy,
            'vehicle_id' => $data['vehicle_id'] ?? null,
            'driver_id' => $data['driver_id'] ?? null,
            'trip_purpose' => $data['trip_purpose'],
            'origin' => $data['origin'],
            'destination' => $data['destination'],
            'departure_datetime' => $data['departure_datetime'],
            'expected_return' => $data['expected_return'] ?? null,
            'passenger_count' => $data['passenger_count'] ?? 1,
            'status' => 'ersal_shodeh',
            'notes' => $data['notes'] ?? null,
            'created_by' => $user->employee_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'درخواست خودرو ثبت شد',
            'data' => new VehicleRequestResource($item->load('center')),
        ], 201);
    }

    public function show(Request $request, VehicleRequest $vehicleRequest): JsonResponse
    {
        $this->authorizeCenter($request->user(), $vehicleRequest->center_id);

        return response()->json([
            'success' => true,
            'data' => new VehicleRequestResource($vehicleRequest->load('center')),
        ]);
    }

    private function authorizeCenter(?User $user, mixed $centerId): void
    {
        if ($user?->center_id && (int) $user->center_id !== (int) $centerId) {
            abort(403, 'دسترسی به این مرکز مجاز نیست.');
        }
    }
}
