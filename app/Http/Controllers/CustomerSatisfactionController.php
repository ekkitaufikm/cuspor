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
    public function index()
    {
        $sales_quotation = SalesQuotationModel::select('sls_quotation.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_quotation.status', 8)
            ->where('sls_customer.cust_name', Auth::user()->company_name)
            ->orderBy('sls_quotation.created_date', 'desc')
            ->get();
        $customer_satisfaction      = CustomerSatisfactionModel::all();
        $customer_satisfaction_dtl  = CustomerSatisfactionDetailModel::all();

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
                'commercial_aspect'         => (($request->telephone_reception+$request->time_for_quotation+$request->prices+$request->delivery_document+$request->invoice_document+$request->visit_frequency_ca+$request->information_product) / 7)*10,
                'commercial_aspect_remarks' => $request->commercial_aspect_remarks,
                'technical_aspect'          => (($request->general_information+$request->technical_advice+$request->time_answer_tq+$request->visit_frequency_ta) / 4)*10,
                'technical_aspect_remarks'  => $request->technical_aspect_remarks,
                'logistics'                 => (($request->average_time+$request->emergency_delivery+$request->delivery_reliability+$request->visit_frequency_log) / 4)*10,
                'logistics_remarks'         => $request->logistics_remarks,
                'quality'                   => (($request->product_quality+$request->non_confirmity+$request->time_answer_qq+$request->management_inspection+$request->time_anser_quotation) / 5)*10,
                'quality_remarks'           => $request->quality_remarks,
                'telephone_reception'       => $request->telephone_reception,
                'time_for_quotation'        => $request->time_for_quotation,
                'prices'                    => $request->prices,
                'delivery_document'         => $request->delivery_document,
                'invoice_document'          => $request->invoice_document,
                'visit_frequency_ca'        => $request->visit_frequency_ca,
                'information_product'       => $request->information_product,
                'general_information'       => $request->general_information,
                'technical_advice'          => $request->technical_advice,
                'time_answer_tq'            => $request->time_answer_tq,
                'visit_frequency_ta'        => $request->visit_frequency_ta,
                'average_time'              => $request->average_time,
                'emergency_delivery'        => $request->emergency_delivery,
                'delivery_reliability'      => $request->delivery_reliability,
                'visit_frequency_log'       => $request->visit_frequency_log,
                'product_quality'           => $request->product_quality,
                'non_confirmity'            => $request->non_confirmity,
                'time_answer_qq'            => $request->time_answer_qq,
                'management_inspection'     => $request->management_inspection,
                'time_anser_quotation'      => $request->time_anser_quotation,
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
