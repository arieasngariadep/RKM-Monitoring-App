<?php

namespace App\Exports\Duplicate;

use App\Models\DuplicateModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class DuplicateExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder, WithColumnFormatting
{
    function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function columnFormats(): array
    {
        return [
            'A' => '@',
            'E' => '@',
            'J' => '@',
            'L' => '@',
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2,
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = DuplicateModel::getCekDuplicateExport($this->userId);

        if(count($data) > 0) {
            foreach ($data as $d) {
                $export[] = array(
                    'ORDERID' => $d->orderId,
                    'LAST_UPDATED_TIME'  => $d->last_updated_time,
                    'INITIATION_TIME'  => $d->initiation_time,
                    'STATUS'  => $d->status,
                    'REASON_TYPE'  => $d->reason_type,
                    'TRANSACTION_AMOUNT'  => $d->transaction_amount,
                    'MDR'  => $d->mdr,
                    'NETT_AMOUNT'  => $d->nett_amount,
                    'ORGANIZATION_NAME'  => $d->organization_name,
                    'ORGANIZATION_SHORTCODE'  => $d->organization_shortcode,
                    'PARTNERMERCHANTID'  => $d->partner_merchant_id,
                    'MERCHANTTRXID'  => $d->merchant_trx_id,
                    
                );
            }
            return collect($export);
        }else{
            return collect($data);
        }
    }

    public function headings(): array
    {
        return [
            'ORDERID',
            'LAST_UPDATED_TIME',
            'INITIATION_TIME',
            'STATUS',
            'REASON_TYPE',
            'TRANSACTION_AMOUNT',
            'MDR',
            'NETT_AMOUNT',
            'ORGANIZATION_NAME',
            'ORGANIZATION_SHORTCODE',
            'PARTNERMERCHANTID',
            'MERCHANTTRXID',
        ];
    }

    public function bindValue(Cell $cell, $value)
    {
        if ($cell->getColumn() == 'A' || $cell->getColumn() == 'E' || $cell->getColumn() == 'J' || $cell->getColumn() == 'L') {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);

            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }
}
