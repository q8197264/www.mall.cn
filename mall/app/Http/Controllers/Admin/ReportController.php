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
        $res = $this->services->export('2018-09-12 10:30:3','2019-09-10 10:20:12')
            ->excel('style')
            ->save('/www/www.mall.cn/mall/storage/');

        dd($res);

        echo 'list';
    }

    /**
     * @param int $offset
     */
    public function list(int $offset = 0)
    {
        //$this->services->report()->export()->excel()->save();
        $this->services->excel();
    }
}