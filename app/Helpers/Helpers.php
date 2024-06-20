<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
 
class Helpers {
    public static function hasPrivilege($kode) {
        if(is_string($kode)) {
            $kode = [$kode];
        }

        if(!Auth::user()->role) return false;
        return Auth::user()->role->privileges()->whereIn('kode', $kode)->first();
    }

    public static function hasRole($roleId) {
        if(is_string($roleId)) {
            $roleId = [$roleId];
        }

        if(!Auth::user()->role) return false;
        foreach ($roleId as $key => $value) {
            if(Auth::user()->m_role_id == $value) {
                return true;
            }
        }
        return false;
    }

    public static function GetUsersByPrivilege($users, $kodePrivilege) {
        return $users->whereHas('role', function($q) use ($kodePrivilege) {
            $q->whereHas('privileges', function($r) use ($kodePrivilege) {
                $r->where('kode', $kodePrivilege);
            });
        })->get();
    }
    
    public static function isDecimal( $val )
    {
        return is_numeric( $val ) && floor( $val ) != $val;
    }

    public static function decimalDigit($val, $place = null, $point = null)
    {
        return self::isDecimal($val) ? number_format($val, $place ?? 2, $point ?? '.', '') : $val;
    }
}
