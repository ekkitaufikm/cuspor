<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivilegesModel extends Model
{
    use HasFactory;
    protected $table = 'm_privileges';
    protected $fillable = [
        'm_module_id', 'kode', 'nama'
    ];
    
    public function module()
    {
        return $this->belongsTo(ModulesModel::class, 'm_module_id', 'id');
    }

}
