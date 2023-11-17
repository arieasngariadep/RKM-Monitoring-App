<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BND013QRModel extends Model
{
    protected $table = 'bnd013qr';
    protected $guarded = [];
    public $timestamps = false;
    protected $fillable = ['id', 'jenis', 'report_dte', 'merch_id', 'card_nbr', 'amount', 'tc', 'txn_dte', 'auth_cd', 'rrn', 'description', 'created_at', 'updated_at'];

    public function getListBND013QR($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $rrn, $description)
    {
        $bnd = new BND013QRModel;
        if(isset($txn_dte) || isset($report_dte) || isset($merch_id) || isset($card_nbr) || isset($auth_cd) || isset($rrn) || isset($description))
        {
            $query = BND013QRModel::select('*');

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

            if(isset($rrn))
            {
                $query->where('rrn', $rrn);
            }

            if(isset($description))
            {
                $query->where('description', $description);
            }

            $listBnd = $query->paginate(5);
            return $listBnd->appends(\Request::all());
        }
    }

    public function deleteListBND013QR($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $rrn, $description)
    {
        $bnd = new BND013QRModel;
        if(isset($txn_dte) || isset($report_dte) || isset($merch_id) || isset($card_nbr) || isset($auth_cd) || isset($rrn) || isset($description))
        {
            $query = BND013QRModel::select('*');

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

            if(isset($rrn))
            {
                $query->where('rrn', $rrn);
            }

            if(isset($description))
            {
                $query->where('description', $description);
            }

            $data = $query->delete();
            return $data;
        }
    }

    public function getQrisToday()
    {
        $today = Carbon::now()->format('Y-m-d');
        $bnd = new BND013QRModel;
        $data = $bnd::select(DB::raw('count(id) as jumlah_item'), DB::raw('sum(amount) as jumlah_amount'))
        ->where(DB::raw('date(created_at)'), $today)->first();
        return $data;
    }
    
    public function countItemByDateQR($reportDate){
        $bnd013QR = new BND013QRModel;
        $data = $bnd013QR::select(DB::raw('count(id) as jumlah_item'), DB::raw('sum(amount) as jumlah_amount'))
                ->where(DB::raw('date(created_at)'),$reportDate)
                ->first();
        return $data;
    }
}
