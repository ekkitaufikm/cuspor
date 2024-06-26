<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerComplaintModel extends Model
{
    use HasFactory;

    protected $table = 'cp_customer_complaint';
    protected $fillable = [
        'pk_id', 'pic_sales', 'cust_id', 'cust_pic_id', 'description', 'action_taken', 'status'
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
