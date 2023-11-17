<?php

namespace App\Imports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class DuplicateImport implements ToCollection, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    function __construct($userId)
    {
        $this->userId = $userId;
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        date_default_timezone_set("Asia/Jakarta");
        foreach ($collection as $row) 
        {
            DB::table('duplicate_'.$this->userId.'')->insert([
                'orderId' => $row[0],
                'last_updated_time' => $row[1],
                'initiation_time' => $row[2],
                'status' => $row[3],
                'reason_type' => $row[4],
                'transaction_amount' => $row[5],
                'mdr' => $row[6],
                'nett_amount' => $row[7],
                'organization_name' => $row[8],
                'organization_shortcode' => $row[9],
                'partner_merchant_id' => $row[10],
                'merchant_trx_id' => $row[11],
                'matchingkey' => $row[12],
            ]);
        }
    }
}
