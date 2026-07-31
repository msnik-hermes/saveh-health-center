<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class CenterController extends Controller
{
    public function index(): Response
    {
        $centers = Center::all();
        return response()->json(['centers' => $centers]);
    }

    public function show(Center $center): Response
    {
        return response()->json(['center' => $center]);
    }

    public function store(Request $request): Response
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:centers,code',
            'type' => 'required|in:hospital,clinic,pharmacy,lab',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'manager_id' => 'nullable|exists:users,id',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $center = Center::create($data);

        return response()->json(['center' => $center], 201);
    }

    public function update(Request $request, Center $center): Response
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:active,inactive,suspended',
        ]);

        $center->update($data);

        return response()->json(['center' => $center]);
    }

    public function destroy(Center $center): Response
    {
        Gate::authorize('delete', $center);
        $center->delete();

        return response()->json(['message' => 'Center deleted successfully']);
    }
}
