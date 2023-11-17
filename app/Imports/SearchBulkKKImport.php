<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SearchBulkKKImport implements ToCollection, WithHeadingRow
{
    function __construct($user_id)
    {
        $this->user_id = $user_id;
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
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) 
        {
            DB::table('data_bulk_kk_'.$this->user_id.'')->insert([
            'txn_date' => $this->transformDate($row['txn_date']),
            'auth' => $row['auth'],
            'amount' => $row['amount'],
            'rate' => $row['rate'],
            'disc_amount' => $row['disc_amount'],
            'net_amount' => $row['net_amount'],
            'cardnum' => $row['cardnum'],
            'bankName' => $row['nama_bank'],
            'mname' => $row['mname'],
            'mid' => $row['mid'],
            'noRek' => $row['no_rek'],
            'namaRek' => $row['nama_rek'],
            'proc_date' => $this->transformDate($row['proc_date']),
            'report_name' => $row['nama_report'],
            'report_type' => $row['jenis_report'],
            ]);
        }
    }
}
