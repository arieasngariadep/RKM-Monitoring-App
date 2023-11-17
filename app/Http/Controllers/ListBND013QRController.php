<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use Illuminate\Support\Facades\DB;
use App\Models\BND013QRModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SearchBulkQRImport;
use App\Exports\QR\ReportSearchQRExport;
use App\Exports\QR\ReportSearchBulkQRExport;

class ListBND013QRController extends Controller
{
    public function getListBND013QR(Request $request)
    {
        $alert = $request->session()->get('alert');
        $alertSuccess = $request->session()->get('alertSuccess');
        $alertInfo = $request->session()->get('alertInfo');
        if($alertSuccess){
            $showalert = Alerts::alertSuccess($alertSuccess);
        }else if($alertInfo){
            $showalert = Alerts::alertinfo($alertInfo);
        }else{
            $showalert = Alerts::alertDanger($alert);
        }

        $txn_dte = $request->txn_dte;
        $report_dte = $request->report_dte;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $rrn = $request->rrn;
        $description = $request->description;

        $listBnd = BND013QRModel::getListBND013QR($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $rrn, $description);
        $data = array(
            'listBnd' => $listBnd,
            'txn_dte' => $txn_dte,
            'report_dte' => $report_dte,
            'merch_id' => $merch_id,
            'card_nbr' => $card_nbr,
            'auth_cd' => $auth_cd,
            'rrn' => $rrn,
            'description' => $description,
            'alert' => $showalert,
        );

        return view('page.QR.listBND013QR', $data);
    }

    public function prosesUploadSearchBulkBnd013Qr(Request $request)
    {
        $userId = $request->session()->get('userId');

        DB::statement('drop table if exists data_bulk_qr_'.$userId.', result_searchbulk_qr_'.$userId.'');
        DB::statement('create table data_bulk_qr_'.$userId.' 
            (
                txn_dte date,
                report_dte date,
                merch_id varchar(50),
                card_nbr varchar(50),
                auth_cd varchar(50),
                rrn varchar(50),
                description varchar(50),
                amount varchar(50)
            ) engine myisam');

        $file_import = $request->file('file_import');
        $nama_file_import = 'data_bulk_qr_'.$userId.''.'.'.$file_import->getClientOriginalExtension();
        $file_import->move(\base_path() ."/public/Import/QR", $nama_file_import);

        Excel::import(new SearchBulkQRImport($userId), public_path("/Import/QR/".$nama_file_import));
        DB::statement('alter table data_bulk_qr_'.$userId.' add column no int auto_increment primary key first');
        DB::statement('alter table data_bulk_qr_'.$userId.' convert to character set utf8mb4 collate utf8mb4_unicode_ci');
        unlink(public_path("Import/QR/$nama_file_import"));

        DB::statement('create table result_searchbulk_qr_'.$userId.' like bnd013qr');
        $subquery1 = DB::table('data_bulk_qr_'.$userId.'')->select('txn_dte');
        $subquery2 = DB::table('data_bulk_qr_'.$userId.'')->select('report_dte');
        $subquery3 = DB::table('data_bulk_qr_'.$userId.'')->select('merch_id');
        $subquery4 = DB::table('data_bulk_qr_'.$userId.'')->select('card_nbr');
        $subquery5 = DB::table('data_bulk_qr_'.$userId.'')->select('auth_cd');
        $subquery6 = DB::table('data_bulk_qr_'.$userId.'')->select('rrn');
        $subquery7 = DB::table('data_bulk_qr_'.$userId.'')->select('description');
        $subquery8 = DB::table('data_bulk_qr_'.$userId.'')->select('amount');

        $query = BND013QRModel::select('*');

        if(in_array('txn_dte', $request->kolom))
        {
            $query->whereIn('txn_dte', $subquery1);
        }

        if(in_array('report_dte', $request->kolom))
        {
            $query->whereIn('report_dte', $subquery2);
        }

        if(in_array('merch_id', $request->kolom))
        {
            $query->whereIn('merch_id', $subquery3);
        }

        if(in_array('card_nbr', $request->kolom))
        {
            $query->whereIn('card_nbr', $subquery4);
        }

        if(in_array('auth_cd', $request->kolom))
        {
            $query->whereIn('auth_cd', $subquery5);
        } 

        if(in_array('rrn', $request->kolom))
        {
            $query->whereIn('rrn', $subquery6);
        }

        if(in_array('description', $request->kolom))
        {
            $query->whereIn('description', $subquery7);
        }
        if(in_array('amount', $request->kolom))
        {
            $query->whereIn('amount', $subquery8);
        }

        $bindings = $query->getBindings();
        $insertQuery = 'INSERT into result_searchbulk_qr_'.$userId.' '.$query->toSql();
        DB::insert($insertQuery, $bindings);

        return redirect('BND013QR/listResult/'.$userId.'')->with('alertSuccess', 'Data Berhasil Dicari');
    }

    public function getListResultBND013QR(Request $request)
    {
        $alert = $request->session()->get('alert');
        $alertSuccess = $request->session()->get('alertSuccess');
        $alertInfo = $request->session()->get('alertInfo');
        if($alertSuccess){
            $showalert = Alerts::alertSuccess($alertSuccess);
        }else if($alertInfo){
            $showalert = Alerts::alertinfo($alertInfo);
        }else{
            $showalert = Alerts::alertDanger($alert);
        }

        $userId = $request->session()->get('userId');
        $txn_dte = $request->txn_dte;
        $report_dte = $request->report_dte;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $rrn = $request->rrn;
        $description = $request->description;
        $amount = $request->amount;

        $listBnd = DB::table('result_searchbulk_qr_'.$userId.'')->paginate(5);
        $listBnd->appends($request->all());

        $data = array(
            'listBnd' => $listBnd,
            'txn_dte' => $txn_dte,
            'report_dte' => $report_dte,
            'merch_id' => $merch_id,
            'card_nbr' => $card_nbr,
            'auth_cd' => $auth_cd,
            'rrn' => $rrn,
            'description' => $description,
            'amount' => $amount,
            'alert' => $showalert,
        );

        return view('page.QR.listResultBND013QR', $data);
    }
    
    public function prosesExportReportSearchBND013QR(Request $request)
    {
        $txn_dte = $request->txn_dte;
        $report_dte = $request->report_dte;
        $jenis = $request->jenis;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $rrn = $request->rrn;
        $description = $request->description;

        return Excel::download(new ReportSearchQRExport($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $rrn, $description), "Report BND013QR.xlsx");
    }
    
    public function prosesExportReportSearchBulkBND013QR(Request $request)
    {
        $userId = $request->session()->get('userId');
        return Excel::download(new ReportSearchBulkQrExport($userId), "Report BND013QR.xlsx");
    }

    public function prosesDeleteBnd013Qr(Request $request)
    {
        $txn_dte = $request->txn_dte;
        $report_dte = $request->report_dte;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $rrn = $request->rrn;
        $description = $request->description;

        BND013QRModel::deleteListBND013QR($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $rrn, $description);
        return redirect()->back()->with('alertSuccess', 'Data Berhasil Di Hapus');
    }
}
