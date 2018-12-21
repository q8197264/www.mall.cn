<?php
namespace App\AppServices\Models;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * Order Model.
 * User: sai
 * Date: 2018-12-21
 * Time: 12:19
 */
class OrderModel
{
    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    public function add()
    {}
}