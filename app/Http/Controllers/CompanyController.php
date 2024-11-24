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
        $companies = CompanyModel::all(); // Mengambil semua perusahaan
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
        $company = $companyModel->createCompany($validated); // Menyimpan perusahaan

        return response()->json([
            'success' => true,
            'message' => 'Company saved successfully!',
            'data' => $company,
        ]);
    }

    public function edit($id)
    {
        $companyModel = new CompanyModel();
        $company = $companyModel->findCompanyById($id); // Mencari perusahaan berdasarkan ID
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
        $company = $companyModel->findCompanyById($id); // Mencari perusahaan berdasarkan ID
        $company = $companyModel->updateCompany($company, $validated); // Memperbarui perusahaan

        return redirect()->route('companies.index');
    }

    public function destroy($id)
    {
        $companyModel = new CompanyModel();
        $company = $companyModel->findCompanyById($id); // Mencari perusahaan berdasarkan ID
        $companyModel->deleteCompany($company); // Menghapus perusahaan

        return redirect()->route('companies.index');
    }
}