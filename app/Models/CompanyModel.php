<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyModel extends Model
{
    use HasFactory;

    protected $table = 'm_company';
    protected $fillable = [
        'company_name', 'company_sector', 'website', 'email', 'telephone', 'address'
    ];

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public function dieditOleh()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function companySector()
    {
        return $this->belongsTo(LookupModel::class, 'company_sector', 'lookup_code');
    }

}
