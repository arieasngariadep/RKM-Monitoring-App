<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ListBND013LController;
use App\Http\Controllers\ListBND013QRController;
use App\Http\Controllers\ListBND01QAController;
use App\Http\Controllers\ListBND01QANewController;
use App\Http\Controllers\KartuKreditController;
use App\Http\Controllers\TapCashController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportsTypeController;
use App\Http\Controllers\DuplicateController;
use App\Http\Controllers\CekReportController;

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

// ================ Authentication Routing ================ //
Route::get('login', [AuthenticationController::class, 'loginPage'])->name('login');

Route::post('/loginProcess', [AuthenticationController::class, 'loginProcess'])->name('loginProcess');
Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout')->middleware('checkauth');
Route::post('/prosesChangePassword', [AuthenticationController::class, 'prosesChangePassword'])->name('prosesChangePassword');

// ================ Dashboard Routing ================ //
Route::get('dashboard', [DashboardController::class, 'dashboardApp'])->name('dashboard')->middleware('checkauth');

// ================ Upload Data Routing ================ //
Route::get('formUploadBND013', [UploadController::class, 'formUploadBND013'])->name('formUploadBND013')->middleware('checkauth');
Route::get('formUploadPaymentReject', [UploadController::class, 'formUploadKKTC'])->name('formUploadKKTC')->middleware('checkauth');
Route::post('prosesUploadData', [UploadController::class, 'prosesUploadData'])->name('prosesUploadData')->middleware('checkauth');
Route::post('prosesUploadDataKKTC', [UploadController::class, 'prosesUploadDataKKTC'])->name('prosesUploadDataKKTC')->middleware('checkauth');

// ================ List BND013 Routing ================ //
Route::prefix('BND013QR')->group(function(){
    Route::get('/list', [ListBND013QRController::class, 'getListBND013QR'])->name('getListBND013QR')->middleware('checkauth');
    Route::get('listResult/{userId}', [ListBND013QRController::class, 'getListResultBND013QR'])->name('getListResultBND013QR')->middleware('checkauth');

    Route::post('prosesUploadSearchBulk', [ListBND013QRController::class, 'prosesUploadSearchBulkBnd013Qr'])->name('prosesUploadSearchBulkBnd013Qr')->middleware('checkauth');
    Route::post('/prosesExportReportSearch', [ListBND013QRController::class, 'prosesExportReportSearchBND013QR'])->name('prosesExportReportSearchBND013QR');
    Route::post('/prosesExportReportSearchBulk', [ListBND013QRController::class, 'prosesExportReportSearchBulkBND013QR'])->name('prosesExportReportSearchBulkBND013QR');
    Route::delete('/prosesDeleteBnd013Qr', [ListBND013QRController::class, 'prosesDeleteBnd013Qr'])->name('prosesDeleteBnd013Qr')->middleware('checkauth');
});

Route::prefix('BND013L')->group(function(){
    Route::get('/list', [ListBND013LController::class, 'getListBND013L'])->name('getListBND013L')->middleware('checkauth');
    Route::get('listResult/{userId}', [ListBND013LController::class, 'getListResultBND013L'])->name('getListResultBND013L')->middleware('checkauth');

    Route::post('prosesUploadSearchBulk', [ListBND013LController::class, 'prosesUploadSearchBulkBnd013L'])->name('prosesUploadSearchBulkBnd013L')->middleware('checkauth'); 
    Route::post('/prosesExportReportSearch', [ListBND013LController::class, 'prosesExportReportSearchBND013L'])->name('prosesExportReportSearchBND013L');
    Route::post('/prosesExportReportSearchBulk', [ListBND013LController::class, 'prosesExportReportSearchBulkBND013L'])->name('prosesExportReportSearchBulkBND013L');
    Route::delete('/prosesDeleteBnd013L', [ListBND013LController::class, 'prosesDeleteBnd013L'])->name('prosesDeleteBnd013L')->middleware('checkauth');
});

Route::prefix('BND01QA')->group(function(){
    Route::get('/listBND01QA', [ListBND01QAController::class, 'getListBND01QA'])->name('getListBND01QA')->middleware('checkauth');
    Route::get('listResult/{userId}', [ListBND01QAController::class, 'getListResultBND01QA'])->name('getListResultBND01QA')->middleware('checkauth');

    Route::post('prosesUploadSearchBulk', [ListBND01QAController::class, 'prosesUploadSearchBulkBnd01QA'])->name('prosesUploadSearchBulkBnd01QA')->middleware('checkauth');
    Route::post('/prosesExportReportSearch', [ListBND01QAController::class, 'prosesExportReportSearchBND01QA'])->name('prosesExportReportSearchBND01QA');
    Route::post('/prosesExportReportSearchBulk', [ListBND01QAController::class, 'prosesExportReportSearchBulkBND01QA'])->name('prosesExportReportSearchBulkBND01QA');
    Route::delete('/prosesDeleteBnd01QA', [ListBND01QAController::class, 'prosesDeleteBnd01QA'])->name('prosesDeleteBnd01QA')->middleware('checkauth');
    Route::get('formUploadBND01QA', [ListBND01QAController::class, 'formUploadBND01QA'])->name('formUploadBND01QA')->middleware('checkauth');
    Route::post('prosesUploadQA', [ListBND01QAController::class, 'prosesUploadQA'])->name('prosesUploadQA')->middleware('checkauth');
});

