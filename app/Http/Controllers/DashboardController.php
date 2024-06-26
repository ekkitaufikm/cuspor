<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CustomerSatisfactionModel;
use App\Models\CustomerComplaintModel;

class DashboardController extends Controller
{

    public function dashboard() {
       
        $customer_complaint  = CustomerComplaintModel::all();
        $customer_satisfaction  = CustomerSatisfactionModel::all();
        
        return view('dashboard', [
            "customer_complaint"    => $customer_complaint,
            'customer_satisfaction' => $customer_satisfaction
        ]);
    }

}
