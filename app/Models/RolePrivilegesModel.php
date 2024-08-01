<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePrivilegesModel extends Model
{
    use HasFactory;
    protected $table = 'm_roles_privileges';
    protected $guarded = ['id'];
    
    public function role()
    {
        return $this->belongsTo(RoleModel::class, 'm_role_id', 'id');
    }
    
    public function privilege()
    {
        return $this->belongsTo(PrivilegesModel::class, 'm_privilege_id', 'id');
    }

}
