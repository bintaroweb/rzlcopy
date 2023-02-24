<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

// Route::get('/login', [App\Http\Controllers\LoginController::class, 'authenticate']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Customer
Route::get('customers/datatable', [\App\Http\Controllers\CustomerController::class, 'datatable']);
Route::get('customers/autocomplete', [\App\Http\Controllers\CustomerController::class, 'autocomplete']);
Route::get('customers/machines', [\App\Http\Controllers\CustomerController::class, 'machines']);
Route::resource('customers', '\App\Http\Controllers\CustomerController');
//Product
Route::get('products/datatables', [\App\Http\Controllers\ProductController::class, 'datatable']);
Route::get('products/autocomplete', [\App\Http\Controllers\ProductController::class, 'autocomplete']);
Route::resource('products', '\App\Http\Controllers\ProductController');
//User
Route::get('users/datatable', [\App\Http\Controllers\UserController::class, 'datatable']);
Route::resource('users', '\App\Http\Controllers\UserController');
//User
Route::get('products/datatable', [\App\Http\Controllers\UserController::class, 'datatable']);
Route::resource('products', '\App\Http\Controllers\ProductController');
//Technician
Route::get('technicians/datatable', [\App\Http\Controllers\TechnicianController::class, 'datatable']);
Route::resource('technicians', '\App\Http\Controllers\TechnicianController');
//Schedule
Route::get('schedules/datatable', [\App\Http\Controllers\ScheduleController::class, 'datatable']);
Route::get('schedules/customer', [\App\Http\Controllers\ScheduleController::class, 'customer']);
Route::get('schedules/address', [\App\Http\Controllers\ScheduleController::class, 'address']);
Route::get('schedules/print', [\App\Http\Controllers\ScheduleController::class, 'print']);
Route::get('schedules/cetak', [\App\Http\Controllers\ScheduleController::class, 'cetak']);
Route::get('schedules/autocomplete', [\App\Http\Controllers\ScheduleController::class, 'autocomplete']);
Route::resource('schedules', '\App\Http\Controllers\ScheduleController');
//Delivery Note (Surat Jalan)
Route::get('deliveries/datatable', [\App\Http\Controllers\DeliveryController::class, 'datatable']);
Route::get('deliveries/address', [\App\Http\Controllers\DeliveryController::class, 'address']);
Route::get('deliveries/cetak', [\App\Http\Controllers\DeliveryController::class, 'cetak']);
Route::get('deliveries/autocomplete', [\App\Http\Controllers\DeliveryController::class, 'autocomplete']);
Route::resource('deliveries', '\App\Http\Controllers\DeliveryController');
//Invoice
Route::get('invoices/datatable', [\App\Http\Controllers\InvoiceController::class, 'datatables']);
Route::get('invoices/address', [\App\Http\Controllers\InvoiceController::class, 'address']);
Route::get('invoices/cetak', [\App\Http\Controllers\InvoiceController::class, 'cetak']);
Route::get('invoices/autocomplete', [\App\Http\Controllers\InvoiceController::class, 'autocomplete']);
Route::resource('invoices', '\App\Http\Controllers\InvoiceController');
//Machine
Route::get('machines/datatable', [\App\Http\Controllers\MachineController::class, 'datatable']);
// Route::get('records/address', [\App\Http\Controllers\RecordController::class, 'address']);
// Route::get('records/cetak', [\App\Http\Controllers\RecordController::class, 'cetak']);
// Route::get('records/autocomplete', [\App\Http\Controllers\RecordController::class, 'autocomplete']);
// Route::post('records/import', [\App\Http\Controllers\RecordController::class, 'import']);
Route::resource('machines', '\App\Http\Controllers\MachineController');
//Machine Record
Route::get('records/datatable', [\App\Http\Controllers\RecordController::class, 'datatable']);
Route::get('records/address', [\App\Http\Controllers\RecordController::class, 'address']);
Route::get('records/cetak', [\App\Http\Controllers\RecordController::class, 'cetak']);
Route::get('records/autocomplete', [\App\Http\Controllers\RecordController::class, 'autocomplete']);
Route::post('records/import', [\App\Http\Controllers\RecordController::class, 'import']);
Route::resource('records', '\App\Http\Controllers\RecordController');
//Worksheet
Route::get('worksheets', [\App\Http\Controllers\WorksheetController::class, 'index']);
Route::get('worksheets/cetak', [\App\Http\Controllers\WorksheetController::class, 'cetak']);
Route::get('worksheets/print', [\App\Http\Controllers\WorksheetController::class, 'print']);
//Account
Route::get('settings/account/edit', [\App\Http\Controllers\AccountController::class, 'edit']);
Route::post('settings/account/update', [\App\Http\Controllers\AccountController::class, 'update']);
//Company
Route::get('settings/company/edit', [\App\Http\Controllers\CompanyController::class, 'edit']);
Route::post('settings/company/update', [\App\Http\Controllers\CompanyController::class, 'update']);
Route::post('settings/company/city', [\App\Http\Controllers\CompanyController::class, 'city']);
Route::post('settings/company/district', [\App\Http\Controllers\CompanyController::class, 'district']);
//SalesType
Route::get('settings/salestype/datatable', [\App\Http\Controllers\SalesTypeController::class, 'datatable']);
Route::get('settings/salestype', [\App\Http\Controllers\SalesTypeController::class, 'index']);
Route::post('settings/salestype/store', [\App\Http\Controllers\SalesTypeController::class, 'store']);
Route::get('settings/salestype/edit', [\App\Http\Controllers\SalesTypeController::class, 'edit']);
Route::put('settings/salestype/update', [\App\Http\Controllers\SalesTypeController::class, 'update']);
Route::delete('settings/salestype/destroy', [\App\Http\Controllers\SalesTypeController::class, 'destroy']);
//Setting
Route::resource('settings', '\App\Http\Controllers\SettingController');
//Payment
Route::post('payments/show', [\App\Http\Controllers\PaymentController::class, 'show']);
Route::resource('payments', '\App\Http\Controllers\PaymentController');
