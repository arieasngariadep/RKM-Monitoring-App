<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Alerts;
use App\Imports\KartuKreditImport;
use App\Imports\SearchBulkKKImport;
use App\Models\KartuKreditModel;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use App\Exports\KartuKredit\ReportSearchKKExport;
use App\Exports\KartuKredit\ReportSearchBulkKKExport;

class KartuKreditController extends Controller
{
    public function getlistKartuKredit(Request $request)
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

        $txn_date = $request->txn_date;
        $start_proc_date = $request->start_proc_date;
        $end_proc_date = $request->end_proc_date;
        $mid = $request->mid;
        $cardnum = $request->cardnum;
        $auth = $request->auth;
        $amount = $request->amount;
        $report_name = $request->report_name;

        $listKK = KartuKreditModel::getListKartuKredit($txn_date, $start_proc_date, $end_proc_date, $mid, $cardnum, $auth, $amount, $report_name);

        $passing = array(
            'alert' => $showalert,
            'txn_date' => $txn_date,
            'start_proc_date' => $start_proc_date,
            'end_proc_date' => $end_proc_date,
            'mid' => $mid,
            'cardnum' => $cardnum,
            'auth' => $auth,
            'amount' => $amount,
            'report_name' => $report_name,
            'listKK' => $listKK,
        );
    
