<?php

namespace App\Exports\QR;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\ReportModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReportSearchBulkQrExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder, WithColumnFormatting
{
    function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $this->data = ReportModel::getDataReportSearchBulkExportBND013QR($this->userId);

        foreach ($this->data as $d) {
            $export[] = array(
                'REPORT-DTE' => $d->report_dte,
                'ORG' => $d->org,
                'MERCH-ID' => $d->merch_id,
                'CARD-NBR' => $d->card_nbr,
                'AMOUNT' => $d->amount,
                'TC' => $d->tc,
                'TXN-DTE' => $d->txn_dte,
                'AUTH-CD' => $d->auth_cd,
                'RRN' => $d->rrn,
                'DESCRIPTION' => $d->description,
            );
        }
        return collect($export);
    }

    public function headings(): array
    {
        return [
            'REPORT-DTE',
            'ORG',
            'MERC-ID',
            'CARD-NBR',
            'AMOUNT',
            'TC',
            'TXN-DTE',
            'AUTH-CD',
            'RRN',
            'DESCRIPTION',
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'B' || $cell->getColumn() == 'C' || $cell->getColumn() == 'D' || $cell->getColumn() == 'F' || $cell->getColumn() == 'G' || $cell->getColumn() == 'H' || $cell->getColumn() == 'I' || $cell->getColumn() == 'J') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}
