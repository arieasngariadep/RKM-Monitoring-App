<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Alerts;
use App\Models\UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function loginPage(Request $request)
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

		return view('login/login', $passing);
	}

    public function loginProcess(Request $request, UserModel $user)
    {
        date_default_timezone_set("Asia/Jakarta");
        $today = date("Y-m-d");
        $email = $request->email;
        $password  = $request->password;
        $userLogin = $user->getLoginUser($email);
        if($userLogin){ //apakah email tersebut ada atau tidak
            $pass = $userLogin->password;
            $verify_pass = password_verify($password, $pass);
            if($verify_pass){
                $ses_data = array(
                    'userId' => $userLogin->userId,
                    'username' => $userLogin->name,
                    'email' => $userLogin->email,
                    'password' => $userLogin->password,
                    'role_id' => $userLogin->role_id,
                    'role_name' => $userLogin->role_name,
                    'kelompok_id' => $userLogin->kelompok_id,
                    'isLogin' => TRUE
                );
                $request->session()->put($ses_data);
                return redirect('dashboard');
            }else{
                return redirect()->back()->with('alert', 'Wrong Password');
            }
        }else{
            return redirect('/login')->with('alert', 'Email or Password Unmatched');
        }
    }

    public function prosesChangePassword(Request $request, UserModel $userModel)
    {
        date_default_timezone_set("Asia/Bangkok"); //set you countary name from below timezone list
        if($request->password != $request->confirm_password){
            return redirect()->back()->with('alert', 'Please Enter Same Password');
        }else{
            $password = Hash::make($request->password);
            $data = array(
                'password' => $password,
                'updated_at' => date("Y-m-d h:i:s"),
            );
            DB::table('user')->where('id', $request->id)->update($data);

            return redirect()->back()->with('alertSuccess', 'Pasword Has Been Changed');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }
}
