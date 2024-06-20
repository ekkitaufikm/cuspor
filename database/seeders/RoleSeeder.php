<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_roles')->insertOrIgnore([
                [
                    'id'        => 1,
                    'kode'      => 'root',
                    'nama'      => 'Root',
                ] 
            ]);
    
    }
}
