<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use App\Models\DuplicateModel;
use App\Imports\DuplicateImport;
use App\Exports\Duplicate\DuplicateExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DuplicateController extends Controller
{
    public function formCekDuplicate(Request $request)
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

        $passing = array(
            'alert' => $showalert,
        );   
        return view('page.Duplicate.formUpload', $passing);
    }

    public function prosesUploadDuplicate(Request $request)
    {
        $userId = $request->session()->get('userId');
        foreach ($request->file('file_import') as $file_import) {
            $nama_file_import = $file_import->getClientOriginalName();
            $file_import->move(\base_path() ."/public/Import/folder_$userId/Duplicate", $nama_file_import);
        }

        $process1 = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Python\Duplicate && python convert_csv_to_txt.py '.$userId.'');
        $process1->setTimeout(3600);
        $process1->run();

        foreach ($request->file('file_import') as $file_import) {
            $nama_file_import = $file_import->getClientOriginalName();
            unlink(base_path('public/Import/folder_'.$userId.'/Duplicate/'.$nama_file_import.''));
        }

        $process2 = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Import\folder_'.$userId.'\Duplicate && copy *.txt hasil_gabung_'.$userId.'.txt');
        $process2->setTimeout(3600);
        $process2->run();

        $process3 = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Python\Duplicate && python excel.py '.$userId.'');
        $process3->setTimeout(3600);
        $process3->run();

        $process4 = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Import\folder_'.$userId.'\Duplicate && del *.txt');
        $process4->setTimeout(3600);
        $process4->run();

        DB::statement('drop table if exists duplicate_'.$userId.'');
        DB::statement('create table duplicate_'.$userId.' (
            orderId varchar(20),
            last_updated_time varchar(50),
            initiation_time varchar(50),
            status varchar(50),
            reason_type varchar(50),
            transaction_amount varchar(50),
            mdr varchar(50),
            nett_amount varchar(50),
            organization_name varchar(200),
            organization_shortcode varchar(150),
            partner_merchant_id varchar(50),
            merchant_trx_id varchar(50),
            matchingkey varchar(50)
        ) engine myisam');
        DB::statement('alter table duplicate_'.$userId.' add index(orderId, transaction_amount, matchingkey)');
        Excel::import(new DuplicateImport($userId), public_path("/Import/folder_$userId/Duplicate/Output.xlsx"));
        DB::statement('alter table duplicate_'.$userId.' add column id int auto_increment primary key first');
        DB::statement('alter table duplicate_'.$userId.' convert to character set utf8mb4 collate utf8mb4_unicode_ci');
        unlink(base_path('public/Import/folder_'.$userId.'/Duplicate/Output.xlsx'));

        return redirect('Duplicate/list')->with('alertSuccess', 'Silahkan Periksa Data Duplicate');
    }

    public function getListCekDuplicate(Request $request)
    {
        $userId = $request->session()->get('userId');
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

        $duplicate = DuplicateModel::getDataCekDuplicate($userId);
        $linkAja = DuplicateModel::cekDataLinkAja($userId);

        $passing = array(
            'alert' => $showalert,
            'duplicate' => $duplicate,
            'linkAja' => $linkAja,
        );   
        return view('page.Duplicate.list', $passing);
    }

    public function prosesExportReportDuplicate(Request $request)
    {
        $userId = $request->session()->get('userId');
        return Excel::download(new DuplicateExport($userId), "Report Cek Duplicate.xlsx");
    }
}
