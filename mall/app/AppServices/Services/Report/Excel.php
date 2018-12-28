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
    public function __construct($d, $e=null, $f=null, $g=null)
    {
    }

    public function export(string $path)
    {
        $path.='hello_world.xlsx';

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Welcome to Helloweba.');

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return 'success';
    }

    public function import()
    {}
}