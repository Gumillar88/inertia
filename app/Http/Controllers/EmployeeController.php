<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\EmployeeModel;
use App\Models\CompanyModel;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = EmployeeModel::with('company')->paginate(10);
        return Inertia::render('Employees/Index', [
            'employees' => $employees->items(),
            'pagination' => [
                'current_page' => $employees->currentPage(),
                'per_page' => $employees->perPage(),
                'total' => $employees->total(),
            ],
        ]);
    }

    public function create()
    {
        $companies = CompanyModel::all();
        return Inertia::render('Employees/Create', [
            'companies' => $companies
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ]);

        $employee = EmployeeModel::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Employee saved successfully!',
            'data' => $employee,
        ]);
    }

    public function edit(EmployeeModel $employee)
    {
        $companies = CompanyModel::all();
        return Inertia::render('Employees/Edit', [
            'employee' => $employee,
            'companies' => $companies
        ]);
    }

    public function update(Request $request, EmployeeModel $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index');
    }

    public function destroy(EmployeeModel $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index');
    }
}