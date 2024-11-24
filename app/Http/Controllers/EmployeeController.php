<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Events\EmployeeAdded;

use App\Models\EmployeeModel;
use App\Models\CompanyModel;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = EmployeeModel::all();

        $companies = CompanyModel::all();

        if (!empty($request->get('name'))) {
            $name = $request->get('name');
        } else {
            $name = '';
        }
        
        return Inertia::render('Employees/Index', [
            'employees' => $employees,
            'companies' => $companies->toArray(),
            'name'      => $name,
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

        // Emit event notifikasi
        broadcast(new EmployeeAdded('Employee added successfully!'));

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

        event(new EmployeeAdded(['message' => 'Employee updated successfully!']));
        // Emit event notifikasi
        broadcast(new EmployeeAdded('Employee updated successfully!'));

        

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