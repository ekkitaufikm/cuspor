<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insertOrIgnore([
            [
                'id'        => 1,
                'username'  => 'admin_1',
                'name'      => 'Admin IT BBN',
                'password'  => Hash::make(12345678),
                'company_name'      => null,
                'company_sector'    => null,
                'phone'     => '082241698249',
                'alamat'    => 'Semarang',
                'm_role_id' => 1,
                'status'    => 1,
            ]
        ]);
    }
}
