<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

//model
use App\Models\LookupModel;
use App\Models\CustomerSatisfactionModel;
use App\Models\PkModel;

class CustomerSatisfactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer_satisfaction  = CustomerSatisfactionModel::all();
        $perintah_kerja         = PkModel::select('sls_pk.*', 'sls_customer.cust_name')
            ->join('sls_quotation', 'sls_pk.sq_id', '=', 'sls_quotation.sq_id')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_customer.cust_name', Auth::user()->company_name) 
            ->get();

        return view('customer_satisfaction.index', [
            "customer_satisfaction" => $customer_satisfaction,
            'perintah_kerja'        => $perintah_kerja
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $pk_no = Crypt::decrypt($id);
        $customer_satisfaction  = CustomerSatisfactionModel::all();
        $perintah_kerja         = PkModel::where('pk_no', $pk_no)->first();
        $data_customer = PkModel::select('sls_customer.*')
            ->join('sls_quotation', 'sls_pk.sq_id', '=', 'sls_quotation.sq_id')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_pk.pk_no', $pk_no) 
            ->first();
        $data_pic_sales = PkModel::select('erp_user.*')
            ->join('sls_quotation', 'sls_pk.sq_id', '=', 'sls_quotation.sq_id')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_pk.pk_no', $pk_no) 
            ->first();
        $data_pic_customer = PkModel::select('sls_customer_pic.*')
            ->join('sls_quotation', 'sls_pk.sq_id', '=', 'sls_quotation.sq_id')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer_pic', 'sls_inquiry.cust_pic_id', '=', 'sls_customer_pic.pic_id')
            ->where('sls_pk.pk_no', $pk_no) 
            ->first();
            // echo json_encode($data_pic_customer); die;

        return view('customer_satisfaction.create', [
            "customer_satisfaction" => $customer_satisfaction,
            'perintah_kerja'        => $perintah_kerja,
            'data_customer'         => $data_customer,
            'data_pic_sales'        => $data_pic_sales,
            'data_pic_customer'     => $data_pic_customer
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
