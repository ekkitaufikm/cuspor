<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

//model
use App\Models\User;
use App\Models\CompanyModel;

class UserController extends Controller
{
    private $modelName = 'Users';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return view('setting.users.index', [
            "users" => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting.users.create');
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
    public function store(Request $request)
    {
        $company = CompanyModel::where('company_name', $request->company_name)->first();
        $validator = $this->rules($request->all());

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        DB::beginTransaction();
        try {
            if($request->password != null){
                if ($request->password != $request->verifikasi) {
                    return response()->json(['status' => false, 'message' => "Password Not Match!"]);
                } else {

                    $data = $request->all();
                    $data['password']   = Hash::make($request->password);
                    $data['company_sector']   = $company->company_sector;
                    $data['created_by'] = Auth::user()->id;

                    $data_simpan = User::create($data);
                }
            } else {
                return response()->json(['status' => false, 'message' => "Password is Empty!"]);
            }

            if ($data_simpan) {
                DB::commit();
                return response()->json(['status' => true, 'message' => "Data berhasil ditambahkan!", 'url' => '/users'], 200);
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
        $id_users = Crypt::decrypt($id);
        $data['users'] = User::findOrFail($id_users);
        return view('setting.users.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id_users = Crypt::decrypt($id);
        $data['users'] = User::findOrFail($id_users);
        return view('setting.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $company = CompanyModel::where('company_name', $request->company_name)->first();
        $validator = $this->rules($request->all());

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        DB::beginTransaction();
        try {
            if($request->password != null){
                if ($request->password != $request->verifikasi) {
                    return response()->json(['status' => false, 'message' => "Password Not Match!"]);
                } else {
                    $data_users = User::findOrFail($id);
                    $data = $request->all();
                    $data['password']   = Hash::make($request->password);
                    $data['company_sector']   = $company->company_sector;
                    $data['updated_by'] = Auth::user()->id;

                    $simpan = $data_users->update($data);
                }
            } else {
                $data_users = User::findOrFail($id);
                $data['username']       = $request->username;
                $data['name']           = $request->name;
                $data['email']          = $request->email;
                $data['company_name']   = $request->company_name;
                $data['phone']          = $request->phone;
                $data['m_role_id']      = $request->m_role_id;
                $data['status']         = $request->status;
                $data['alamat']         = $request->alamat;
                $data['company_sector'] = $company->company_sector;
                $data['department']     = $request->department;
                $data['updated_by']     = Auth::user()->id;

                $simpan = $data_users->update($data);
            }

            if ($simpan) {
                DB::commit();
                return response()->json(['status' => true, 'message' => "Data berhasil diedit!", 'url' => '/users'], 200);
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        User::destroy($id);

        return redirect('company')->withSuccess('Data ' . $this->modelName . ' berhasil dihapus');
    }
}
