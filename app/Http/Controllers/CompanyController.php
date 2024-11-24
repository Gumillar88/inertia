<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

use App\Models\EmployeeModel;
use App\Models\CompanyModel;

class CompanyController extends Controller
{
    // Menampilkan semua data company
    public function index()
    {
        $companies = CompanyModel::all();
        return Inertia::render('Companies/Index', [
            'companies' => $companies
        ]);
    }

    // Menampilkan form untuk create company
    public function create()
    {
        return Inertia::render('Companies/Create');
    }

    // Menyimpan data company
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'logo' => 'nullable|image',
            'website' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company = CompanyModel::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Company saved successfully!',
            'data' => $company,
        ]);
    }

    // Menampilkan form untuk edit company
    public function edit(CompanyModel $company)
    {
        return Inertia::render('Companies/Edit', [
            'company' => $company
        ]);
    }

    // Mengupdate data company
    public function update(Request $request, CompanyModel $company)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'logo' => 'nullable|image',
            'website' => 'nullable|url',
        ]);

        if ($request->hasFile('logo')) {
            // Jika ada logo baru, hapus yang lama dan simpan yang baru
            if ($company->logo) {
                Storage::delete('public/' . $company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $company->update($validated);

        return redirect()->route('companies.index');
    }

    // Menghapus data company
    public function destroy(CompanyModel $company)
    {
        // Hapus logo jika ada
        if ($company->logo) {
            Storage::delete('public/' . $company->logo);
        }

        $company->delete();
        return redirect()->route('companies.index');
    }
}