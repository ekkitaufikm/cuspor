<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSatisfactionDetailModel extends Model
{
    use HasFactory;

    protected $table = 'cp_customer_satisfaction_detail';
    protected $guarded = ['id'];

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    
    public function dieditOleh()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    
    public function customerSatisfaction()
    {
        return $this->belongsTo(CustomerSatisfactionModel::class, 'customer_satisfaction_id', 'id');
    }
}
