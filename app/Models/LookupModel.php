<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'erp_lookup';
    protected $fillable = [
        'lookup_code', 'lookup_name', 'lookup_config'
    ];
}
