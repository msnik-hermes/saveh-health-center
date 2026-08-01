<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserPermissionController extends Controller
{
    public function index(): JsonResponse
    {
        $permissions = UserPermission::with(['user', 'permission'])->get();
        return response()->json(['data' => $permissions]);
    }

    public function show(UserPermission $userPermission): JsonResponse
    {
        return response()->json(['data' => $userPermission->load(['user', 'permission'])]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
            'is_granted' => 'required|boolean',
            'granted_by' => 'required|exists:users,id',
            'expires_at' => 'nullable|date|after:today',
            'reason' => 'nullable|string|max:500',
        ]);

        $permission = UserPermission::create($data);

        return response()->json(['data' => $permission->load(['user', 'permission'])], 201);
    }

    public function update(Request $request, UserPermission $userPermission): JsonResponse
    {
        $data = $request->validate([
            'is_granted' => 'sometimes|boolean',
            'expires_at' => 'nullable|date|after:today',
            'reason' => 'nullable|string|max:500',
        ]);

        $userPermission->update($data);

        return response()->json(['data' => $userPermission->load(['user', 'permission'])]);
    }

    public function destroy(UserPermission $userPermission): JsonResponse
    {
        $userPermission->delete();

        return response()->json(['message' => 'User permission deleted successfully']);
    }
}
