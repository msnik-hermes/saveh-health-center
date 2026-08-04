<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItRequestResource;
use App\Models\ItRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItRequestController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();

        $items = ItRequest::query()
            ->with('center')
            ->when($user->center_id, fn ($q) => $q->where('center_id', $user->center_id))
            ->latest('id')
            ->paginate((int) $request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data' => ItRequestResource::collection($items->items()),
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
            'service_type' => ['nullable', 'string', 'max:100'],
            'equipment_id' => ['nullable', 'integer', 'exists:center_equipment,id'],
            'problem_description' => ['required', 'string'],
            'error_messages' => ['nullable', 'string'],
            'priority' => ['nullable', 'string', 'in:low,medium,high,urgent'],
            'available_time' => ['nullable', 'string', 'max:100'],
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

        $item = ItRequest::query()->create([
            'center_id' => $centerId,
            'requested_by' => $requestedBy,
            'service_type' => $data['service_type'] ?? 'general',
            'equipment_id' => $data['equipment_id'] ?? null,
            'problem_description' => $data['problem_description'],
            'error_messages' => $data['error_messages'] ?? null,
            'priority' => $data['priority'] ?? 'medium',
            'available_time' => $data['available_time'] ?? null,
            'status' => 'ersal_shodeh',
            'notes' => $data['notes'] ?? null,
            'created_by' => $user->employee_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'درخواست IT ثبت شد',
            'data' => new ItRequestResource($item->load('center')),
        ], 201);
    }

    public function show(Request $request, ItRequest $itRequest): JsonResponse
    {
        $this->authorizeCenter($request->user(), $itRequest->center_id);

        return response()->json([
            'success' => true,
            'data' => new ItRequestResource($itRequest->load('center')),
        ]);
    }

    private function authorizeCenter(?User $user, mixed $centerId): void
    {
        if ($user?->center_id && (int) $user->center_id !== (int) $centerId) {
            abort(403, 'دسترسی به این مرکز مجاز نیست.');
        }
    }
}
