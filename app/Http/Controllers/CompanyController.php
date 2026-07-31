<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    public function index(): Response
    {
        $companies = Company::all();
        return response()->json(['companies' => $companies]);
    }

    public function show(Company $company): Response
    {
        return response()->json(['company' => $company]);
    }

    public function store(Request $request): Response
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:faal,ghair_faal,tahrim',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $company = Company::create($data);

        return response()->json(['company' => $company], 201);
    }

    public function update(Request $request, Company $company): Response
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $company->update($data);

        return response()->json(['company' => $company]);
    }

    public function destroy(Company $company): Response
    {
        Gate::authorize('delete', $company);
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
}
