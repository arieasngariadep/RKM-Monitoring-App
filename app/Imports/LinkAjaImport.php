<?php

namespace App\Imports;

use App\Models\BND013LModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class LinkAjaImport implements ToCollection, WithStartRow
{
    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }

    /**
     * Transform a date value into a Carbon object.
     *
     * @return \Carbon\Carbon|null
     */
    public function transformDate($value, $format = 'd/m/y')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        date_default_timezone_set("Asia/Jakarta");
        foreach ($collection as $row) 
        {
            BND013LModel::insert([
                'report_dte' => $this->transformDate($row[0]),
                'org' => $row[1],
                'merch_id' => $row[2],
                'card_nbr' => $row[3],
                'amount' => $row[4],
                'tc' => $row[5],
                'txn_dte' => $this->transformDate($row[6]),
                'auth_cd' => $row[7],
                'description' => $row[8],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
