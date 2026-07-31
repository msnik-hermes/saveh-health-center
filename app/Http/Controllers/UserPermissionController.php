<?php

namespace App\Http\Controllers;

use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class UserPermissionController extends Controller
{
    public function index(): Response
    {
        $permissions = UserPermission::with(['user', 'permission'])->get();
        return response()->json(['user_permissions' => $permissions]);
    }

    public function show(UserPermission $permission): Response
    {
        return response()->json(['user_permission' => $permission]);
    }

    public function store(Request $request): Response
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission_id' => 'required|exists:permissions,id',
            'is_granted' => 'required|boolean',
        ]);

        $permission = UserPermission::create($data);

        return response()->json(['user_permission' => $permission], 201);
    }

    public function update(Request $request, UserPermission $permission): Response
    {
        $data = $request->validate([
            'is_granted' => 'sometimes|required|boolean',
        ]);

        $permission->update($data);

        return response()->json(['user_permission' => $permission]);
    }

    public function destroy(UserPermission $permission): Response
    {
        Gate::authorize('delete', $permission);
        $permission->delete();

        return response()->json(['message' => 'User permission deleted successfully']);
    }
}
