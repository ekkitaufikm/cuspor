<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivilegesModel extends Model
{
    use HasFactory;
    protected $table = 'm_privileges';
    protected $guarded = ['id'];
    
    public function module()
    {
        return $this->belongsTo(ModulesModel::class, 'm_module_id', 'id');
    }

    public function privileges() {
        return $this->hasMany(PrivilegesModel::class, 'm_module_id');
    }

}
