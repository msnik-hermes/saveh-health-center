<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return response()->json(['companies' => $companies]);
    }

    public function show(Company $company)
    {
        return response()->json(['company' => $company]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $company = Company::create($data);

        return response()->json(['company' => $company], 201);
    }

    public function update(Request $request, Company $company)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $company->update($data);

        return response()->json(['company' => $company]);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }
}
