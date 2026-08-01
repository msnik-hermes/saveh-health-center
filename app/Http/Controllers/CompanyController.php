<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $perPage = $request->input('per_page', 15);
        $page = $request->input('page', 1);

        $companies = Company::paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $companies->items(),
            'meta' => [
                'current_page' => $companies->currentPage(),
                'last_page' => $companies->lastPage(),
                'per_page' => $companies->perPage(),
                'total' => $companies->total(),
            ]
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'registration_number' => 'required|string|max:100',
                'national_id' => 'required|string|max:20',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:100',
                'province' => 'nullable|string|max:100',
                'status' => 'required|string|in:active,inactive',
            ]);

            $company = Company::create($validated);

            return response()->json([
                'success' => true,
                'data' => $company,
                'message' => 'شرکت با موفقیت ایجاد شد'
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسی داده‌ها',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $company = Company::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $company
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Response
    {
        $company = Company::findOrFail($id);

        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'registration_number' => 'nullable|string|max:100|unique:companies,registration_number,'.$id.',',
                'national_id' => 'nullable|string|max:20|unique:companies,national_id,'.$id.',',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
                'city' => 'nullable|string|max:100',
                'province' => 'nullable|string|max:100',
                'status' => 'nullable|string|in:active,inactive',
            ]);

            $company->update($validated);

            return response()->json([
                'success' => true,
                'data' => $company->fresh(),
                'message' => 'شرکت با موفقیت به روز رسانی شد'
            ], 200);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در اعتبارسی داده‌ها',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        $company = Company::findOrFail($id);
        $company->delete();

        return response()->json([
            'success' => true,
            'message' => 'شرکت با موفقیت حذف شد'
        ], 200);
    }
}
