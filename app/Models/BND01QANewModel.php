<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BND01QANewModel extends Model
{
    protected $table = 'bnd01qa_new';
    protected $guarded = [];
    public $timestamps = true;
    protected $fillable = ['id', 'report_dte', 'merch_id', 'card_nbr', 'amount', 'txn_dte' , 'rrn', 'description', 'created_at', 'updated_at'];

    public function getListBND01QANew($txn_dte, $report_dte, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QANewModel;
        if(isset($txn_dte) || isset($report_dte) || isset($merch_id) || isset($card_nbr) || isset($rrn) || isset($description))
        {
            $query = BND01QANewModel::select('*');

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

    public function deleteListBND01QANew($txn_dte, $report_dte, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QANewModel;
        if(isset($txn_dte) || isset($report_dte) || isset($merch_id) || isset($card_nbr) || isset($rrn) || isset($description))
        {
            $query = BND01QANewModel::select('*');

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

    public function countItemByDateQANew($reportDate){
        $bnd01QA = new BND01QANewModel;
        $data = $bnd01QA::select(DB::raw('count(id) as jumlah_item'), DB::raw('sum(amount) as jumlah_amount'))
                ->where(DB::raw('date(created_at)'),$reportDate)
                ->first();
        return $data;
    }

    // public function getQAToday()
    // {
    //     $today = Carbon::now()->format('Y-m-d');
    //     $bnd = new BND01QAModel;
    //     $data = $bnd::select(DB::raw('count(id) as jumlah_item'), DB::raw('sum(amount) as jumlah_amount'))
    //     ->where(DB::raw('date(created_at)'), $today)->first();
    //     return $data;
    // }
}
