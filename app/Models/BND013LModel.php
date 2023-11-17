<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BND013LModel extends Model
{
    protected $table = 'bnd013l';
    protected $guarded = [];
    public $timestamps = false;
    protected $fillable = ['id', 'jenis', 'report_dte', 'merch_id', 'card_nbr', 'amount', 'tc', 'txn_dte', 'auth_cd', 'description', 'created_at', 'updated_at'];

    public function getListBnd013L($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $description, $amount)
    {
        $bnd = new BND013LModel;
        if(isset($txn_dte) || isset($report_dte) || isset($merch_id) || isset($card_nbr) || isset($auth_cd) || isset($description) || isset($amount))
        {
            $query = $bnd->select('*');

            if(isset($txn_dte))
            {
                $query->where('txn_dte', $txn_dte);
            }

            if(isset($report_dte))
            {
                $query->where('report_dte', $report_dte);
            }

            if(isset($merch_id))
            {
                $query->where('merch_id', $merch_id);
            }

            if(isset($card_nbr))
            {
                $query->where('card_nbr', $card_nbr);
            }

            if(isset($auth_cd))
            {
                $query->where('auth_cd', $auth_cd);
            }

            if(isset($description))
            {
                $query->where('description', $description);
            }

            if(isset($amount))
            {
                $query->where('amount', $amount);
            } 

            $listBnd = $query->paginate(5);
            return $listBnd->appends(\Request::all());
        }
    }

    public function deleteListBnd013L($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $description, $amount)
    {
        $bnd = new BND013LModel;
        if(isset($txn_dte) || isset($report_dte) || isset($merch_id) || isset($card_nbr) || isset($auth_cd) || isset($description) || isset($amount))
        {
            $query = $bnd->select('*');

            if(isset($txn_dte))
            {
                $query->where('txn_dte', $txn_dte);
            }

            if(isset($report_dte))
            {
                $query->where('report_dte', $report_dte);
            }

            if(isset($merch_id))
            {
                $query->where('merch_id', $merch_id);
            }

            if(isset($card_nbr))
            {
                $query->where('card_nbr', $card_nbr);
            }

            if(isset($auth_cd))
            {
                $query->where('auth_cd', $auth_cd);
            }

            if(isset($description))
            {
                $query->where('description', $description);
            }

            if(isset($amount))
            {
                $query->where('amount', $amount);
            } 

            $data = $query->delete();
            return $data;
        }
    }

    public function getLinkAjaToday()
    {
        $today = Carbon::now()->format('Y-m-d');
        $bnd = new BND013LModel;
        $data = $bnd::select(DB::raw('count(id) as jumlah_item'), DB::raw('sum(amount) as jumlah_amount'))
        ->where(DB::raw('date(created_at)'), $today)->first();
        return $data;
    }

    
    public function countItemByDateL($reportDate){
        $bnd013L = new BND013LModel;
        $data = $bnd013L::select(DB::raw('count(id) as jumlah_item'), DB::raw('sum(amount) as jumlah_amount'))
                ->where(DB::raw('date(created_at)'), $reportDate )
                ->first();
        return $data;   
    }
}
