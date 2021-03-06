<?php
namespace App\AppServices\Models\Common;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * DB table config file.
 * User: sai
 * Date: 2018-12-23
 * Time: 01:14
 */
abstract class Config
{
    protected $users      = 'users';
    protected $user_auths = 'user_auths';

    public $goods_sku = 'goods_sku';
    public $goods_spu = 'goods_spu';

    public $order_info  = 'order_info';
    public $order_goods = 'order_goods';

    public $order_goods_comments = 'order_goods_comments';
    public $order_goods_comment_images = 'order_goods_comment_images';

    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }
}