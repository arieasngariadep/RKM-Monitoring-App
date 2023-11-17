<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use Carbon\Carbon;
use App\Models\BND013LModel;
use App\Models\BND013QRModel;
use App\Models\BND01QAModel;

class DashboardController extends Controller
{
    public function dashboardApp(Request $request)
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
        
        $data = array(
            'alert' => $showalert,
        );

        return view('dashboard', $data);
    }
}
