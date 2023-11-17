<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BND013LModel;
use App\Models\BND013QRModel;
use App\Models\BND01QAModel;
use App\Models\BND01QANewModel;

class ReportModel extends Model
{
    public function getDataReportBND013L($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $description)
    {
        $bnd = new BND013LModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($auth_cd != NULL)
        {
            $query->where('auth_cd', $auth_cd);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public function getDataReportBND013QR($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $rrn, $description)
    {
        $bnd = new BND013QRModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($auth_cd != NULL)
        {
            $query->where('auth_cd', $auth_cd);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public function getDataReportBND01QA($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QAModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public function getDataReportBND01QANew($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QANewModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }


    public function deleteDataReportBND013L($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $description)
    {
        $bnd = new BND013LModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($auth_cd != NULL)
        {
            $query->where('auth_cd', $auth_cd);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $query->delete();
    }

    public function deleteDataReportBND013QR($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $rrn, $description)
    {
        $bnd = new BND013QRModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($auth_cd != NULL)
        {
            $query->where('auth_cd', $auth_cd);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $query->delete();
    }

    public function deleteDataReportBND01QA($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QAModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $query->delete();
    }

    public function deleteDataReportBND01QANew($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QANewModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $query->delete();
    }

    public static function getDataReportExportBND013L($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $description)
    {
        $bnd = new BND013LModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($auth_cd != NULL)
        {
            $query->where('auth_cd', $auth_cd);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public static function getDataReportExportBND013QR($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $auth_cd, $rrn, $description)
    {
        $bnd = new BND013QRModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($auth_cd != NULL)
        {
            $query->where('auth_cd', $auth_cd);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public static function getDataReportExportBND01QA($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QAModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public static function getDataReportExportBND01QANew($txn_dte1, $txn_dte2, $report_dte1, $report_dte2, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QANewModel;
        $query = $bnd->select('*');

        if($txn_dte1 != NULL && $txn_dte2 != NULL)
        {
            $query->whereBetween('txn_dte', [$txn_dte1, $txn_dte2]);
        }

        if($report_dte1 != NULL && $report_dte2 != NULL)
        {
            $query->whereBetween('report_dte', [$report_dte1, $report_dte2]);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public static function getDataReportSearchExportBND013QR($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $rrn, $description)
    {
        $bnd = new BND013QRModel;
        $query = $bnd->select('*');

        if($txn_dte != NULL)
        {
            $query->where('txn_dte', $txn_dte);
        }

        if($report_dte != NULL)
        {
            $query->where('report_dte', $report_dte);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }
        
        if($auth_cd != NULL)
        {
            $query->where('auth_cd', $auth_cd);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public static function getDataReportSearchExportBND01QA($txn_dte, $report_dte, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QAModel;
        $query = $bnd->select('*');

        if($txn_dte != NULL)
        {
            $query->where('txn_dte', $txn_dte);
        }

        if($report_dte != NULL)
        {
            $query->where('report_dte', $report_dte);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public static function getDataReportSearchExportBND01QANew($txn_dte, $report_dte, $merch_id, $card_nbr, $rrn, $description)
    {
        $bnd = new BND01QANewModel;
        $query = $bnd->select('*');

        if($txn_dte != NULL)
        {
            $query->where('txn_dte', $txn_dte);
        }

        if($report_dte != NULL)
        {
            $query->where('report_dte', $report_dte);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }

        if($rrn != NULL)
        {
            $query->where('rrn', $rrn);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        $data = $query->get();
        return $data;
    }

    public static function getDataReportSearchBulkExportBND013QR($userId)
    {
        $data = DB::table('result_searchbulk_qr_'.$userId.'')->get();
        return $data;
    }

    public static function getDataReportSearchBulkExportBND01QA($userId)
    {
        $data = DB::table('result_searchbulk_qa_'.$userId.'')->get();
        return $data;
    }

    public static function getDataReportSearchBulkExportBND01QANew($userId)
    {
        $data = DB::table('result_searchbulk_qa_new_'.$userId.'')->get();
        return $data;
    }

    public static function getDataReportSearchExportBND013L($txn_dte, $report_dte, $merch_id, $card_nbr, $auth_cd, $description, $amount)
    {
        $bnd = new BND013LModel;
        $query = $bnd->select('*');

        if($txn_dte != NULL)
        {
            $query->where('txn_dte', $txn_dte);
        }

        if($report_dte != NULL)
        {
            $query->where('report_dte', $report_dte);
        }

        if($merch_id != NULL)
        {
            $query->where('merch_id', $merch_id);
        }

        if($card_nbr != NULL)
        {
            $query->where('card_nbr', $card_nbr);
        }
        
        if($auth_cd != NULL)
        {
            $query->where('auth_cd', $auth_cd);
        }

        if($description != NULL)
        {
            $query->where('description', $description);
        }

        if($amount != NULL)
        {
            $query->where('amount', $amount);
        }

        $data = $query->get();
        return $data;
    }

    public static function getDataReportSearchBulkExportBND013L($userId)
    {
        $data = DB::table('result_searchbulk_linkaja_'.$userId.'')->get();
        return $data;
    }
}
