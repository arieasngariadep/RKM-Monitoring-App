<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use Illuminate\Support\Facades\DB;
use App\Imports\QrisImport;
use App\Imports\LinkAjaImport;
use App\Imports\QAImport;
use App\Imports\KartuKreditImport;
use App\Imports\TapCashImport;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class UploadController extends Controller
{
    public function formUploadKKTC(Request $request){
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
        return view('page.formUploadKKTC', $passing);
    }

    public function prosesUploadDataKKTC(Request $request){
        $userId = $request->session()->get('userId');
        $reportType = $request->jenis_report;

        if($reportType == 'KK'){
            foreach ($request->file('files') as $file_import) {
                $nama_file_import = $file_import->getClientOriginalName();
                $file_import->move(\base_path() ."/public/Import/KartuKredit/folder_$userId", $nama_file_import);
            }

            $process = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Python\KartuKredit && python kartuKredit.py '.$userId.' '.$nama_file_import);
            $process->setTimeout(3600);
            $process->mustRun();
    
            Excel::import(new KartuKreditImport, public_path("/Import/KartuKredit/hasil_kartuKredit_$userId.xlsx"));
            unlink(base_path('public/Import/KartuKredit/hasil_kartuKredit_'.$userId.'.xlsx'));
    
            foreach ($request->file('files') as $file_import) {
                unlink(base_path('public/Import/KartuKredit/folder_'.$userId.'/'.$file_import->getClientOriginalName()));
            }
    
            return redirect()->back()->with('alertSuccess', 'Data Berhasil Diparsing');
        }else if($reportType == 'TC'){
            foreach ($request->file('files') as $file_import) {
                $nama_file_import = $file_import->getClientOriginalName();
                $file_import->move(\base_path() ."/public/Import/TapCash/folder_$userId", $nama_file_import);
            }
    
            $process = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Python\TapCash && python tapCash.py '.$userId.' '.$nama_file_import);
            $process->setTimeout(3600);
            $process->mustRun();
    
            Excel::import(new TapCashImport, public_path("/Import/TapCash/hasil_tapCash_$userId.xlsx"));
            unlink(base_path('public/Import/TapCash/hasil_tapCash_'.$userId.'.xlsx'));
    
            foreach ($request->file('files') as $file_import) {
                unlink(base_path('public/Import/TapCash/folder_'.$userId.'/'.$file_import->getClientOriginalName()));
            }
    
            return redirect()->back()->with('alertSuccess', 'Data Berhasil Diparsing');
        }else{
            return redirect()->back()->with('alert', 'Data Gagal Diparsing, Pilih Jenis Report');
        }
    }

    public function formUploadBND013(Request $request)
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
        return view('page.formUpload', $passing);
    }

    // public function prosesUploadData(Request $request)
    // {
    //     $userId = $request->session()->get('userId');
    //     if($request->jenis_report != NULL)
    //     {
    //         foreach ($request->file('file_import') as $file_import) {
    //             $namafile = $file_import->getClientOriginalName().'.txt';
    //             $file_import->move(\base_path() ."/public/Import/BND013/", $namafile);
    //         }
            
    //         $process = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Import\BND013 && copy *.txt bnd013_'.$userId.'.txt');
    //         $process->run();
            
    //         foreach ($request->file('file_import') as $file_import) {
    //             unlink(base_path('public/Import/BND013/'.$file_import->getClientOriginalName().'.txt'));
    //         }
            
    //         DB::statement('drop table if exists no_bnd_'.$userId.', no_nama_bnd_'.$userId.', result_bnd_'.$userId.', bnd_temp1_'.$userId.', bnd_temp2_'.$userId.', bnd_temp3_'.$userId.', bnd_temp4_'.$userId.'');
            
    //         DB::statement('create table bnd_temp1_'.$userId.' ( bnd013 varchar(255) ) engine myisam'); 
    //         $sql = 'load data infile "D:/xampp/htdocs/rkm/public/Import/BND013/bnd013_'.$userId.'.txt" into table bnd_temp1_'.$userId.''; 
    //         DB::connection()->getPdo()->exec($sql);
    //         DB::statement('alter table bnd_temp1_'.$userId.' add column no int auto_increment primary key first');
            
    //         unlink(base_path('public/Import/BND013/bnd013_'.$userId.'.txt'));
            
    //         DB::statement('create table no_nama_bnd_'.$userId.' (no bigint, nama varchar(10)) engine myisam');
    //         DB::statement('insert into no_nama_bnd_'.$userId.' select no, mid(bnd013, 7, 10) as nama from bnd_temp1_'.$userId.' where mid(bnd013, 2, 30) like "%0%" or mid(bnd013, 111, 8) like "%/%"');
            
    //         DB::statement('alter table no_nama_bnd_'.$userId.' add column no_record bigint');
    //         DB::statement('update no_nama_bnd_'.$userId.' set no_record = no');
            
    //         DB::statement('create table no_bnd_'.$userId.' (no bigint)');
    //         DB::statement('insert into no_bnd_'.$userId.' select no_record from no_nama_bnd_'.$userId.'');
            
    //         DB::statement('alter table no_bnd_'.$userId.' add index(no)');
    //         DB::statement('alter table bnd_temp1_'.$userId.' add index(no)');
            
    //         DB::statement('create table bnd_temp2_'.$userId.' like bnd_temp1_'.$userId.'');
    //         DB::statement('insert into bnd_temp2_'.$userId.' select * from bnd_temp1_'.$userId.' where no in (select no from no_bnd_'.$userId.') or mid(bnd013, 2, 30) like "%0%" or mid(bnd013, 111, 8) like "%/%" order by no');
            
    //         DB::statement('alter table no_nama_bnd_'.$userId.' add index(no_record)');
    //         DB::statement('alter table bnd_temp2_'.$userId.' add index(no)');
            
    //         DB::statement('alter table bnd_temp2_'.$userId.' add column report_dte varchar(20)');
    //         DB::statement('update bnd_temp2_'.$userId.' set report_dte = mid(bnd013, 111, 8) where no in(select no_record as no from no_nama_bnd_'.$userId.')');
            
    //         DB::statement('create table bnd_temp3_'.$userId.'(no int, report_dte varchar(20))');
    //         DB::statement('insert into bnd_temp3_'.$userId.' select no, report_dte from bnd_temp2_'.$userId.' where report_dte != ""');
    //         DB::statement('alter table bnd_temp3_'.$userId.' add index(no)');
            
    //         DB::statement('create table bnd_temp4_'.$userId.' like bnd_temp3_'.$userId.'');
    //         DB::statement('alter table bnd_temp4_'.$userId.' add index(report_dte)');
    //         DB::statement('insert into bnd_temp4_'.$userId.' select bnd_temp4_'.$userId.'.no as no, bnd_temp3_'.$userId.'.report_dte as report_dte from bnd_temp2_'.$userId.' , bnd_temp3_'.$userId.', (select bnd_temp2_'.$userId.'.no, max(bnd_temp3_'.$userId.'.no) as pair from bnd_temp2_'.$userId.', bnd_temp3_'.$userId.' where bnd_temp3_'.$userId.'.no < bnd_temp2_'.$userId.'.no and bnd_temp2_'.$userId.'.report_dte = "" group by bnd_temp2_'.$userId.'.no) bnd_temp4_'.$userId.' where bnd_temp2_'.$userId.'.no = bnd_temp4_'.$userId.'.no and bnd_temp3_'.$userId.'.no = bnd_temp4_'.$userId.'.pair');
            
    //         DB::statement('update bnd_temp2_'.$userId.', bnd_temp4_'.$userId.' set bnd_temp2_'.$userId.'.report_dte = bnd_temp4_'.$userId.'.report_dte where bnd_temp2_'.$userId.'.no = bnd_temp4_'.$userId.'.no');
            
    //         DB::statement('alter table bnd_temp2_'.$userId.' add column org varchar(50)');
    //         DB::statement('update bnd_temp2_'.$userId.' set org = mid(bnd013, 2, 4)');
            
    //         DB::statement('alter table bnd_temp2_'.$userId.' add column merch_id varchar(50)');
    //         DB::statement('update bnd_temp2_'.$userId.' set merch_id = mid(bnd013, 7, 9)');
            
    //         DB::statement('alter table bnd_temp2_'.$userId.' add column card_nbr varchar(50)');
    //         DB::statement('update bnd_temp2_'.$userId.' set card_nbr = mid(bnd013, 17, 16)');
            
    //         DB::statement('alter table bnd_temp2_'.$userId.' add column amount varchar(50)');
    //         DB::statement('update bnd_temp2_'.$userId.' set amount = mid(bnd013, 35, 11)');
            
    //         DB::statement('alter table bnd_temp2_'.$userId.' add column tc varchar(50)');
    //         DB::statement('update bnd_temp2_'.$userId.' set tc = mid(bnd013, 47, 3)');
            
    //         DB::statement('alter table bnd_temp2_'.$userId.' add column txn_dte varchar(50)');
    //         DB::statement('update bnd_temp2_'.$userId.' set txn_dte = mid(bnd013, 50, 6)');
            
    //         DB::statement('alter table bnd_temp2_'.$userId.' add column auth_cd varchar(50)');
    //         DB::statement('update bnd_temp2_'.$userId.' set auth_cd = mid(bnd013, 59, 7)');
            
    //         if($request->jenis_report == "BND013L")
    //         {
    //             DB::statement('alter table bnd_temp2_'.$userId.' add column description varchar(70)');
    //             DB::statement('update bnd_temp2_'.$userId.' set description = mid(bnd013, 66, 70)');
    //         }else{
    //             DB::statement('alter table bnd_temp2_'.$userId.' add column rrn varchar(12)');
    //             DB::statement('update bnd_temp2_'.$userId.' set rrn = mid(bnd013, 66, 12)');
                
    //             DB::statement('alter table bnd_temp2_'.$userId.' add column description varchar(19)');
    //             DB::statement('update bnd_temp2_'.$userId.' set description = mid(bnd013, 79, 19)');
    //         }

    //         if($request->jenis_report == "BND013L")
    //         {
    //             DB::statement('create table result_bnd_'.$userId.'
    //             (
    //                 jenis varchar(10),
    //                 report_dte varchar(20),
    //                 org varchar(50),
    //                 merch_id varchar(50),
    //                 card_nbr varchar(50),
    //                 amount varchar(50),
    //                 tc varchar(50),
    //                 txn_dte varchar(50),
    //                 auth_cd varchar(50),
    //                 description varchar(70)
    //             ) engine myisam');

    //             DB::statement('insert into result_bnd_'.$userId.'
    //             select
    //                 "BND013L",
    //                 report_dte as report_dte,
    //                 trim(org) as org,
    //                 trim(merch_id) as merch_id,
    //                 trim(card_nbr) as card_nbr,
    //                 trim(amount) as amount,
    //                 trim(tc) as tc,
    //                 trim(txn_dte) as txn_dte,
    //                 trim(auth_cd) as auth_cd,
    //                 trim(description) as description
    //             from bnd_temp2_'.$userId.' where auth_cd not like "%NEGARA%"');
    //         }else{
    //             DB::statement('create table result_bnd_'.$userId.'
    //             (
    //                 jenis varchar(10),
    //                 report_dte varchar(20),
    //                 org varchar(50),
    //                 merch_id varchar(50),
    //                 card_nbr varchar(50),
    //                 amount varchar(50),
    //                 tc varchar(50),
    //                 txn_dte varchar(50),
    //                 auth_cd varchar(50),
    //                 rrn varchar(12),
    //                 description varchar(19)
    //             ) engine myisam');
    //             DB::statement('insert into result_bnd_'.$userId.'
    //             select
    //                 "BND013QR",
    //                 report_dte as report_dte,
    //                 trim(org) as org,
    //                 trim(merch_id) as merch_id,
    //                 trim(card_nbr) as card_nbr,
    //                 trim(amount) as amount,
    //                 trim(tc) as tc,
    //                 trim(txn_dte) as txn_dte,
    //                 trim(auth_cd) as auth_cd,
    //                 trim(rrn) as rrn,
    //                 trim(description) as description
    //             from bnd_temp2_'.$userId.' where auth_cd not like "%NEGARA%"');
    //         }
    //         DB::statement('update result_bnd_'.$userId.' set 
    //         amount = replace(amount, ",", ""), 
    //         description = replace(description, " ", ""),
    //         description = replace(description, "\r", ""),
    //         txn_dte = concat(substr(txn_dte, 1, 2), "/", substr(txn_dte, 3, 2), "/", substr(txn_dte, 5, 2)),
    //         report_dte = STR_TO_DATE(report_dte, "%d/%m/%Y"), txn_dte = STR_TO_DATE(txn_dte, "%d/%m/%Y")');
    //         DB::statement('alter table result_bnd_'.$userId.' add column no int auto_increment primary key first');

    //         if($request->jenis_report == "BND013L")
    //         {
    //             DB::statement('insert into bnd013l (report_dte, org, merch_id, card_nbr, amount, tc, txn_dte, auth_cd, description, created_at, updated_at)
    //             select
    //                 trim(report_dte) as report_dte,
    //                 trim(org) as org,
    //                 trim(merch_id) as merch_id,
    //                 trim(card_nbr) as card_nbr,
    //                 trim(amount) as amount,
    //                 trim(tc) as tc,
    //                 trim(txn_dte) as txn_dte,
    //                 trim(auth_cd) as auth_cd,
    //                 trim(description) as description,
    //                 sysdate() as created_at,
    //                 sysdate() as updated_at
    //             from result_bnd_'.$userId.' where jenis = "BND013L"
    //             ON DUPLICATE KEY UPDATE
    //             report_dte = VALUES(report_dte),
    //             org = VALUES(org),
    //             merch_id = VALUES(merch_id),
    //             card_nbr = VALUES(card_nbr),
    //             amount = VALUES(amount),
    //             tc = VALUES(tc),
    //             txn_dte = VALUES(txn_dte),
    //             auth_cd = VALUES(auth_cd),
    //             description = VALUES(description),
    //             updated_at = sysdate()');
    //         }else{
    //             DB::statement('insert into bnd013qr (report_dte, org, merch_id, card_nbr, amount, tc, txn_dte, auth_cd, rrn, description, created_at, updated_at)
    //             select
    //                 trim(report_dte) as report_dte,
    //                 trim(org) as org,
    //                 trim(merch_id) as merch_id,
    //                 trim(card_nbr) as card_nbr,
    //                 trim(amount) as amount,
    //                 trim(tc) as tc,
    //                 trim(txn_dte) as txn_dte,
    //                 trim(auth_cd) as auth_cd,
    //                 trim(rrn) as rrn,
    //                 trim(description) as description,
    //                 sysdate() as created_at,
    //                 sysdate() as updated_at
    //             from result_bnd_'.$userId.' where jenis = "BND013QR"
    //             ON DUPLICATE KEY UPDATE
    //             report_dte = VALUES(report_dte),
    //             org = VALUES(org),
    //             merch_id = VALUES(merch_id),
    //             card_nbr = VALUES(card_nbr),
    //             amount = VALUES(amount),
    //             tc = VALUES(tc),
    //             txn_dte = VALUES(txn_dte),
    //             auth_cd = VALUES(auth_cd),
    //             description = VALUES(description),
    //             updated_at = sysdate()');
    //         }

    //         if($request->jenis_report == "BND013L")
    //         {
    //             return redirect('BND013L/list')->with('alertSuccess', 'Data Berhasil Diupload');
    //         }else{
    //             return redirect('BND013QR/list')->with('alertSuccess', 'Data Berhasil Diupload');
    //         }
    //     }else{
    //         return redirect()->back()->with('alert', 'Anda Belum Memilih Jenis Report');
    //     }
    // }

    public function prosesUploadData(Request $request)
    {
        $userId = $request->session()->get('userId');
        if($request->jenis_report != NULL)
        {
            if($request->jenis_report == "BND013L")
            {
                foreach ($request->file('file_import') as $file_import) {
                    $namafile = $file_import->getClientOriginalName().'txt';
                    $file_import->move(\base_path() ."/public/Import/folder_$userId/LinkAja/", $namafile);
                }
        
                $process1 = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Import\folder_'.$userId.'\LinkAja && copy *.txt linkAja_'.$userId.'.txt');
                $process1->run();
        
                foreach ($request->file('file_import') as $file_import) {
                    $namafile = $file_import->getClientOriginalName().'txt';
                    unlink(base_path('public/Import/folder_'.$userId.'/'.'LinkAja/'.$namafile));
                }
                $process2 = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Python\LinkAja && python linkAja.py '.$userId.'');
                $process2->setTimeout(3600);
                $process2->run();
                Excel::import(new LinkAjaImport(), public_path("/Import/folder_$userId/LinkAja/HasilLinkAja.xlsx"));
                unlink(base_path('public/Import/folder_'.$userId.'/LinkAja/HasilLinkAja.xlsx'));
                unlink(base_path('public/Import/folder_'.$userId.'/LinkAja/linkAja_'.$userId.'.txt'));
                return redirect('BND013L/list')->with('alertSuccess', 'Data Berhasil Diupload');
            }else{
                foreach ($request->file('file_import') as $file_import) {
                    $namafile = $file_import->getClientOriginalName().'.txt';
                    $file_import->move(\base_path() ."/public/Import/folder_$userId/Qris/", $namafile);
                }
        
                $process1 = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Import\folder_'.$userId.'\Qris && copy *.txt qris_'.$userId.'.txt');
                $process1->run();
        
                // foreach ($request->file('file_import') as $file_import) {
                //     $namafile = $file_import->getClientOriginalName().'';
                //     unlink(base_path('public/Import/folder_'.$userId.'/'.'Qris/'.$namafile));
                // }
                $process2 = Process::fromShellCommandline('cd D:\xampp\htdocs\rkm\public\Python\Qris && python qris.py '.$userId.'');
                $process2->setTimeout(3600);
                $process2->run();
                Excel::import(new QrisImport(), public_path("/Import/folder_$userId/Qris/HasilQris.xlsx"));
                unlink(base_path('public/Import/folder_'.$userId.'/Qris/HasilQris.xlsx'));
                unlink(base_path('public/Import/folder_'.$userId.'/Qris/qris_'.$userId.'.txt'));
                return redirect('BND013QR/list')->with('alertSuccess', 'Data Berhasil Diupload');
            }
        }else{
            return redirect()->back()->with('alert', 'Anda Belum Memilih Jenis Report');
        }
    }

}
