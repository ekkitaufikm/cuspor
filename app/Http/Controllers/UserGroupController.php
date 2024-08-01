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
use App\Models\RoleModel;
use App\Models\PrivilegesModel;
use App\Models\RolePrivilegesModel;

class UserGroupController extends Controller
{
    private $modelName = 'User Group';
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = RoleModel::all();

        return view('setting.userGroup.index', [
            "role" => $role,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $privileges = PrivilegesModel::select('m_module_id', 'id', 'kode', 'nama')
                   ->whereIn('id', function($query) {
                       $query->selectRaw('MIN(id)')
                             ->from('m_privileges')
                             ->groupBy('m_module_id');
                   })
                   ->get();

        return view('setting.userGroup.create', [
            "privileges" => $privileges,
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
    public function store(Request $request)
    {
        $validator = $this->rules($request->all());

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        DB::beginTransaction();
        try {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id;

            // Simpan data role
            $data_simpan = RoleModel::create($data);
            $role = $data_simpan->id;

            // Simpan data privilege jika ada
            if ($request->has('m_privilege_id')) {
                foreach ($request->m_privilege_id as $privilege) {
                    $dataPriv = [
                        'm_role_id' => $role,
                        'm_privilege_id' => $privilege,
                    ];
                    DB::table('m_roles_privileges')->insert($dataPriv);
                }
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => "Data berhasil ditambahkan!", 'url' => '/user-group'], 200);

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
        $id_role = Crypt::decrypt($id);
        $role = RoleModel::where('id', $id_role)->first();
        
        // Get all privilege IDs related to the role
        $privilege_ids = RolePrivilegesModel::where('m_role_id', $id_role)
            ->pluck('m_privilege_id'); // This returns a flat array of IDs

        // Get privileges based on those IDs
        $privileges = PrivilegesModel::whereIn('id', $privilege_ids)
            ->select('m_module_id', DB::raw('count(*) as total')) // Select module ID and count
            ->with('module') // Ensure 'module' relation exists in PrivilegesModel
            ->groupBy('m_module_id') // Group by module ID
            ->get();
        
        return view('setting.userGroup.show', [
            'role' => $role,
            'privileges' => $privileges,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id_role = Crypt::decrypt($id);
        $role = RoleModel::where('id', $id_role)->first();

        // Ambil privileges yang dipilih untuk role ini
        $selected_privileges = RolePrivilegesModel::where('m_role_id', $id_role)
            ->pluck('m_privilege_id')
            ->toArray();

        $privileges = PrivilegesModel::select('m_module_id', 'id', 'kode', 'nama')
                ->whereIn('id', function($query) {
                    $query->selectRaw('MIN(id)')
                            ->from('m_privileges')
                            ->groupBy('m_module_id');
                })
                ->get();

        return view('setting.userGroup.edit', [
            'role' => $role,
            'privileges' => $privileges,
            'selected_privileges' => $selected_privileges, // Pastikan ini dikirim ke view
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = $this->rules($request->all());

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()], 200);
        }

        DB::beginTransaction();
        try {
            $data_role = User::findOrFail($id);
            $data = $request->all();
            $data['updated_by'] = Auth::user()->id;

            // Simpan data role
            $simpan = $data_role->update($data);
            $role = $data_simpan->id;

            // Simpan data privilege jika ada
            if ($request->has('m_privilege_id')) {
                DB::table('m_roles_privileges')->where('m_role_id', $role)->delete();
                foreach ($request->m_privilege_id as $privilege) {
                    $dataPriv = [
                        'm_role_id' => $role,
                        'm_privilege_id' => $privilege,
                    ];
                    DB::table('m_roles_privileges')->insert($dataPriv);
                }
            }

            DB::commit();
            return response()->json(['status' => true, 'message' => "Data berhasil ditambahkan!", 'url' => '/user-group'], 200);

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
