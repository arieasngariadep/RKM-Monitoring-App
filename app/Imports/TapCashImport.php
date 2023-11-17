<?php

namespace App\Imports;

use App\Models\TapCashModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;

class TapCashImport implements ToModel, WithStartRow, WithCalculatedFormulas
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
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $nama = explode(".",$row[14]);

        date_default_timezone_set("Asia/Jakarta");
        return new TapCashModel([
            'oo_batch' => $row[0],
            'txn_date' => $this->transformDate($row[1]),
            'auth' => $row[2],
            'cardnum' => $row[3],
            'amount' => $row[4],
            'rate' => $row[5],
            'disc_amount' => $row[6],
            'net_amount' => $row[7],
            'mid' => $row[8],
            'bankName' => $row[9],
            'mname' => trim($row[10]),
            'noRek' => $row[11],
            'namaRek' => $row[12],
            'proc_date' => $this->transformDate($row[13]),
            'report_name' => $row[14],
            'report_type' => "BND REJECT",
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
