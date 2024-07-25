<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

//model
use App\Models\LookupModel;
use App\Models\CustomerSatisfactionModel;
use App\Models\CustomerComplaintModel;
use App\Models\CustomerComplaintCategoryModel;
use App\Models\CustomerComplaintFileModel;
use App\Models\SalesQuotationModel;
use App\Models\QuotationItemModel;

class CustomerComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sales_quotation = SalesQuotationModel::all();

        // Start building the query
        $query = CustomerComplaintModel::where('personal_name', Auth::user()->name);

        // Apply filters based on request parameters
        if ($request->has('sq_no')) {
            $query->where('sq_no', 'like', '%' . $request->sq_no . '%');
        }

        if ($request->has('inq_no')) {
            $query->where('inq_no', 'like', '%' . $request->inq_no . '%');
        }

        if ($request->has('customer')) {
            $query->where('customer', 'like', '%' . $request->customer . '%');
        }

        if ($request->has('sq_date')) {
            $query->where('sq_date', 'like', '%' . $request->sq_date . '%');
        }

        if ($request->has('project_name')) {
            $query->where('project_name', 'like', '%' . $request->project_name . '%');
        }

        // Execute the query and get the results
        $customer_complaint = $query->get();

        return view('customer_complaint.index', [
            "customer_complaint" => $customer_complaint,
            "sales_quotation"    => $sales_quotation
        ]);
    }

    public function rules($request)
    {
        $rule = [];
        $message = [];

        return Validator::make($request, $rule, $message);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customer_complaint  = CustomerComplaintModel::all();
        $sales_quotation = SalesQuotationModel::select('sls_quotation.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_quotation.status', 8)
            ->where('sls_customer.cust_name', Auth::user()->company_name)
            ->orderBy('sls_quotation.created_date', 'desc')
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
            ->where('sls_quotation.sq_no', $sales_quotation->sq_no)
            ->first();
        $quotation_items = QuotationItemModel::where('sq_id', $sales_quotation->sq_id)
            ->get();
            // echo json_encode($data_pic_sales); die;

        return view('customer_complaint.create', [
            "customer_complaint" => $customer_complaint,
            'sales_quotation'        => $sales_quotation,
            'sales_inquiry'         => $sales_inquiry,
            'sales_customer'        => $sales_customer,
            'quotation_items'     => $quotation_items,
        ]);
    }

    public function getDataAjax()
    {
        $customer_satisfaction = CustomerSatisfactionModel::pluck('sq_id')->toArray();
        $sales_quotation = SalesQuotationModel::select('sls_quotation.*', 'sls_inquiry.*', 'sls_customer.*', 'sls_customer_pic.*', 'erp_user.user_name as pic_sales_user_name')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->leftJoin('sls_customer_pic', 'sls_inquiry.cust_pic_id', '=', 'sls_customer_pic.pic_id')
            ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_quotation.status', 8)
            ->where('sls_customer.cust_name', Auth::user()->company_name)
            ->whereNotIn('sls_quotation.sq_id', $customer_satisfaction)
            ->orderBy('sls_quotation.created_date', 'desc')
            ->get();
        
        return response()->json($sales_quotation);
    }

    public function getQuotationDetails(Request $request)
    {
        // Validasi request
        $request->validate([
            'sqNo' => 'required|string', // SQ number yang dikirim dari Ajax
        ]);

        // Ambil SQ number dari request
        $sqNo = $request->input('sqNo');

        // Cari quotation berdasarkan SQ number
        $quotation        = SalesQuotationModel::where('sq_no', $sqNo)->first();
        $quotation_customer = SalesQuotationModel::select('sls_customer_pic.*')
            ->join('sls_customer_pic', 'sls_quotation.cust_pic', '=', 'sls_customer_pic.pic_id')
            ->where('sls_quotation.sq_no', $sqNo)
            ->first();
        $sales_inquiry = SalesQuotationModel::select('sls_inquiry.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->where('sls_inquiry.inq_id', $quotation->inq_id)
            ->first();
        $sales_customer = SalesQuotationModel::select('sls_customer.*', 'sls_customer_pic.*', 'erp_user.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->leftJoin('sls_customer_pic', 'sls_customer.cust_id', '=', 'sls_customer_pic.cust_id')
            ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
            ->where('sls_quotation.sq_no', $sqNo)
            ->first();
        $quotation_items = QuotationItemModel::where('sq_id', $quotation->sq_id)->get();

        $lookup_status = \App\Models\LookupModel::where('lookup_config', 'sls_quotation_status')->where('lookup_code', $quotation->status)->first();
        $lookup_sqType = \App\Models\LookupModel::where('lookup_config', 'sq_type')->where('lookup_code', $quotation->sq_type)->first();
        $lookup_sqOffMode = \App\Models\LookupModel::where('lookup_config', 'offer_mode')->where('lookup_code', $quotation->oﬀer_mode)->first();
        $lookup_sqPayment = \App\Models\LookupModel::where('lookup_config', 'payment_terms')->where('lookup_code', $quotation->payment_term)->first();
        $lookup_sqPayMode = \App\Models\LookupModel::where('lookup_config', 'payment_mode')->where('lookup_code', $quotation->payment_mode)->first();
        $lookup_sqDelTime = \App\Models\LookupModel::where('lookup_config', 'delivery_times')->where('lookup_code', $quotation->delivery_times)->first();
        $lookup_sqDelMode = \App\Models\LookupModel::where('lookup_config', 'delivery_mode')->where('lookup_code', $quotation->delivery_mode)->first();
        $lookup_sqPacking = \App\Models\LookupModel::where('lookup_config', 'packing')->where('lookup_code', $quotation->packing)->first();
        $lookup_sqSertif = \App\Models\LookupModel::where('lookup_config', 'certification')->where('lookup_code', $quotation->certﬁcate)->first();
        $lookup_offerVal = \App\Models\LookupModel::where('lookup_config', 'offer_validity')->where('lookup_code', $quotation->oﬀer_validity)->first();
        $lookup_stageInquiry    = \App\Models\LookupModel::where('lookup_config', 'sls_stage_inquiry')->where('lookup_code', $sales_inquiry->stage_inquiry)->first();
        $lookup_statusInquiry   = \App\Models\LookupModel::where('lookup_config', 'sls_inquiry_status')->where('lookup_code', $sales_inquiry->status)->first();
        $lookup_companySector   = \App\Models\LookupModel::where('lookup_config', 'company_sector')->where('lookup_code', $sales_customer->company_sector)->first();
        $lookup_customerType    = \App\Models\LookupModel::where('lookup_config', 'sls_customer_type')->where('lookup_code', $sales_customer->cust_type)->first();
        // Jika quotation tidak ditemukan, kembalikan response error
        if (!$quotation) {
            return response()->json(['error' => 'Quotation not found'], 404);
        }

        // Jika ditemukan, kembalikan detail quotation dalam bentuk JSON
        return response()->json([
            //SQ Information
            'sq_no'             => $quotation->sq_no,
            'sq_id'             => $quotation->sq_id,
            'inq_no'            => $sales_inquiry->inq_no,
            'quotation_date'    => $quotation->created_date,
            'status'            => $lookup_status->lookup_name,
            'offer_mode'        => $lookup_sqOffMode->lookup_name,
            'est_ship_weight'   => $quotation->est_ship_weight,
            'payment_term'      => $lookup_sqPayment->lookup_name,
            'payment_mode'      => $lookup_sqPayMode->lookup_name,
            'delivery_time'     => $lookup_sqDelTime->lookup_name,
            'tech_remarks'      => $quotation->remarks,
            'delivery_mode'     => $lookup_sqDelMode->lookup_name,
            'packing'           => $lookup_sqPacking->lookup_name,
            'certification'     => $lookup_sqSertif->lookup_name,
            'offer_validity'    => $lookup_offerVal->lookup_name,
            //Inquiry Information
            'inq_no'            => $sales_inquiry->inq_no,
            'stage_inquiry'     => $lookup_stageInquiry->lookup_name,
            'inquiry_date'      => $sales_inquiry->created_date,
            'status_inquiry'    => $lookup_statusInquiry->lookup_name,
            'pic_ack'           => $sales_inquiry->created_by,
            'email_datetime'    => $sales_inquiry->email_date,
            'closing_date'      => $sales_inquiry->closing_date,
            'subject_inquiry'   => $sales_inquiry->subject,
            'pic_sales'         => $sales_customer->user_name,
            'remarks_inquiry'   => $sales_inquiry->remarks,
            'customer_name'     => $sales_customer->cust_name,
            'customer_type'     => $lookup_customerType->lookup_name,
            'pic_customer'      => $sales_customer->pic_name,
            'quotation_items'   => $quotation_items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = $this->rules($request->all());

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }
        
        $request->validate([
            'file_lampiran.*' => 'nullable|mimes:doc,pdf,xls,xlsx|max:2048',
            'file_photo.*' => 'nullable|mimes:png,jpg,jpeg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            // Get last stored number
            $lastNumber = file_exists('lastNumber.txt') ? (int) file_get_contents('lastNumber.txt') : 0;

            // Increment number for new complaint
            $newNumber = $lastNumber + 1;

            // Update last stored number in file
            file_put_contents('lastNumber.txt', $newNumber);

            // Format complaint number
            $complaint_no = str_pad($newNumber, 4, '0', STR_PAD_LEFT) . "/EXP/" . date('mY');

            // Fetch related data
            $quotation = SalesQuotationModel::where('sq_id', $request->sq_id)->first();
            $sales_inquiry = SalesQuotationModel::select('sls_inquiry.*')
                ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                ->where('sls_inquiry.inq_id', $quotation->inq_id)
                ->first();
            $sales_customer = SalesQuotationModel::select('sls_customer.*', 'sls_customer_pic.*', 'erp_user.*')
                ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
                ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
                ->leftJoin('sls_customer_pic', 'sls_customer.cust_id', '=', 'sls_customer_pic.cust_id')
                ->leftJoin('erp_user', 'sls_inquiry.pic_sales', '=', 'erp_user.id')
                ->where('sls_quotation.sq_no', $quotation->sq_no)
                ->first();

            // Create Customer Complaint
            $data = [
                'complaint_no' => $complaint_no,
                'sq_id' => $request->sq_id,
                'sq_no' => $quotation->sq_no,
                'inq_no' => $sales_inquiry->inq_no,
                'project_name' => $sales_inquiry->project_name,
                'customer' => $sales_customer->cust_name,
                'sq_date' => $quotation->created_date,
                'pic_sales' => $sales_customer->user_name,
                'personal_name' => Auth::user()->name,
                'telp_fax' => Auth::user()->phone,
                'phone' => Auth::user()->phone,
                'email' => Auth::user()->email,
                'title' => Auth::user()->department,
                'po_dan_date' => $request->po_dan_date,
                'description' => $request->description,
                'created_by' => Auth::user()->id,
                'status' => 1,
            ];

            $customerComplaint = CustomerComplaintModel::create($data);
            $customerComplaintId = $customerComplaint->id;

            // Input category
            if ($request->has('category')) {
                foreach ($request->category as $category) {
                    CustomerComplaintCategoryModel::create([
                        'customer_complaint_id' => $customerComplaintId,
                        'category_name' => $category,
                        'category_other' => $request->category_other,
                    ]);
                }
            }

            if ($request->hasFile('file_lampiran')) {
                foreach ($request->file('file_lampiran') as $file) {
                    // Simpan atau proses setiap file lampiran
                    $filename = $file->getClientOriginalName();
                    $file->storeAs('lampiran', $filename, 'public'); // Simpan di dalam folder 'lampiran' di storage public
                }
            }
    
            if ($request->hasFile('file_photo')) {
                foreach ($request->file('file_photo') as $photo) {
                    // Simpan atau proses setiap foto
                    $filename = $photo->getClientOriginalName();
                    $photo->storeAs('photos', $filename, 'public'); // Simpan di dalam folder 'photos' di storage public
                }
            }
    
            // Input file Lampiran
            if ($request->hasFile('file_lampiran')) {
                foreach ($request->file('file_lampiran') as $file) {
                    $fileName = Str::uuid() . "-" . time() . "." . $file->extension();
                    $file->move("upload/customer_complaint/lampiran/", $fileName);
            
                    CustomerComplaintFileModel::create([
                        'customer_complaint_id' => $customerComplaintId,
                        'file_lampiran' => $fileName,
                        'created_by' => Auth::user()->id,
                    ]);
                }
            }
            
            // Input file Photo
            if ($request->hasFile('file_photo')) {
                foreach ($request->file('file_photo') as $file) {
                    $filePhoto = Str::uuid() . "-" . time() . "." . $file->extension();
                    $file->move("upload/customer_complaint/foto/", $filePhoto);
            
                    CustomerComplaintFileModel::create([
                        'customer_complaint_id' => $customerComplaintId,
                        'foto_lampiran' => $filePhoto,
                        'created_by' => Auth::user()->id,
                    ]);
                }
            }

            // Commit transaction
            DB::commit();

            return response()->json(['status' => true, 'message' => "Data Survey Customer Complaint berhasil ditambahkan!", 'url' => '/customer-complaint'], 200);
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
        $complaint_id       = Crypt::decrypt($id);
        $customer_complaint = CustomerComplaintModel::where('id', $complaint_id)->first();
        $customer_complaint_category    = CustomerComplaintCategoryModel::where('customer_complaint_id', $complaint_id)->get();
        $customer_complaint_file        = CustomerComplaintFileModel::where('customer_complaint_id', $complaint_id)->get();
        $sales_quotation = SalesQuotationModel::select('sls_quotation.*')
            ->join('sls_inquiry', 'sls_quotation.inq_id', '=', 'sls_inquiry.inq_id')
            ->join('sls_customer', 'sls_inquiry.cust_id', '=', 'sls_customer.cust_id')
            ->where('sls_quotation.status', 8)
            ->where('sls_quotation.sq_id', $customer_complaint->sq_id)
            ->orderBy('sls_quotation.created_date', 'desc')
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
            ->where('sls_quotation.sq_no', $sales_quotation->sq_no)
            ->first();
        $quotation_items = QuotationItemModel::where('sq_id', $sales_quotation->sq_id)
            ->get();
            // echo json_encode($sales_quotation); die;

        return view('customer_complaint.show', [
            "customer_complaint"            => $customer_complaint,
            'customer_complaint_category'   => $customer_complaint_category,
            'customer_complaint_file'       => $customer_complaint_file,
            'sales_quotation'               => $sales_quotation,
            'sales_inquiry'                 => $sales_inquiry,
            'sales_customer'                => $sales_customer,
            'quotation_items'               => $quotation_items,
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