Route::prefix('BND01QANew')->group(function(){
    Route::get('/listBND01QANew', [ListBND01QANewController::class, 'getListBND01QANew'])->name('getListBND01QANew')->middleware('checkauth');
    Route::get('listResult/{userId}', [ListBND01QANewController::class, 'getListResultBND01QANew'])->name('getListResultBND01QANew')->middleware('checkauth');

    Route::post('prosesUploadSearchBulkNew', [ListBND01QANewController::class, 'prosesUploadSearchBulkBnd01QANew'])->name('prosesUploadSearchBulkBnd01QANew')->middleware('checkauth');
    Route::post('/prosesExportReportSearchNew', [ListBND01QANewController::class, 'prosesExportReportSearchBND01QANew'])->name('prosesExportReportSearchBND01QANew');
    Route::post('/prosesExportReportSearchBulkNew', [ListBND01QANewController::class, 'prosesExportReportSearchBulkBND01QANew'])->name('prosesExportReportSearchBulkBND01QANew');
    Route::delete('/prosesDeleteBnd01QANew', [ListBND01QANewController::class, 'prosesDeleteBnd01QANew'])->name('prosesDeleteBnd01QANew')->middleware('checkauth');
    Route::get('formUploadBND01QANew', [ListBND01QANewController::class, 'formUploadBND01QANew'])->name('formUploadBND01QANew')->middleware('checkauth');
    Route::post('prosesUploadQANew', [ListBND01QANewController::class, 'prosesUploadQANew'])->name('prosesUploadQANew')->middleware('checkauth');
});

Route::prefix('Duplicate')->group(function(){
    Route::get('/formUpload', [DuplicateController::class, 'formCekDuplicate'])->name('formCekDuplicate')->middleware('checkauth');
    Route::get('list', [DuplicateController::class, 'getListCekDuplicate'])->name('getListCekDuplicate')->middleware('checkauth');

    Route::post('prosesUploadDuplicate', [DuplicateController::class, 'prosesUploadDuplicate'])->name('prosesUploadDuplicate')->middleware('checkauth'); 
    Route::post('prosesExportReportDuplicate', [DuplicateController::class, 'prosesExportReportDuplicate'])->name('prosesExportReportDuplicate')->middleware('checkauth');
});

// ================ Cek Report Routing ================ //
    Route::get('reportCek',[CekReportController::class,'getReportItem'])->name('getReportItem')->middleware('checkauth');

// ================ Download Report Routing ================ //
Route::get('downloadReport', [ReportController::class, 'downloadReportPage'])->name('downloadReportPage')->middleware('checkauth');
Route::delete('/prosesDeleteDataReport', [ReportController::class, 'deleteDataReport'])->name('deleteDataReport');
Route::post('/prosesExportReport', [ReportController::class, 'prosesExportReport'])->name('prosesExportReport');

// ================ User Routing ================ //
Route::prefix('user')->group(function(){
    Route::get('/', [UserController::class, 'getAllUser'])->name('getAllUser')->middleware('checkauth');
    Route::get('/add-new-user', [UserController::class, 'formAddUser'])->name('formAddUser')->middleware('checkauth');
    Route::get('/update-user/{id}', [UserController::class, 'formUpdateUser'])->name('formUpdateUser')->middleware('checkauth');

    Route::post('proses_tambah_user', [UserController::class, 'prosesAddUser'])->name('prosesAddUser');
    Route::post('proses_update_user', [UserController::class, 'prosesUpdateUser'])->name('prosesUpdateUser');
    Route::get('proses_delete_user/{id}', [UserController::class, 'deleteUser'])->name('deleteUser');
    Route::post('check_email_exists', [UserController::class, 'checkEmailExists'])->name('checkEmailExists');
});

Route::prefix('KartuKredit')->group(function(){
    Route::get('/listBNDpayment', [KartuKreditController::class, 'getListKartuKredit'])->name('getListKartuKredit')->middleware('checkauth');
    Route::get('listResultKK/{userId}', [KartuKreditController::class, 'getListResultKK'])->name('getListResultKK')->middleware('checkauth');
    Route::post('prosesUploadSearchBulkKK', [KartuKreditController::class, 'prosesUploadSearchBulkKK'])->name('prosesUploadSearchBulkKK')->middleware('checkauth');
    Route::post('/prosesExportReportSearchKK', [KartuKreditController::class, 'prosesExportReportSearchKK'])->name('prosesExportReportSearchKK');
    Route::post('/prosesExportReportSearchBulkKK', [KartuKreditController::class, 'prosesExportReportSearchBulkKK'])->name('prosesExportReportSearchBulkKK');
    Route::delete('/prosesDeleteKK', [KartuKreditController::class, 'prosesDeleteKK'])->name('prosesDeleteKK')->middleware('checkauth');
});


Route::prefix('TapCash')->group(function(){
    Route::get('/listBNDreject', [TapCashController::class, 'getListTapCash'])->name('getListTapCash')->middleware('checkauth');
    Route::get('listResultTC/{userId}', [TapCashController::class, 'getListResultTC'])->name('getListResultTC')->middleware('checkauth');
    Route::post('prosesUploadSearchBulkTC', [TapCashController::class, 'prosesUploadSearchBulkTC'])->name('prosesUploadSearchBulkTC')->middleware('checkauth');
    Route::post('/prosesExportReportSearchTC', [TapCashController::class, 'prosesExportReportSearchTC'])->name('prosesExportReportSearchTC');
    Route::post('/prosesExportReportSearchBulkTC', [TapCashController::class, 'prosesExportReportSearchBulkTC'])->name('prosesExportReportSearchBulkTC');
    Route::delete('/prosesDeleteTC', [TapCashController::class, 'prosesDeleteTC'])->name('prosesDeleteTC')->middleware('checkauth');
});
