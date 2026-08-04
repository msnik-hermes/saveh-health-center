<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityRequestResource;
use App\Models\FacilityRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FacilityRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $items = FacilityRequest::query()
            ->with('center')
            ->when($user->center_id, fn ($q) => $q->where('center_id', $user->center_id))
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => FacilityRequestResource::collection($items->items()),
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
            'facility_type' => ['nullable', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'priority' => ['nullable', 'string', 'in:low,medium,high,urgent'],
            'preferred_time' => ['nullable', 'date'],
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

        $item = FacilityRequest::query()->create([
            'request_number' => 'FAC-'.now()->format('ymd').'-'.Str::upper(Str::random(4)),
            'center_id' => $centerId,
            'requested_by' => $requestedBy,
            'facility_type' => $data['facility_type'] ?? 'general',
            'location' => $data['location'],
            'description' => $data['description'],
            'priority' => $data['priority'] ?? 'medium',
            'preferred_time' => $data['preferred_time'] ?? null,
            'status' => 'ersal_shodeh',
            'notes' => $data['notes'] ?? null,
            'created_by' => $user->employee_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'درخواست تاسیسات ثبت شد',
            'data' => new FacilityRequestResource($item->load('center')),
        ], 201);
    }

    public function show(Request $request, FacilityRequest $facilityRequest): JsonResponse
    {
        $this->authorizeCenter($request->user(), $facilityRequest->center_id);

        return response()->json([
            'success' => true,
            'data' => new FacilityRequestResource($facilityRequest->load('center')),
        ]);
    }

    private function authorizeCenter(?User $user, mixed $centerId): void
    {
        if ($user?->center_id && (int) $user->center_id !== (int) $centerId) {
            abort(403, 'دسترسی به این مرکز مجاز نیست.');
        }
    }
}
