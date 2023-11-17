<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use App\Models\ReportModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LinkAja\ReportBND013LExport;
use App\Exports\QR\ReportBND013QRExport;

class ReportController extends Controller
{
    public function downloadReportPage(Request $request)
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

        $role = $request->session()->get('role_id');
        $kelompok_id = $request->session()->get('kelompok_id');
        $txn_dte1 = $request->txn_dte1;
        $txn_dte2 = $request->txn_dte2;
        $report_dte1 = $request->report_dte1;
        $report_dte2 = $request->report_dte2;
        $jenis = $request->jenis;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $rrn = $request->rrn;
        $description = $request->description;

        if($jenis == 'BND013L')
        {
            $dataReport = ReportModel::getDataReportBND013L($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $description);
        }elseif($jenis == 'BND013QR'){
            $dataReport = ReportModel::getDataReportBND013QR($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $rrn, $description);
        }else{
            $dataReport = NULL;
        }

        $passing = array(
            'alert' => $showalert,
            'role' => $role,
            'kelompok_id' => $kelompok_id,
            'jenis' => $jenis,
            'txn_dte1' => $txn_dte1,
            'txn_dte2' => $txn_dte2,
            'report_dte1' => $report_dte1,
            'report_dte2' => $report_dte2,
            'merch_id' => $merch_id,
            'card_nbr' => $card_nbr,
            'auth_cd' => $auth_cd,
            'rrn' => $rrn,
            'description' => $description,
        );   
        return view('page.download_report', $passing);
    }

    public function prosesExportReport(Request $request)
    {
        $txn_dte1 = $request->txn_dte1;
        $txn_dte2 = $request->txn_dte2;
        $report_dte1 = $request->report_dte1;
        $report_dte2 = $request->report_dte2;
        $jenis = $request->jenis;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $rrn = $request->rrn;
        $description = $request->description;

        if($request->jenis == "BND013L")
        {
            return Excel::download(new ReportBND013LExport($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $description), "Report BND013L.xlsx");
        }else{
            return Excel::download(new ReportBND013QRExport($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $rrn, $description), "Report BND013QR.xlsx");
        }
    }

    public function deleteDataReport(Request $request)
    {
        $txn_dte1 = $request->txn_dte1;
        $txn_dte2 = $request->txn_dte2;
        $report_dte1 = $request->report_dte1;
        $report_dte2 = $request->report_dte2;
        $jenis = $request->jenis;
        $merch_id = $request->merch_id;
        $card_nbr = $request->card_nbr;
        $auth_cd = $request->auth_cd;
        $rrn = $request->rrn;
        $description = $request->description;
        
        if($request->jenis == "BND013L")
        {
            ReportModel::deleteDataReportBND013L($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $description);
        }else{
            ReportModel::deleteDataReportBND013QR($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $rrn, $description);
        }

        return redirect()->back()->with('alertSuccess', 'Data Berhasil Dihapus');
    }
}
