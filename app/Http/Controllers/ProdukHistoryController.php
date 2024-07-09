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
        $sales_quotation = SalesQuotationModel::select('sls_quotation.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_quotation.status', 8)
            ->where('sls_customer.cust_name', Auth::user()->company_name)
            ->orderBy('sls_quotation.created_date', 'desc') // Menambahkan orderBy untuk mendapatkan yang terbaru
            ->get();
            // echo json_encode($sales_quotation); die;
        return view('produk_history.index', [
            'sales_quotation'       => $sales_quotation,
        ]);
    }

    public function show($id)
    {
        $id_sq = Crypt::decrypt($id);
        $sales_quotation = SalesQuotationModel::select('sls_quotation.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_quotation.sq_id', $id_sq)
            ->first();
        $quotation_customer = SalesQuotationModel::select('sls_customer_pic.*')
            ->join('sls_customer_pic', 'sls_quotation.cust_pic', '=', 'sls_customer_pic.pic_id')
            ->where('sls_quotation.sq_id', $id_sq)
            ->first();
        $sales_inquiry = SalesQuotationModel::select('sls_inquiry.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->where('sls_inquiry.inq_id', $sales_quotation->inq_id)
            ->first();
        $sales_customer = SalesQuotationModel::select('sls_customer.*', 'erp_user.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->join('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_inquiry.inq_id', $sales_quotation->inq_id)
            ->first();
        $quotation_items = QuotationItemModel::where('sq_id', $id_sq)
            ->get();

            // echo json_encode($sales_inquiry); die;
        return view('produk_history.show', [
            'sales_quotation'       => $sales_quotation,
            'quotation_customer'    => $quotation_customer,
            'sales_inquiry'         => $sales_inquiry,
            'sales_customer'        => $sales_customer,
            'quotation_items'       => $quotation_items
        ]);
    }
}
