<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PkModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'sls_pk';
    protected $guarded = ['pk_id'];

}
