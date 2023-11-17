<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\Alerts;
use App\Models\UserModel;
use App\Models\RoleModel;
use App\Models\KelompokModel;

class UserController extends Controller
{
    public function getAllUser(Request $request)
    {
        $role = $request->session()->get('role_id');
        $kelompok = $request->session()->get('kelompok_id');
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

        if($role == 7){
            $userList = UserModel::getUserBySuperAdmin();
        }elseif($role == 1 && $kelompok == 6)
        {
            $userList = UserModel::getUserByAdmin();
        }else{
            $userList = UserModel::getUserByAdminKelompok($kelompok);
        }

        $data = array(
            'role' => $role,
            'alert' => $showalert,
            'userList' => $userList,
        );
        return view('user.user', $data);
    }

    public function formAddUser(Request $request, RoleModel $roleModel, KelompokModel $kelompokModel)
    {
        $role = $request->session()->get('role_id');
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

        if($role == 7){
        	$roleList = $roleModel->getAllRoleBySuperAdmin();
		}else{
        	$roleList = $roleModel->getAllRoleByAdminKelompok();
		}
        $kelompokList = $kelompokModel->getAllKelompok();

        $data = array(
            'role' => $role,
            'alert' => $showalert,
            'roleList' => $roleList,
            'kelompokList' => $kelompokList
        );
        return view('user.addUser', $data);
    }

    public function prosesAddUser(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok"); //set you countary name from below timezone list
        $password = Hash::make($request->password);
        $checkUser = UserModel::checkEmailExists($request->email);

        if($checkUser == 1){
            return redirect('user/add-new-user')->with('alert', 'Email Already Taken');
        }elseif($request->password != $request->confirm_password){
            return redirect('user/add-new-user')->with('alert', 'Please Enter Same Password');
        }else{
            $data = array(
                'email' => $request->email,
                'password' => $password,
                'name' => $request->fullName,
                'role_id' => $request->role_id,
                'kelompok_id' => $request->kelompok_id,
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            );
            UserModel::insertUser($data);

            return redirect('user')->with('alertSuccess', 'User Successfully Added');
        }
    }

    public function formUpdateUser(Request $request, RoleModel $roleModel, KelompokModel $kelompokModel)
    {
        $role = $request->session()->get('role_id');
        $alert = $request->session()->get('alert');
        $alertSuccess = $request->session()->get('alertSuccess');
        $alertInfo = $request->session()->get('alertInfo');
        $uri3 = $request->segment(3);
        if($alertSuccess){
            $showalert = Alerts::alertSuccess($alertSuccess);
        }else if($alertInfo){
            $showalert = Alerts::alertinfo($alertInfo);
        }else{
            $showalert = Alerts::alertDanger($alert);
        }

        if($role == 7){
        	$roleList = $roleModel->getAllRoleBySuperAdmin();
		}else{
        	$roleList = $roleModel->getAllRoleByAdminKelompok();
		}
        $kelompokList = $kelompokModel->getAllKelompok();
        $user = UserModel::getUserById($request->id);

        $data = array(
            'role' => $role,
            'alert' => $showalert,
            'roleList' => $roleList,
            'kelompokList' => $kelompokList,
            'user' => $user,
        );
        return view('user.editUser', $data);
    }

    public function prosesUpdateUser(Request $request)
    {
        date_default_timezone_set("Asia/Bangkok"); //set you countary name from below timezone list
        $uri3 = $request->segment(3);
        $id = $request->id;
        $password = Hash::make($request->password);
        $checkUser = UserModel::checkEmailExists($request->email);
        if($checkUser > 1){
            return redirect('user/update-user/'.$id)->with('alert', 'Email Already Taken');
        }elseif($request->password != $request->confirm_password){
            return redirect('user/update-user/'.$id)->with('alert', 'Please Enter Same Password');
        }else{
            $data = array(
                'email' => $request->email,
                'password' => $password,
                'name' => $request->fname,
                'role_id' => $request->role_id,
                'kelompok_id' => $request->kelompok_id,
                'updated_at' => date("Y-m-d h:i:s"),
            );
            UserModel::where('id', $id)->update($data);

            return redirect('user')->with('alertSuccess', 'User Successfully Updated');
        }
    }

    public function deleteUser(Request $request){
        $id = $request->id;
        UserModel::deleteUser($id);
        return redirect()->back()->with('alertSuccess', 'Useer Has Been Deleted');
    }
}
