<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

use App\Models\EmployeeModel;
use App\Models\CompanyModel;

class CompanyController extends Controller
{
    public function index()
    {
        $companyModel = new CompanyModel();
        $companies = CompanyModel::all(); 
        return Inertia::render('Companies/Index', [
            'companies' => $companies
        ]);
    }

    public function create()
    {
        return Inertia::render('Companies/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'logo' => 'nullable|image',
            'website' => 'nullable|url',
        ]);

        $companyModel = new CompanyModel();
        $company = $companyModel->createCompany($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company saved successfully!',
            'data' => $company,
        ]);
    }

    public function edit($id)
    {
        $companyModel = new CompanyModel();
        $company = $companyModel->findCompanyById($id); 
        return Inertia::render('Companies/Edit', [
            'company' => $company
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'logo' => 'nullable|image',
            'website' => 'nullable|url',
        ]);

        $companyModel = new CompanyModel();
        $company = $companyModel->findCompanyById($id);
        $company = $companyModel->updateCompany($company, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Company updated successfully!',
            'data' => $company,
        ]);

    }

    public function destroy($id)
    {
        try {
            $companyModel = new CompanyModel();
            $company = $companyModel->find($id);

            if (!$company) {
                return response()->json(['message' => 'Company not found'], 404);
            }

            $company->deleteCompany($company);

            return response()->json(['message' => 'Company deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while deleting company'], 500);
        }
    }
}