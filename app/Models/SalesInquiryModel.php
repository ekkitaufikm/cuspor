<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesInquiryModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'sls_inquiry';
    protected $guarded = ['sq_id'];
}
