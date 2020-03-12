<?php

namespace Unite\UnisysApi\Modules\Export;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class DataExport implements WithMapping, WithHeadings, FromArray//, WithColumnFormatting
{
    use Exportable;

    protected $data;
    protected $keys;

    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function setKeys(array $keys)
    {
        $this->keys = $keys;

        return $this;
    }

    public function headings()
    : array
    {
        $result = [];

        foreach ($this->keys as $key) {
            $result[] = $key['name'];
        }

        return $result;
    }

//    public function columnFormats()
//    : array
//    {
//        return [
//            'B' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
//        ];
//    }

    public function map($item)
    : array
    {
        $result = [];

        foreach ($this->keys as $key) {
            $key = $key['key'];

            $resultItem = $item;
            foreach (explode('.', $key) as $keyPart) {
                $resultItem = $resultItem[$keyPart];
//                $result[] = Date::dateTimeToExcel($resultItem);
            }

            $result[] = $resultItem;
        }

        return $result;
    }

    public function array()
    : array
    {
        return $this->data;
    }
}