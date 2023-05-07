<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/users',[App\Http\Controllers\HomeController::class, 'userlist'])->name('userlist');
Route::get('/registerModel',[App\Http\Controllers\HomeController::class, 'registerModel'])->name('registerModel');
Route::get('/mapping', [App\Http\Controllers\HomeController::class, 'mapping'])->name('mapping');
Route::get('/map_company/{companyid}', [App\Http\Controllers\HomeController::class, 'map_company'])->name('map_company');
Route::post('/map-company-details', [App\Http\Controllers\HomeController::class, 'mapCompanyDetails'])->name('map-company-details');
Route::get('/download/{companyid}', [App\Http\Controllers\HomeController::class, 'download'])->name('download');
Route::get('/get-stock-years', [App\Http\Controllers\HomeController::class, 'getStockYears'])->name('getStockYears');
// Route::get('/get-pie-chart-data', [App\Http\Controllers\HomeController::class,'getPieChartData'])->name('getPieChartData');
// Route::get('/getCompanyShareData', [App\Http\Controllers\HomeController::class,'getCompanyShareData'])->name('getCompanyShareData');
Route::post('/fetchdata', [App\Http\Controllers\HomeController::class, 'fetchdata'])->name('fetchdata');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'search'])->name('search');



Route::post('/approve_user/{user}', [App\Http\Controllers\HomeController::class, 'approve'])->name('approve_user');
Route::delete('/reject_user/{user}', [App\Http\Controllers\HomeController::class, 'reject'])->name('reject_user');