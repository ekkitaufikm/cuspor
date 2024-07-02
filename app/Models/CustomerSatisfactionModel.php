<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSatisfactionModel extends Model
{
    use HasFactory;

    protected $table = 'cp_customer_satisfaction';
    protected $fillable = [
        'sq_id', 'pic_sales', 'cust_id', 'cust_pic_id', 'remarks', 'status'
    ];

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public function dieditOleh()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    
    public function perintahKerja()
    {
        return $this->belongsTo(PkModel::class, 'pk_id', 'id');
    }
}
