<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        $companies = Company::all();
        return response()->json(['data' => $companies]);
    }

    public function show(Company $company): JsonResponse
    {
        return response()->json(['data' => $company]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|unique:companies,registration_number',
            'national_id' => 'nullable|string|unique:companies,national_id',
            'status' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $company = Company::create($data);

        return response()->json(['data' => $company], 201);
    }

    public function update(Request $request, Company $company): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|nullable|string|max:50',
        ]);

        $company->update($data);

        return response()->json(['data' => $company]);
    }

    public function destroy(Company $company): JsonResponse
    {
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