        return view('page/KartuKredit/listKartuKredit', $passing);
    }


    public function prosesUploadSearchBulkKK(Request $request)
    {
        $userId = $request->session()->get('userId');

        DB::statement('drop table if exists data_bulk_kk_'.$userId.', result_searchbulk_kk_'.$userId.'');
        DB::statement('create table data_bulk_kk_'.$userId.' 
            (
                txn_date date,
                proc_date date,
                mid varchar(50),
                cardnum varchar(50),
                report_name varchar(50),
                report_type varchar(50),
                amount varchar(50),
                disc_amount varchar(50),
                net_amount varchar(50),
                auth varchar(50),
                rate varchar(50),
                namaRek varchar(50),
                noRek varchar(50),
                mname varchar(50),
                bankName varchar(50)
            ) engine myisam');

        $file_import = $request->file('file_import');
        $nama_file_import = 'data_bulk_kk_'.$userId.''.'.'.$file_import->getClientOriginalExtension();
        $file_import->move(\base_path() ."/public/Import/KartuKredit", $nama_file_import);

        Excel::import(new SearchBulkKKImport($userId), public_path("/Import/KartuKredit/".$nama_file_import));
        DB::statement('alter table data_bulk_kk_'.$userId.' add column no int auto_increment primary key first');
        DB::statement('alter table data_bulk_kk_'.$userId.' convert to character set utf8mb4 collate utf8mb4_unicode_ci');
        unlink(public_path("Import/KartuKredit/$nama_file_import"));

        DB::statement('create table result_searchbulk_kk_'.$userId.' like kartukredit');
        $subquery1 = DB::table('data_bulk_kk_'.$userId.'')->select('txn_date');
        $subquery2 = DB::table('data_bulk_kk_'.$userId.'')->select('proc_date');
        $subquery3 = DB::table('data_bulk_kk_'.$userId.'')->select('mid');
        $subquery4 = DB::table('data_bulk_kk_'.$userId.'')->select('cardnum');
        $subquery5 = DB::table('data_bulk_kk_'.$userId.'')->select('report_name');
        $subquery6 = DB::table('data_bulk_kk_'.$userId.'')->select('report_type');
        $subquery7 = DB::table('data_bulk_kk_'.$userId.'')->select('amount');
        $subquery8 = DB::table('data_bulk_kk_'.$userId.'')->select('disc_amount');
        $subquery9 = DB::table('data_bulk_kk_'.$userId.'')->select('net_amount');
        $subquery10 = DB::table('data_bulk_kk_'.$userId.'')->select('auth');
        $subquery11 = DB::table('data_bulk_kk_'.$userId.'')->select('rate');
        $subquery12 = DB::table('data_bulk_kk_'.$userId.'')->select('namaRek');
        $subquery13 = DB::table('data_bulk_kk_'.$userId.'')->select('noRek');
        $subquery14 = DB::table('data_bulk_kk_'.$userId.'')->select('mname');
        $subquery15 = DB::table('data_bulk_kk_'.$userId.'')->select('bankName');

        $query = KartuKreditModel::select('*');

        if(in_array('txn_date', $request->kolom))
        {
            $query->whereIn('txn_date', $subquery1);
        }

        if(in_array('proc_date', $request->kolom))
        {
            $query->whereIn('proc_date', $subquery2);
        }

        if(in_array('mid', $request->kolom))
        {
            $query->whereIn('mid', $subquery3);
        }

        if(in_array('cardnum', $request->kolom))
        {
            $query->whereIn('cardnum', $subquery4);
        }

        if(in_array('report_name', $request->kolom))
        {
            $query->whereIn('report_name', $subquery5);
        }

        if(in_array('report_type', $request->kolom))
        {
            $query->whereIn('report_type', $subquery6);
        }
        if(in_array('amount', $request->kolom))
        {
            $query->whereIn('amount', $subquery7);
        }
        if(in_array('disc_amount', $request->kolom))
        {
            $query->whereIn('disc_amount', $subquery8);
        }
        if(in_array('net_amount', $request->kolom))
        {
            $query->whereIn('net_amount', $subquery9);
        }
        if(in_array('auth', $request->kolom))
        {
            $query->whereIn('auth', $subquery10);
        }
        if(in_array('rate', $request->kolom))
        {
            $query->whereIn('rate', $subquery11);
        }
        if(in_array('namaRek', $request->kolom))
        {
            $query->whereIn('namaRek', $subquery12);
        }
        if(in_array('noRek', $request->kolom))
        {
            $query->whereIn('noRek', $subquery13);
        }
        if(in_array('mname', $request->kolom))
        {
            $query->whereIn('mname', $subquery14);
        }
        if(in_array('bankName', $request->kolom))
        {
            $query->whereIn('bankName', $subquery15);
        }

        $bindings = $query->getBindings();
        $insertQuery = 'INSERT into result_searchbulk_kk_'.$userId.' '.$query->toSql();
        DB::insert($insertQuery, $bindings);

        return redirect('KartuKredit/listResultKK/'.$userId.'')->with('alertSuccess', 'Data Berhasil Dicari');
    }

    public function getListResultKK(Request $request)
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

        $start_proc_date = $request->start_proc_date;
        $end_proc_date = $request->end_proc_date;
        $userId = $request->session()->get('userId');
        $txn_date = $request->txn_date;
        $proc_date = $request->proc_date;
        $mid = $request->mid;
        $cardnum = $request->cardnum;
        $auth = $request->auth;
        $amount = $request->amount;
        $report_name = $request->report_name;

        $listKK = DB::table('result_searchbulk_kk_'.$userId.'')->paginate(5);
        $listKK->appends($request->all());

        $data = array(
            'alert' => $showalert,
            'txn_date' => $txn_date,
            'start_proc_date' => $start_proc_date,
            'end_proc_date' => $end_proc_date,
            'proc_date' => $proc_date,
            'mid' => $mid,
            'cardnum' => $cardnum,
            'auth' => $auth,
            'amount' => $amount,
            'report_name' => $report_name,
            'listKK' => $listKK,
        );

        return view('page.KartuKredit.listResultKK', $data);
    }

    public function prosesExportReportSearchKK(Request $request)
    {
        $txn_date = $request->txn_date;
        $start_proc_date = $request->start_proc_date;
        $end_proc_date = $request->end_proc_date;
        $mid = $request->mid;
        $cardnum = $request->cardnum;
        $auth = $request->auth;
        $amount = $request->amount;
        $report_name = $request->report_name;

        return Excel::download(new ReportSearchKKExport($txn_date, $start_proc_date, $end_proc_date, $mid, $cardnum, $auth, $amount, $report_name), "Report KartuKredit.xlsx");
    }
    
    public function prosesExportReportSearchBulkKK(Request $request)
    {
        $userId = $request->session()->get('userId');
        return Excel::download(new ReportSearchBulkKKExport($userId), "Report KartuKredit.xlsx");
    }
 
    public function prosesDeleteKK(Request $request)
    {
        $txn_date = $request->txn_date;
        $start_proc_date = $request->start_proc_date;
        $end_proc_date = $request->end_proc_date;
        $mid = $request->mid;
        $cardnum = $request->cardnum;
        $auth = $request->auth;
        $amount = $request->amount;
        $report_name = $request->report_name;

        KartuKreditModel::deleteListKK($txn_date, $start_proc_date, $end_proc_date, $mid, $cardnum, $auth, $amount, $report_name);
        return redirect()->back()->with('alertSuccess', 'Data Berhasil Di Hapus');
    }

}
