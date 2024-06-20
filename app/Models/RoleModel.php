<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    use HasFactory;
    protected $table = 'm_roles';
    protected $fillable = [
        'kode', 'nama'
    ];

    public function privileges()
    {
        return $this->belongsToMany(PrivilegesModel::class, 'm_roles_privileges', 'm_role_id', 'm_privilege_id')->withTimestamps();
    }

}
