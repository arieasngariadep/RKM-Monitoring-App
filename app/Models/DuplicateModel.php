<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\BND013LModel;

class DuplicateModel extends Model
{
    public function getDataCekDuplicate($userId)
    {
        $query = DB::table('duplicate_'.$userId.'')
        ->groupBy('matchingkey')
        ->paginate(5);

        return $query->appends(\Request::all());
    }

    public function cekDataLinkAja($userId)
    {
        $subquery = BND013LModel::select(DB::raw('concat(description, amount) as matchingkey'));

        $query = DB::table('duplicate_'.$userId.'')
        ->whereIn('matchingkey', $subquery)
        ->paginate(5);

        return $query->appends(\Request::all());
    }

    public static function getCekDuplicateExport($userId)
    {
        $data = DB::table('duplicate_'.$userId.'')
        ->groupBy('matchingkey')
        ->get();

        return $data;
    }
}
