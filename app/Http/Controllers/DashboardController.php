<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\CustomerSatisfactionModel;
use App\Models\CustomerComplaintModel;
use App\Models\SalesQuotationModel;

class DashboardController extends Controller
{

    public function dashboard() 
    {
        $sales_quotation = SalesQuotationModel::select('sls_quotation.*', 'sls_customer.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_quotation.status', 8)
            ->where('sls_customer.cust_name', Auth::user()->company_name)
            ->orderBy('sls_quotation.created_date', 'desc')
            ->first();
        $customer_complaint  = CustomerComplaintModel::all();
        $customer_satisfaction  = CustomerSatisfactionModel::all();
        
        // echo json_encode($sales_quotation); die;
        return view('dashboard', [
            'sales_quotation'       => $sales_quotation,
            "customer_complaint"    => $customer_complaint,
            'customer_satisfaction' => $customer_satisfaction
        ]);
    }

}
