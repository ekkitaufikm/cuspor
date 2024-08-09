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
use App\Models\CustomerSatisfactionDetailModel;
use App\Models\SalesQuotationModel;
use App\Models\QuotationItemModel;

class CustomerSatisfactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SalesQuotationModel::select('sls_quotation.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_quotation.status', 8)
            ->where('sls_customer.cust_name', Auth::user()->company_name);

        $customer_satisfaction      = CustomerSatisfactionModel::all();
        $customer_satisfaction_dtl  = CustomerSatisfactionDetailModel::all();
        if ($request->has('sq_no')) {
            $query->where('sls_quotation.sq_no', 'like', '%' . $request->sq_no . '%');
        }

        if ($request->has('inq_no')) {
            $query->where('sls_inquiry.inq_no', 'like', '%' . $request->inq_no . '%');
        }

        if ($request->has('customer')) {
            $query->where('sls_customer.cust_name', 'like', '%' . $request->customer . '%');
        }

        if ($request->has('sq_date')) {
            $query->where('sls_quotation.created_date', 'like', '%' . $request->sq_date . '%');
        }

        if ($request->has('project_name')) {
            $query->where('sls_inquiry.project_name', 'like', '%' . $request->project_name . '%');
        }

        if ($request->has('status')) {
            $query->where('sls_quotation.status', 'like', '%' . $request->status . '%');
        }

        $sales_quotation = $query->orderBy('sls_quotation.created_date', 'desc')->get();

        // echo json_encode($sales_quotation); die;
        return view('customer_satisfaction.index', [
            "customer_satisfaction" => $customer_satisfaction,
            "customer_satisfaction_dtl" => $customer_satisfaction_dtl,
            "sales_quotation" => $sales_quotation
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $sq_no = Crypt::decrypt($id);
        $sales_quotation        = SalesQuotationModel::where('sq_no', $sq_no)->first();
        $quotation_customer = SalesQuotationModel::select('sls_customer_pic.*')
            ->join('sls_customer_pic', 'sls_quotation.cust_pic', '=', 'sls_customer_pic.pic_id')
            ->where('sls_quotation.sq_no', $sq_no)
            ->first();
        $sales_inquiry = SalesQuotationModel::select('sls_inquiry.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->where('sls_inquiry.inq_id', $sales_quotation->inq_id)
            ->first();
        $sales_customer = SalesQuotationModel::select('sls_customer.*', 'sls_customer_pic.*', 'erp_user.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->leftJoin('sls_customer_pic', 'sls_customer.cust_id', '=', 'sls_customer_pic.cust_id')
            ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_quotation.sq_no', $sq_no)
            ->first();
        $quotation_items = QuotationItemModel::where('sq_id', $sales_quotation->sq_id)
            ->get();
            // echo json_encode($sales_inquiry); die;

        return view('customer_satisfaction.create', [
            'sales_quotation'       => $sales_quotation,
            'quotation_customer'    => $quotation_customer,
            'sales_inquiry'         => $sales_inquiry,
            'sales_customer'        => $sales_customer,
            'quotation_items'       => $quotation_items
        ]);
    }

    public function rules($request)
    {
        $rule = [];
        $message = [];

        return Validator::make($request, $rule, $message);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $validator = $this->rules($request->all());

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        DB::beginTransaction();
        try {
            $sq_no = Crypt::decrypt($id);
            $sales_quotation        = SalesQuotationModel::where('sq_no', $sq_no)->first();
            $sales_inquiry = SalesQuotationModel::select('sls_inquiry.*')
                ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                ->where('sls_inquiry.inq_id', $sales_quotation->inq_id)
                ->first();

            $dataCSat = [
                'sq_id'         => $sales_quotation->sq_id,
                'pic_sales'     => $sales_inquiry->pic_sales,
                'cust_id'       => $sales_inquiry->cust_id,
                'cust_pic_id'   => $sales_inquiry->cust_pic_id,
                'remarks'       => $request->remarks,
                'status'        => 1,
            ];

            CustomerSatisfactionModel::create($dataCSat);
            $idCusSatisfaction = DB::getPdo()->lastInsertId();

            $dataCSatDet = [
                'customer_satisfaction_id'  => $idCusSatisfaction,
                'services'                  => ((($request->services_inquiry??'0')+($request->services_technical??'0')+($request->services_level_alignment??'0')) / 3)*10,
                'services_remarks'          => $request->services_remarks??'',
                'commercial_aspect'         => ((($request->commercial_level_alignment??'0')+($request->commercial_flexibility??'0')+($request->commercial_compliance??'0')) / 3)*10,
                'commercial_aspect_remarks' => $request->commercial_aspect_remarks??'',
                'delivery_material'         => ((($request->delivery_average??'0')+($request->delivery_completeness??'0')+($request->delivery_packing??'0')) / 3)*10,
                'delivery_material_remarks' => $request->delivery_material_remarks??'',
                'product_quality'           => ((($request->product_compliant??'0')+($request->product_certificate??'0')+($request->product_response??'0')) / 3)*10,
                'product_quality_remarks'   => $request->product_quality_remarks??'',
                'services_inquiry'          => $request->services_inquiry??'0',
                'services_technical'        => $request->services_technical??'0',
                'services_level_alignment'  => $request->services_level_alignment??'0',
                'commercial_level_alignment'=> $request->commercial_level_alignment??'0',
                'commercial_flexibility'    => $request->commercial_flexibility??'0',
                'commercial_compliance'     => $request->commercial_compliance??'0',
                'delivery_average'          => $request->delivery_average??'0',
                'delivery_completeness'     => $request->delivery_completeness??'0',
                'delivery_packing'          => $request->delivery_packing??'0',
                'product_compliant'         => $request->product_compliant??'0',
                'product_certificate'       => $request->product_certificate??'0',
                'product_response'          => $request->product_response??'0',
                'created_by'                => Auth::user()->id,
            ];

            $company_sarisfaction_details = CustomerSatisfactionDetailModel::create($dataCSatDet);

            if ($company_sarisfaction_details) {
                DB::commit();
                return response()->json(['status' => true, 'message' => "Data Survey Customer Satisfaction berhasil ditambahkan!", 'url' => '/customer-satisfaction'], 200);
            } else {
                DB::rollback();
                return response()->json(['status' => false, 'message' => "Gagal menambahkan data"], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sq_no = Crypt::decrypt($id);
        $sales_quotation        = SalesQuotationModel::where('sq_no', $sq_no)->first();
        $customer_satisfaction      = CustomerSatisfactionModel::where('sq_id', $sales_quotation->sq_id)->first();
        $customer_satisfaction_dtl  = CustomerSatisfactionDetailModel::where('customer_satisfaction_id', $customer_satisfaction->id)->first();

        $quotation_customer = SalesQuotationModel::select('sls_customer_pic.*')
            ->join('sls_customer_pic', 'sls_quotation.cust_pic', '=', 'sls_customer_pic.pic_id')
            ->where('sls_quotation.sq_no', $sq_no)
            ->first();
        $sales_inquiry = SalesQuotationModel::select('sls_inquiry.*', 'sls_customer.*', 'sls_customer_pic.*', 'erp_user.user_name as pic_sales_user_name')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->leftJoin('sls_customer_pic', 'sls_inquiry.cust_pic_id', '=', 'sls_customer_pic.pic_id')
            ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_inquiry.inq_id', $sales_quotation->inq_id)
            ->first();
        $sales_customer = SalesQuotationModel::select('sls_customer.*', 'sls_customer_pic.*', 'erp_user.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->leftJoin('sls_customer_pic', 'sls_customer.cust_id', '=', 'sls_customer_pic.cust_id')
            ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_quotation.sq_no', $sq_no)
            ->first();
        $quotation_items = QuotationItemModel::where('sq_id', $sales_quotation->sq_id)
            ->get();
            // echo json_encode($sales_inquiry); die;

        return view('customer_satisfaction.show', [
            'sales_quotation'       => $sales_quotation,
            "customer_satisfaction" => $customer_satisfaction,
            "customer_satisfaction_dtl" => $customer_satisfaction_dtl,
            'quotation_customer'    => $quotation_customer,
            'sales_inquiry'         => $sales_inquiry,
            'sales_customer'        => $sales_customer,
            'quotation_items'       => $quotation_items
        ]);
    }

    public function print(string $id)
    {
        $sq_no = Crypt::decrypt($id);
        $sales_quotation        = SalesQuotationModel::where('sq_no', $sq_no)->first();
        $customer_satisfaction      = CustomerSatisfactionModel::where('sq_id', $sales_quotation->sq_id)->first();
        $customer_satisfaction_dtl  = CustomerSatisfactionDetailModel::where('customer_satisfaction_id', $customer_satisfaction->id)->first();

        $quotation_customer = SalesQuotationModel::select('sls_customer_pic.*')
            ->join('sls_customer_pic', 'sls_quotation.cust_pic', '=', 'sls_customer_pic.pic_id')
            ->where('sls_quotation.sq_no', $sq_no)
            ->first();
        $sales_inquiry = SalesQuotationModel::select('sls_inquiry.*', 'sls_customer.*', 'sls_customer_pic.*', 'erp_user.user_name as pic_sales_user_name')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->leftJoin('sls_customer_pic', 'sls_inquiry.cust_pic_id', '=', 'sls_customer_pic.pic_id')
            ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_inquiry.inq_id', $sales_quotation->inq_id)
            ->first();
        $sales_customer = SalesQuotationModel::select('sls_customer.*', 'sls_customer_pic.*', 'erp_user.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->leftJoin('sls_customer_pic', 'sls_customer.cust_id', '=', 'sls_customer_pic.cust_id')
            ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_quotation.sq_no', $sq_no)
            ->first();
        $quotation_items = QuotationItemModel::where('sq_id', $sales_quotation->sq_id)
            ->get();
            // echo json_encode($sales_inquiry); die;

        return view('customer_satisfaction.print', [
            'sales_quotation'       => $sales_quotation,
            "customer_satisfaction" => $customer_satisfaction,
            "customer_satisfaction_dtl" => $customer_satisfaction_dtl,
            'quotation_customer'    => $quotation_customer,
            'sales_inquiry'         => $sales_inquiry,
            'sales_customer'        => $sales_customer,
            'quotation_items'       => $quotation_items
        ]);
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
