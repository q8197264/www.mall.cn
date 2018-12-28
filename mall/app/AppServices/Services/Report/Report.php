<?php
namespace Services\Report;

use Exception;
use Services\Report\AbstractBase\AbstractCall;

use Repositories;
/**
 * Created by PhpStorm.
 * User: sai
 * Date: 2018-12-28
 * Time: 17:18
 */
class Report extends AbstractCall
{
    //实现连贯操作
    const ActionNamespace = 'Services\Report\Action';

    public function __construct()
    {
    }

    public function show()
    {
        dd('show');
    }
}