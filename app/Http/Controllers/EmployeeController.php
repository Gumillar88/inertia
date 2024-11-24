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
        $employees = EmployeeModel::all();

        $employeeAttributes = $employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'last_name' => $employee->last_name,
                'company_id' => $employee->company_id,
                'email' => $employee->email,
                'phone' => $employee->phone,
                'created_at' => $employee->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $employee->updated_at->format('Y-m-d H:i:s'),
            ];
        });
        
        return Inertia::render('Employees/Index', [
            'employees' => $employees,
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

    public function edit(Request $request, $id)
    {
        $employeeModel = new EmployeeModel();
        $employee = $employeeModel->findEmployeeById($id); 
        
        $companies = CompanyModel::all();

        // Jika employee tidak ditemukan, kembalikan halaman dengan pesan error
        if (!$employee) {
            return redirect('/employees')->with('error', 'Employee not found');
        }

        return Inertia::render('Employees/Edit', [
            'employee' => $employee ? $employee : null,
            'companies' => $companies->toArray(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ]);

        $employeeModel = new EmployeeModel();
        $employee = $employeeModel->findEmployeeById($id);
        $employee = $employeeModel->updateEmployee($employee, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Employee updated successfully!',
            'data' => $employee,
        ]);
    }

    public function destroy($id)
    {
        try {
            $employeeModel = new EmployeeModel();
            $employee = $employeeModel->find($id);

            if (!$employee) {
                return response()->json(['message' => 'Employee not found'], 404);
            }

            $employee->deleteEmployee($employee);

            return response()->json(['message' => 'Employee deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while deleting Employee'], 500);
        }
    }
}