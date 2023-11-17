<?php

namespace App\Exports\Settlement;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\ReportModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class ReportSearchQANewExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder, WithColumnFormatting
{
    function __construct($txn_dte, $report_dte, $merch_id, $card_nbr, $rrn, $description)
    {
        $this->txn_dte = $txn_dte;
        $this->report_dte = $report_dte;
        $this->merch_id = $merch_id;
        $this->card_nbr = $card_nbr;
        $this->rrn = $rrn;
        $this->description = $description;
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $this->data = ReportModel::getDataReportSearchExportBND01QANew($this->txn_dte, $this->report_dte, $this->merch_id, $this->card_nbr, $this->rrn, $this->description);

        foreach ($this->data as $d) {
            $export[] = array(
                'REPORT-DTE' => $d->report_dte,
                'MERCH-ID' => $d->merch_id,
                'CARD-NBR' => $d->card_nbr,
                'MDR' => $d->mdr,
                'AMOUNT' => $d->amount,
                'NETT AMOUNT' => $d->nett_amount,
                'TXN-DTE' => $d->txn_dte,
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
            'MERC-ID',
            'CARD-NBR',
            'MDR',
            'AMOUNT',
            'NETT AMOUNT',
            'TXN-DTE',
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
