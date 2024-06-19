<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//master data
Route::any('getAllProvinsi/', 'Api\DaerahController@getAllProvinsi');
Route::any('getDaerah/{idMprovinsi}', 'Api\DaerahController@getDaerah');
Route::any('getKecamatan/{idMdaerah}', 'Api\DaerahController@getKecamatan');
Route::any('getDesa/{idMkecamatan}', 'Api\DaerahController@getDesa');


//dataTable
Route::any('getDataDaerah/{idMProvinsi}', 'DataTables\DaerahDataTables@getTabelDaerah');
Route::any('getTabelKecamatan/{idMDaerah}', 'DataTables\KecamatanDataTables@getTabelKecamatan');
Route::any('getTabelDesa/{idMKecamatan}', 'DataTables\DesaDataTables@getTabelDesa');
Route::any('getTabelPasien/{idMDesa}', 'DataTables\PasienDataTables@getTabelPasien');