<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $guarded = [];
    public $timestamps = false;
    protected $fillable = ['id', 'name', 'email', 'password',  'role_id', 'kelompok_id', 'created_at', 'updated_at'];

    public function getLoginUser($email)
    {
        $user = new UserModel;
        $data = $user
        ->select('user.*', 'user.id as userId', 'role.role_name', 'kelompok.*')
        ->leftJoin('role', 'role.role_id', '=', 'user.role_id')
        ->leftjoin('kelompok', 'kelompok.id', '=', 'user.kelompok_id')
        ->where('user.email', $email)
        // ->where('user.is_verified', 1)
        ->first();
        return $data;
    }

    public function checkingMe($email)
    {
        $user = new UserModel;
        $data = $user
        ->select('user.*', 'user.user_id as userId', 'role.role_name')
        ->leftJoin('role', 'role.role_id', '=', 'user.role_id')
        ->where('user.email', $email)
        ->where('user.is_verified', 1)
        ->get();

        return $data;
    }

    public function getUserByAdminKelompok($kelompok_id)
    {
        $user = new UserModel;
        $data = $user
        ->select('user.*', 'user.id as userId', 'role.*', 'kelompok.*')
        ->leftjoin('role', 'role.role_id', '=', 'user.role_id')
        ->leftjoin('kelompok', 'kelompok.id', '=', 'user.kelompok_id')
        ->where('user.kelompok_id', $kelompok_id)
        ->where(function($query) {
            $query->Where('user.role_id', '!=', 7);
        })
        ->get();
        return $data;
    }

    public function getUserByAdmin()
    {
        $user = new UserModel;
        $data = $user
        ->select('user.*', 'user.id as userId', 'role.*', 'kelompok.*')
        ->leftjoin('role', 'role.role_id', '=', 'user.role_id')
        ->leftjoin('kelompok', 'kelompok.id', '=', 'user.kelompok_id')
        ->where(function($query) {
            $query->Where('user.role_id', '!=', 7);
        })
        ->get();
        return $data;
    }

    public function getUserBySuperAdmin()
    {
        $user = new UserModel;
        $data = $user
        ->select('user.*', 'user.id as userId', 'role.*', 'kelompok.*')
        ->leftjoin('role', 'role.role_id', '=', 'user.role_id')
        ->leftjoin('kelompok', 'kelompok.id', '=', 'user.kelompok_id')
        ->get();
        return $data;
    }

    public function getUserById($userId)
    {
        $user = new UserModel;
        $data = $user
        ->select('user.*', 'user.id as userId', 'role.role_name')
        ->leftJoin('role', 'role.role_id', '=', 'user.role_id')
        ->leftjoin('kelompok', 'kelompok.id', '=', 'user.kelompok_id')
        ->where('user.id', $userId)
        ->first();
        return $data;
    }

    public function getUserAdmin() {
        $user = new UserModel;
        $data = $user
        ->select('user.*', 'user.id as userId', 'role.role_name')
        ->leftJoin('role', 'role.role_id', '=', 'user.role_id')
        ->leftjoin('kelompok', 'kelompok.id', '=', 'user.kelompok_id')
        ->where('user.role_id', '=', 1)
        ->first();
        return $data;
    }

    public function checkEmailExists($email)
    {
        $user = new UserModel;
        $data = $user
        ->select('user.email')
        ->leftJoin('role', 'role.role_id', '=', 'user.role_id')
        ->leftjoin('kelompok', 'kelompok.id', '=', 'user.kelompok_id')
        ->where('email', $email);
        $checkData = $data->count();
        return $checkData;
    }

    function checkEmail($email)
    {
        $user = new UserModel;
        $sql = $user
        ->select('*')
        ->where('email', $email);
        $query = $sql->get();

        if ($query->count() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function insertUser($data)
    {
        $user = new UserModel;
        $save = $user->create($data);
        return $save;
    }

    public function deleteUser($id)
    {
        $user = new UserModel;
        $user->where('id', $id)->delete();
    }

    public function check_email_exists($email, $userId = 0)
    {
        $user = new UserModel;
        $query = $user
        ->select("email")
        ->where("email", $email)
        ->where("is_verified", 1);

        if($userId != 0){
            $query->where("id !=", $userId);
        }
        $data = $query->get();
        return $data;
    }
}
