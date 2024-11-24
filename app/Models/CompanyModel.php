<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyModel extends Model
{
    use HasFactory;
    
    protected $table = 'companies';
    protected $fillable = ['name', 'email', 'logo', 'website'];

    public $timestamps = true;

    public function getAll()
    {
        return $this->all();
    }

    public function createCompany($data)
    {
        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']->store('logos', 'public');
        }

        return $this->create($data);
    }

    public function findCompanyById($companyId)
    {
        return $this->findOrFail($companyId); // Cari perusahaan berdasarkan ID
    }

    public function updateCompany($company, $data)
    {
        if (isset($data['logo'])) {
            if ($company->logo) {
                Storage::delete('public/' . $company->logo);
            }
            
            $data['logo'] = $data['logo']->store('logos', 'public');
        }

        $company->update($data); // Update data perusahaan
        return $company;
    }

    public function deleteCompany($company)
    {
        $company->delete(); 
    }
}