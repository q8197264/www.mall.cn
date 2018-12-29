<?php

namespace Services\Report\Format;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 01:04
 */
class Excel
{
    public function __construct()
    {
    }

    public function export(array $data, string $path)
    {
        $path .= time() . '.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', '订单编号');
        $sheet->setCellValue('B1', '商品名');
        $sheet->setCellValue('C1', '销量');
        foreach ($data as $k => $row) {
            $index = $k + 2;
            $sheet->setCellValue('A' . $index, $row->order_no);
            $sheet->setCellValue('B' . $index, $row->sku_name);
            $sheet->setCellValue('C' . $index, $row->number);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return $data;
    }

    public function import()
    {
        echo 'import';
    }
}