<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-27
 * Time: 21:56
 */
class ReportController extends Controller
{
    public function __construct()
    { }

    /**
     * export excel file
     *
     * @param Request $request
     */
    public function export(Request $request)
    {
        $begin = $request->input('begin');
        $end = $request->input('end');


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Welcome to Helloweba.');

        $writer = new Xlsx($spreadsheet);
        $writer->save('hello.xlsx');

        dd('ok');
    }

    /**
     * @param int $offset
     */
    public function list(int $offset = 0)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Welcome to Helloweba.');

        $writer = new Xlsx($spreadsheet);
        $writer->save('/www/www.mall.cn/mall/storage/hello.xlsx');

        echo 'list';
    }
}