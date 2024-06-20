<?php

namespace Database\Seeders;

//library
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Str;

//models
use App\Models\RoleModel;
use App\Models\PrivilegesModel;

class ModulesRolesPrivilegesSeeder extends Seeder
{
    private $privId = 1;
    private $rpId = 1;
    private $modulesPrivileges = array();
    private $moduleIds = [
       'Dashboard' => 1,
       'Complaint' => 2,
       'Satisfaction' => 3,
       'Certificate' => 4,
       'Tracking' => 5,
       'History' => 6,
       'Company' => 7,
       'User' => 8,
       'Role' => 8,
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = array();
        foreach($this->moduleIds as $name => $id) {
            $modules[] = [
                'id' => $id,
                'nama' => $name
            ];
        }
        DB::table('m_modules')->insertOrIgnore($modules);

        /**
         * PRIVILEGES TABLE INSERT
         * START
         */
        $privileges = array();

        /**
         * Dashboard 
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['Dashboard'], $privileges, [
            'dashboardr' => 'Lihat Dashboard',
        ]);

        /**
         * Complaint
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['Complaint'], $privileges, [
            'complaintc' => 'Tambah Complaint',
            'complaintr' => 'Lihat Complaint',
            'complaintu' => 'Update Complaint',
            'complaintd' => 'Hapus Complaint',
        ]);
        
        /**
         * Satisfaction
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['Satisfaction'], $privileges, [
            'satisfactionc' => 'Tambah Satisfaction',
            'satisfactionr' => 'Lihat Satisfaction',
            'satisfactionu' => 'Update Satisfaction',
            'satisfactiond' => 'Hapus Satisfaction',
        ]);
        
        /**
         * Certificate
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['Certificate'], $privileges, [
            'certificatec' => 'Tambah Certificate',
            'certificater' => 'Lihat Certificate',
            'certificateu' => 'Update Certificate',
            'certificated' => 'Hapus Certificate',
        ]);

        /**
         * Tracking
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['Tracking'], $privileges, [
            'trackingc' => 'Tambah Tracking',
            'trackingr' => 'Lihat Tracking',
            'trackingu' => 'Update Tracking',
            'trackingd' => 'Hapus Tracking',
        ]);
        
        /**
         * History
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['History'], $privileges, [
            'historyc' => 'Tambah History',
            'historyr' => 'Lihat History',
            'historyu' => 'Update History',
            'historyd' => 'Hapus History',
        ]);
        
        /**
         * Company
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['Company'], $privileges, [
            'companyc' => 'Tambah Company',
            'companyr' => 'Lihat Company',
            'companyu' => 'Update Company',
            'companyd' => 'Hapus Company',
        ]);
        
        /**
         * User
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['User'], $privileges, [
            'userc' => 'Tambah User',
            'userr' => 'Lihat User',
            'useru' => 'Update User',
            'userd' => 'Hapus User',
        ]);
        
        /**
         * Role
         */
        $privileges = $this->shapePrivilegeData($this->moduleIds['Role'], $privileges, [
            'rolec' => 'Tambah Role',
            'roler' => 'Lihat Role',
            'roleu' => 'Update Role',
            'roled' => 'Hapus Role',
        ]);
        
        DB::table('m_privileges')->insertOrIgnore($privileges);

        $RootPrivileges = [
            'modules' => [
                'Dashboard',
                'Complaint',
                'Satisfaction',
                'Certificate',
                'Tracking',
                'History',
                'Company',
                'User',
                'Role',
            ]
        ];
        $this->givePrivileges($RootPrivileges, 'root');
    }
    private function shapePrivilegeData($moduleId, $privilegesArr, $data) {
        foreach($data as $kode => $nama) {
            $privilegesArr[] = [
                'id' => $this->privId++,
                'm_module_id' => $moduleId,
                'kode' => $kode,
                'nama' => $nama
            ];
        }
        $this->modulesPrivileges[$moduleId] = $data;
        return $privilegesArr;
    }

    private function givePrivileges($data, $kodeRole) {
        $modulesInput = array_key_exists('modules', $data) ? $data['modules'] : [];
        $privilegesInput = array_key_exists('privileges', $data) ? $data['privileges'] : [];
        $privilegesToGive = array();
        $roleId = RoleModel::where('kode', $kodeRole)->pluck('id')->first();
        foreach($modulesInput as $input) {
            foreach($this->modulesPrivileges[$this->moduleIds[$input]] as $privilege => $_) {
                $privilegesToGive[$privilege] = true;
            }
        }

        foreach($privilegesInput as $privilege) {
            if(Str::startsWith($privilege,'-')) {
                unset($privilegesToGive[Str::after($privilege, '-')]);
            } else {
                $privilegesToGive[$privilege] = true;
            }
        }

        foreach($privilegesToGive as $privilege => $_) {
            $privilegeId = PrivilegesModel::where('kode', $privilege)->pluck('id')->first();
            $rolePrivilege = [
                'id' => $this->rpId++,
                'm_role_id' => $roleId,
                'm_privilege_id' => $privilegeId
            ];

            DB::table('m_roles_privileges')->insertOrIgnore($rolePrivilege);
        }


    }
}
