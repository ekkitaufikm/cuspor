<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItemModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = 'sls_quotation_items_int';
    protected $guarded = ['sls_item_int_id'];
}
