<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

//model
use App\Models\LookupModel;
use App\Models\QuotationItemModel;
use App\Models\SalesQuotationModel;

class ProdukHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales_quotation    = SalesQuotationModel::select('sls_quotation.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_customer.cust_name', Auth::user()->company_name) 
            ->get();

        $quotation_items    = QuotationItemModel::select('sls_quotation_items_int.*', 'sls_customer.cust_name')
            ->join('sls_quotation', 'sls_quotation_items_int.sq_id', '=', 'sls_quotation.sq_id')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_customer.cust_name', Auth::user()->company_name) 
            ->get();

            // echo json_encode($sales_quotation); die;
        return view('produk_history.index', [
            'sales_quotation'       => $sales_quotation,
            'quotation_items'       => $quotation_items
        ]);
    }
}
