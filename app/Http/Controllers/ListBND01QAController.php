<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use Illuminate\Support\Facades\DB;
use App\Models\BND01QAModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SearchBulkQAImport;
use App\Exports\Settlement\ReportSearchQAExport;
use App\Exports\Settlement\ReportSearchBulkQAExport;
use Carbon\Carbon;

class ListBND01QAController extends Controller
{
    public function getListBND01QA(Request $request)
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
        $rrn = $request->rrn;
        $description = $request->description;

        $listBnd = BND01QAModel::getListBND01QA($txn_dte, $report_dte, $merch_id, $card_nbr, $rrn, $description);
        $data = array(
            'listBnd' => $listBnd,
            'txn_dte' => $txn_dte,
            'report_dte' => $report_dte,
            'merch_id' => $merch_id,
            'card_nbr' => $card_nbr,
            'rrn' => $rrn,
            'description' => $description,
            'alert' => $showalert,
        );

        return view('page.QA.listBND01QA', $data);
    }

    public function prosesUploadSearchBulkBnd01Qa(Request $request)
    {
        $userId = $request->session()->get('userId');

        DB::statement('drop table if exists data_bulk_qa_'.$userId.', result_searchbulk_qa_'.$userId.'');
        DB::statement('create table data_bulk_qa_'.$userId.' 
            (
                txn_dte date,
                report_dte date,
                merch_id varchar(50),
                card_nbr varchar(50),
                rrn varchar(50),
                description varchar(50),
                amount varchar(50)
            ) engine myisam');

        $file_import = $request->file('file_import');
        $nama_file_import = 'data_bulk_qa_'.$userId.''.'.'.$file_import->getClientOriginalExtension();
        $file_import->move(\base_path() ."/public/Import/QA", $nama_file_import);

        Excel::import(new SearchBulkQAImport($userId), public_path("/Import/QA/".$nama_file_import));
        DB::statement('alter table data_bulk_qa_'.$userId.' add column no int auto_increment primary key first');
        DB::statement('alter table data_bulk_qa_'.$userId.' convert to character set utf8mb4 collate utf8mb4_unicode_ci');
        unlink(public_path("Import/QA/$nama_file_import"));

        DB::statement('create table result_searchbulk_qa_'.$userId.' like bnd01qa');
        $subquery1 = DB::table('data_bulk_qa_'.$userId.'')->select('txn_dte');
        $subquery2 = DB::table('data_bulk_qa_'.$userId.'')->select('report_dte');
        $subquery3 = DB::table('data_bulk_qa_'.$userId.'')->select('merch_id');
        $subquery4 = DB::table('data_bulk_qa_'.$userId.'')->select('card_nbr');
        $subquery6 = DB::table('data_bulk_qa_'.$userId.'')->select('rrn');
        $subquery7 = DB::table('data_bulk_qa_'.$userId.'')->select('description');
        $subquery8 = DB::table('data_bulk_qa_'.$userId.'')->select('amount');

        $query = BND01QAModel::select('*');

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
        $insertQuery = 'INSERT into result_searchbulk_qa_'.$userId.' '.$query->toSql();
        DB::insert($insertQuery, $bindings);

        return redirect('BND01QA/listResult/'.$userId.'')->with('alertSuccess', 'Data Berhasil Dicari');
    }

    public function getListResultBND01QA(Request $request)
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
        $rrn = $request->rrn;
        $description = $request->description;
        $amount = $request->amount;

        $listBnd = DB::table('result_searchbulk_qa_'.$userId.'')->paginate(5);
        $listBnd->appends($request->all());

        $data = array(
            'listBnd' => $listBnd,
            'txn_dte' => $txn_dte,
            'report_dte' => $report_dte,
            'merch_id' => $merch_id,
            'card_nbr' => $card_nbr,
            'rrn' => $rrn,
            'description' => $description,
            'amount' => $amount,
            'alert' => $showalert,
        );

        return view('page.QA.listResultBND01QA', $data);
    }
    
    public function prosesExportReportSearchBND01QA(Request $request)
    {
        $txn_dte = $request->txn_dte;
        $report_dte = $request->report_dte;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $rrn = $request->rrn;
        $description = $request->description;

        return Excel::download(new ReportSearchQAExport($txn_dte, $report_dte, $merch_id, $card_nbr, $rrn, $description), "Report BND01QA.xlsx");
    }
    
    public function prosesExportReportSearchBulkBND01QA(Request $request)
    {
        $userId = $request->session()->get('userId');
        return Excel::download(new ReportSearchBulkQAExport($userId), "Report BND01QA.xlsx");
    }

    public function prosesDeleteBnd01QA(Request $request)
    {
        $txn_dte = $request->txn_dte;
        $report_dte = $request->report_dte;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $rrn = $request->rrn;
        $description = $request->description;

        BND01QAModel::deleteListBND01QA($txn_dte, $report_dte, $merch_id, $card_nbr, $rrn, $description);
        return redirect()->back()->with('alertSuccess', 'Data Berhasil Di Hapus');
    }

    // public function formUploadBND01QA(Request $request)
    // {
    //     $alert = $request->session()->get('alert');
    //     $alertSuccess = $request->session()->get('alertSuccess');
    //     $alertInfo = $request->session()->get('alertInfo');
    //     if($alertSuccess){
    //         $showalert = Alerts::alertSuccess($alertSuccess);
    //     }else if($alertInfo){
    //         $showalert = Alerts::alertinfo($alertInfo);
    //     }else{
    //         $showalert = Alerts::alertDanger($alert);
    //     }

    //     $passing = array(
    //         'alert' => $showalert,
    //     );   
    //     return view('page.QA.formUploadQA', $passing);
    // }

    // public function prosesUploadQA(Request $request){
    //     $userId = $request->session()->get('userId');
    //     $files = $request->file('files');
    //     foreach($files as $file){
    //         $contents = file_get_contents($file);
    //         $fileName = $file->getClientOriginalName();
    //         $fileDate = substr($fileName,-12,8);
    //         $reportDate = Carbon::createFromFormat('dmY',$fileDate)->format('Y-m-d');
    //         $rows = explode(PHP_EOL, $contents);
    
                  
                    
    //                 $skipped = true;
    //                 $baris = 1;
    //                 foreach($rows as $d){
    //                     if($skipped){
    //                         $skipped = false;
    //                         continue;
    //                     }
    
    //                     if(empty($d)){
    //                         continue;
    //                     }
    
    //                     $column = explode("|",$d);
    //                     foreach($rows as $err){
    //                         $columnErr = explode("|",$err);
    //                         if(count($columnErr) < 20){
    //                             if(empty($err)){
    //                                 continue;
    //                             }
    //                             return redirect('BND01QA/formUploadBND01QA')->with('alert', 'Data Ditolak, Silahkan Mengecek Baris Ke - '.$baris.'');
    //                         }
    //                         $baris += 1;
    //                     }
                       
    //                         $txnDate = substr($column[3],0,8);
    //                         $txn_dte = Carbon::createFromFormat('Ymd',$txnDate)->format('Y-m-d');
        
                            
    //                         $bnd01qa = new BND01QAModel();
    //                         $bnd01qa->report_dte = $reportDate;
    //                         $bnd01qa->merch_id = substr($column[11],-9);
    //                         $bnd01qa->card_nbr = $column[13];
    //                         $bnd01qa->mdr = $column[7]/100;
    //                         $bnd01qa->amount = $column[6]/100;
    //                         $bnd01qa->nett_amount = $column[8]/100;
    //                         $bnd01qa->txn_dte = $txn_dte;
    //                         $bnd01qa->rrn = $column[0];
    //                         $bnd01qa->description = $column[15];
            
    //                         $bnd01qa->save();       
    //                     }
    //     }
        
    //     return redirect('BND01QA/listBND01QA')->with('alertSuccess', 'Data Berhasil Diupload');
    // }       
                    
                   


}
