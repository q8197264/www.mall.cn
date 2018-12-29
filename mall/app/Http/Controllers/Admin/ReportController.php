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

        //告诉浏览器输出07Excel文件
//        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//        //header('Content-Type:application/vnd.ms-excel');//告诉浏览器将要输出Excel03版本文件
//        header('Content-Disposition: attachment;filename="01simple.xlsx"');//告诉浏览器输出浏览器名称
//        header('Cache-Control: max-age=0');//禁止缓存

        $path = '/www/www.mall.cn/mall/storage/';
        $data = $this->services->report()->export()->fetch('2018-12-22 12:21:25','2018-12-27 10:22:50')
            ->excel()->save($path);
        echo '报表保存路径:'.$path;
        dd($data);
    }

    /**
     * show sales
     *
     * @param int $offset
     */
    public function list(int $offset = 0)
    {
        $data = $this->services->report()->export()->fetch('2018-12-22 12:21:25','2018-12-27 10:22:50')->data;
//            ->excel()->save('/www/www.mall.cn/mall/storage/');
//        dd($res);
        return view('admin.report.report', ['data'=>$data]);
    }
}