<?php

namespace App\Exports\KartuKredit;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReportSearchBulkKKExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder, WithColumnFormatting
{
    function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '@',
            'D' => '@',
            'F' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'G' => '@',
            'H' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
            'I' => '@',
            'J' => '@',
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'L' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'M' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'N' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DB::table('result_searchbulk_kk_'.$this->userId.'')->get();

        foreach ($data as $d) {
            $export[] = array( 
                'MID' => $d->mid,
                'MERCHANT NAME' => $d->mname,
                'BANK NAME' => $d->bankName,
                'NO REK' => $d->noRek,
                'NAMA REK' => $d->namaRek,
                'PROC DATE' => $d->proc_date,
                'OO BATCH' => $d->oo_batch,
                'TXN DATE' => $d->txn_date,
                'AUTH' => $d->auth,
                'CARDNUM' => $d->cardnum,
                'SS' => $d->ss,
                'AMOUNT' => $d->amount,
                'RATE' => $d->rate,
                'DISC AMOUNT' => $d->disc_amount,
                'NETT AMOUNT' => $d->net_amount,
                'REPORT NAME' => $d->report_name,
                'REPORT TYPE' => $d->report_type,
            );
        }
        return collect($export);
    }

    public function headings(): array
    {
        return [
            'MID',
            'MERCHANT NAME',
            'BANK NAME',
            'NO REK',
            'NAMA REK',
            'PROC DATE',
            'OO BATCH',
            'TXN DATE',
            'AUTH',
            'CARDNUM',
            'SS',
            'AMOUNT',
            'RATE',
            'DISC AMOUNT',
            'NETT AMOUNT',
            'REPORT NAME',
            'REPORT TYPE',
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'A' || $cell->getColumn() == 'B' || $cell->getColumn() == 'C' || $cell->getColumn() == 'D' || $cell->getColumn() == 'F' || $cell->getColumn() == 'G' || $cell->getColumn() == 'H' || $cell->getColumn() == 'I' || $cell->getColumn() == 'J' || $cell->getColumn() == 'L') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}
