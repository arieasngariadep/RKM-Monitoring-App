<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use Illuminate\Support\Facades\DB;
use App\Models\BND013LModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SearchBulkLinkAjaImport;
use App\Exports\LinkAja\ReportSearchLinkAjaExport;
use App\Exports\LinkAja\ReportSearchBulkLinkAjaExport;

class ListBND013LController extends Controller
{
    public function getListBND013L(Request $request)
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
        $description = $request->description;
        $amount = $request->amount;

        $listBnd = BND013LModel::getListBnd013L($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $description, $amount);
        $data = array(
            'listBnd' => $listBnd,
            'txn_dte' => $txn_dte,
            'report_dte' => $report_dte,
            'merch_id' => $merch_id,
            'card_nbr' => $card_nbr,
            'auth_cd' => $auth_cd,
            'description' => $description,
            'amount' => $amount,
            'alert' => $showalert,
        );

        return view('page.LinkAja.listBND013L', $data);
    }

    public function prosesUploadSearchBulkBnd013L(Request $request)
    {
        $userId = $request->session()->get('userId');

        DB::statement('drop table if exists data_bulk_linkaja_'.$userId.', result_searchbulk_linkaja_'.$userId.'');
        DB::statement('create table data_bulk_linkaja_'.$userId.' 
            (
                txn_dte date,
                report_dte date,
                merch_id varchar(50),
                card_nbr varchar(50),
                auth_cd varchar(50),
                description varchar(50)
            ) engine myisam');

        $file_import = $request->file('file_import');
        $nama_file_import = 'data_bulk_linkaja_'.$userId.''.'.'.$file_import->getClientOriginalExtension();
        $file_import->move(\base_path() ."/public/Import/LinkAja", $nama_file_import);

        Excel::import(new SearchBulkLinkAjaImport($userId), public_path("/Import/LinkAja/".$nama_file_import));
        DB::statement('alter table data_bulk_linkaja_'.$userId.' add column no int auto_increment primary key first');
        DB::statement('alter table data_bulk_linkaja_'.$userId.' convert to character set utf8mb4 collate utf8mb4_unicode_ci');
        unlink(public_path("Import/LinkAja/$nama_file_import"));

        DB::statement('create table result_searchbulk_linkaja_'.$userId.' like BND013L');
        $subquery1 = DB::table('data_bulk_linkaja_'.$userId.'')->select('txn_dte');
        $subquery2 = DB::table('data_bulk_linkaja_'.$userId.'')->select('report_dte');
        $subquery3 = DB::table('data_bulk_linkaja_'.$userId.'')->select('merch_id');
        $subquery4 = DB::table('data_bulk_linkaja_'.$userId.'')->select('card_nbr');
        $subquery5 = DB::table('data_bulk_linkaja_'.$userId.'')->select('auth_cd');
        $subquery6 = DB::table('data_bulk_linkaja_'.$userId.'')->select('description');

        $query = BND013LModel::select('*');

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

        if(in_array('description', $request->kolom))
        {
            $query->whereIn('description', $subquery6);
        }

        $bindings = $query->getBindings();
        $insertQuery = 'INSERT into result_searchbulk_linkaja_'.$userId.' '.$query->toSql();
        DB::insert($insertQuery, $bindings);

        return redirect('BND013L/listResult/'.$userId.'')->with('alertSuccess', 'Data Berhasil Dicari');
    }

    public function getListResultBND013L(Request $request)
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
        $description = $request->description;
        $amount = $request->amount;

        $listBnd = DB::table('result_searchbulk_linkaja_'.$userId.'')->paginate(5);
        $listBnd->appends($request->all());

        $data = array(
            'listBnd' => $listBnd,
            'txn_dte' => $txn_dte,
            'report_dte' => $report_dte,
            'merch_id' => $merch_id,
            'card_nbr' => $card_nbr,
            'auth_cd' => $auth_cd,
            'description' => $description,
            'amount' => $amount,
            'alert' => $showalert,
        );

        return view('page.LinkAja.listResultBND013L', $data);
    }

    public function prosesExportReportSearchBND013L(Request $request)
    {
        $txn_dte = $request->txn_dte;
        $report_dte = $request->report_dte;
        $jenis = $request->jenis;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $description = $request->description;
        $amount = $request->amount;

        return Excel::download(new ReportSearchLinkAjaExport($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $description, $amount), "Report BND013L.xlsx");
    }
    
    public function prosesExportReportSearchBulkBND013L(Request $request)
    {
        $userId = $request->session()->get('userId');
        return Excel::download(new ReportSearchBulkLinkAjaExport($userId), "Report BND013L.xlsx");
    }

    public function prosesDeleteBnd013L(Request $request)
    {
        $txn_dte = $request->txn_dte;
        $report_dte = $request->report_dte;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $description = $request->description;
        $amount = $request->amount;

        BND013LModel::deleteListBnd013L($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $description, $amount);
        return redirect()->back()->with('alertSuccess', 'Data Berhasil Di Hapus');
    }
}
