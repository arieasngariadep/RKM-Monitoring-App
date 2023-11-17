<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TapCashModel extends Model
{
    protected $table = 'tapcash';
    protected $guarded = [];
    public $timestamps = false;
    protected $fillable = ['id', 'mid', 'mname', 'bankName', 'noRek','namaRek', 'proc_date', 'oo_batch', 'txn_date', 'auth', 'cardnum', 'amount', 'rate', 'disc_amount','net_amount', 'report_name','report_type', 'created_at', 'updated_at'];

    public function getListTapCash($txn_date, $start_proc_date, $end_proc_date, $mid, $cardnum, $auth, $amount, $report_name){
        if(isset($txn_date) || (isset($start_proc_date) && isset($end_proc_date)) || isset($mid) || isset($cardnum) || isset($auth) || isset($amount) || isset($report_name))
        {
            $query = TapCashModel::select('*');
            if(isset($txn_date))
            {
                $query->where('txn_date', $txn_date);
            }

            if(isset($start_proc_date) && isset($end_proc_date))
            {
                $query->whereBetween('proc_date', [$start_proc_date,$end_proc_date]); 
            }

            if(isset($mid))
            {
                $query->where('mid', $mid);
            }

            if(isset($cardnum))
            {
                $query->where('cardnum', $cardnum);
            }

            if(isset($auth))
            {
                $query->where('auth', $auth);
            }

            if(isset($amount))
            {
                $query->where('amount', $amount);
            }

            if(isset($report_name))
            {
                $query->where('report_name', $report_name);
            }
            
            $listTapCash = $query->paginate(5);
            return $listTapCash->appends(\Request::all());
        }
    }

    public function getReportSearchTC($txn_date, $start_proc_date, $end_proc_date, $mid, $cardnum, $auth, $amount, $report_name)
    {
        $TC = new TapCashModel;
        $query = $TC->select('*');

        if($txn_date != NULL)
        {
            $query->where('txn_date', $txn_date);
        }

        if($start_proc_date != NULL && $end_proc_date != NULL)
        {
            $query->whereBetween('proc_date', [$start_proc_date,$end_proc_date]); 
        }

        if($mid != NULL)
        {
            $query->where('mid', $mid);
        }

        if($cardnum != NULL)
        {
            $query->where('cardnum', $cardnum);
        }

        if($auth != NULL)
        {
            $query->where('auth', $auth);
        }

        if($amount != NULL)
        {
            $query->where('amount', $amount);
        }

        if($report_name != NULL)
        {
            $query->where('report_name', $report_name);
        }

        $data = $query->get();
        return $data;
    }


    public function deleteListTC($txn_date, $start_proc_date, $end_proc_date, $mid, $cardnum, $auth, $amount, $report_name)
    {
        if(isset($txn_date) || (isset($start_proc_date) && isset($end_proc_date)) || isset($mid) || isset($cardnum) || isset($auth) || isset($amount) || isset($report_name))
        {
            $query = TapCashModel::select('*');
            if(isset($txn_date))
            {
                $query->where('txn_date', $txn_date);
            }

            if(isset($start_proc_date) && isset($end_proc_date))
            {
                $query->whereBetween('proc_date', [$start_proc_date,$end_proc_date]); 
            }

            if(isset($mid))
            {
                $query->where('mid', $mid);
            }

            if(isset($cardnum))
            {
                $query->where('cardnum', $cardnum);
            }

            if(isset($auth))
            {
                $query->where('auth', $auth);
            }

            if(isset($amount))
            {
                $query->where('amount', $amount);
            }

            if(isset($report_name))
            {
                $query->where('report_name', $report_name);
            }

            $data = $query->delete();
            return $data;
        }
    }
}
