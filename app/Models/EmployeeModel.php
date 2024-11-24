<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeModel extends Model
{
    use HasFactory;

    protected $table = 'employees';
    
    protected $fillable = ['first_name', 'last_name', 'company_id', 'email', 'phone'];

    public function company()
    {
        return $this->belongsTo(CompanyModel::class);
    }

    public function getAll()
    {
        return $this->all();
    }

    public function findEmployeeById($employeeId)
    {
        return $this->findOrFail($employeeId); // Cari perusahaan berdasarkan ID
    }

    public static function createEmployee(array $data)
    {
        return self::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'company_id' => $data['company_id'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
        ]);
    }

    public function updateEmployee($employee, $data)
    {

        $employee->update($data);

        return $employee;
    }

}