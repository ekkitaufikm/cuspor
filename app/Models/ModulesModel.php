<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulesModel extends Model
{
    use HasFactory;
    protected $table = 'm_modules';
    
    protected $fillable = [
        'id', 'nama',
    ];

}
