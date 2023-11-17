<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SearchBulkQANewImport implements ToCollection, WithHeadingRow
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
            DB::table('data_bulk_qa_new_'.$this->user_id.'')->insert([
                'txn_dte' => $this->transformDate($row['txn_dte']),
                'report_dte' => $this->transformDate($row['report_dte']),
                'merch_id' => $row['merch_id'],
                'card_nbr' => $row['card_nbr'],
                'rrn' => $row['rrn'],
                'description' => $row['description'],
                'amount'=> $row['amount'],
                'mdr'=> $row['mdr'],
                'nett_amount'=> $row['nett_amount'],
            ]);
        }
    }
}
