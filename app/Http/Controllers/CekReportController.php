<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use Carbon\Carbon;
use App\Models\BND013LModel;
use App\Models\BND013QRModel;
use App\Models\BND01QAModel;
use App\Models\BND01QANewModel;

class CekReportController extends Controller{

    public function getReportItem(Request $request){
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

        $reportDate = $request->reportDate;
        $category = $request->categories;

        if($category == "BND01QA"){
            $reportItem = BND01QAModel::countItemByDateQA($reportDate);
        }else if($category == "BND01QANew"){
            $reportItem = BND01QANewModel::countItemByDateQANew($reportDate);
        }elseif($category == "BND013QR") {
            $reportItem = BND013QRModel::countItemByDateQR($reportDate);
        }else{
            $reportItem = BND013LModel::countItemByDateL($reportDate);
        }

        $linkAja = BND013LModel::getLinkAjaToday();
        $qris = BND013QRModel::getQrisToday();
        $now = Carbon::now()->format('d M Y');

        $data = array(
            'alert' => $showalert,
            'reportItem' => $reportItem,
            'reportDate' => $reportDate,
            'category' => $category,
            'linkAja' => $linkAja,
            'qris' => $qris,                
            'now' => $now,
        );

        return view('page.CekReport.cekReport', $data);
    }
}

?>