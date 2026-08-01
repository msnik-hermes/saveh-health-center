<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CenterController extends Controller
{
    public function index(): JsonResponse
    {
        $centers = Center::all();
        return response()->json(['data' => $centers]);
    }

    public function show(Center $center): JsonResponse
    {
        return response()->json(['data' => $center]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:centers,code',
            'type' => 'required|in:hospital,clinic,pharmacy,lab',
            'university' => 'required|string|max:200',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        $center = Center::create($data);

        return response()->json(['data' => $center], 201);
    }

    public function update(Request $request, Center $center): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:active,inactive,suspended',
        ]);

        $center->update($data);

        return response()->json(['data' => $center]);
    }

    public function destroy(Center $center): JsonResponse
    {
        $center->delete();

        return response()->json(['message' => 'Center deleted successfully']);
    }
}
