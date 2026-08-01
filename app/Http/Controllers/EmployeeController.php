<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EmployeeController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Employee::with(['center']);

        if ($request->has('center_id')) {
            $query->where('center_id', $request->center_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('department')) {
            $query->where('department', $request->department);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('personnel_code', 'like', "%{$search}%")
                  ->orWhere('national_code', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate($request->get('per_page', 15));

        return response()->json($employees);
    }

    public function show(Employee $employee): JsonResponse
    {
        return response()->json(['data' => $employee->load(['center', 'supervisor'])]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'personnel_code' => 'required|string|max:20|unique:employees,personnel_code',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'national_code' => 'required|string|max:10|unique:employees,national_code',
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:mard,zan',
            'marital_status' => 'required|string',
            'job_title' => 'required|string|max:200',
            'position' => 'required|string|max:100',
            'employment_type' => 'required|string',
            'employment_date' => 'required|date',
            'center_id' => 'required|exists:centers,id',
            'department' => 'required|string|max:100',
            'service_type' => 'required|string',
            'status' => 'required|string',
            'education_degree' => 'required|string|max:50',
            'mobile' => 'required|string|max:15',
        ]);

        $employee = Employee::create($data);

        return response()->json(['data' => $employee], 201);
    }

    public function update(Request $request, Employee $employee): JsonResponse
    {
        $data = $request->validate([
            'first_name' => 'sometimes|required|string|max:50',
            'last_name' => 'sometimes|required|string|max:50',
            'job_title' => 'sometimes|required|string|max:200',
            'position' => 'sometimes|required|string|max:100',
            'status' => 'sometimes|string',
            'mobile' => 'sometimes|required|string|max:15',
            'department' => 'sometimes|required|string|max:100',
        ]);

        $employee->update($data);

        return response()->json(['data' => $employee->fresh()->load(['center'])]);
    }

    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
