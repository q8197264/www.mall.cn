<?php
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 01:04
 */

namespace Services\Report;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
    public function __construct($d, $e, $f, $g)
    {
        var_dump(func_get_args());
    }

    public function export(string $path)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Welcome to Helloweba.');

        $writer = new Xlsx($spreadsheet);
        $writer->save('/www/www.mall.cn/mall/storage/hello.xlsx');

        return 'success';
    }

    public function import()
    {}
}