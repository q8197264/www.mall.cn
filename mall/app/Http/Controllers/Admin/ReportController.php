<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Services\Services;

/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-27
 * Time: 21:56
 */
class ReportController extends Controller
{


    public function __construct(Services $services)
    {
        $this->services = $services;
    }

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
        $res = $this->services->export('2018-09-12 10:30:3','2019-09-10 10:20:12')
            ->excel('style')
            ->save('/www/www.mall.cn/mall/storage/');

        dd($res);

        echo 'list';
    }
}