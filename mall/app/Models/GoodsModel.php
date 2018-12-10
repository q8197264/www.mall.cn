<?php
namespace App\Models;

use App\User;
use Illuminate\Support\Facades\DB;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Collection;

/*------------------------
                 goods_categories   goods_brand
                    (商品分类表)     (商品品牌表)
                         ^            ^
                         |1:1         |1:1
                            goods_spu
                            (商品表)
                       ^                  ^
                       |1:n               |
                goods_spu_spec        goods_sku
                (商品规格关系表)        (库存表)
                       |n:1               ^
                       v                  |1:n
                    goods_spec      goods_sku_spec_value
                    (商品规格表)         (商品sku)
                   颜色/尺寸/内存           |
                           ^               |n:1
                           |1:n            v
                            goods_spec_value
                       (商品规格值)红~白/13~15/64~125

*/


/**
 * 商品数据库sql层.
 * User: liuxiaoquan
 * Date: 2018-11-26
 * Time: 22:11
 */
class GoodsModel
{
    //商品规格
    protected $goods_spu        = 'goods_spu';
    protected $goods_spu_spec   = 'goods_spu_spec';
    protected $goods_spec       = 'goods_spec';
    protected $goods_spec_value = 'goods_spec_value';

    //商品库存
    protected $goods_sku        = 'goods_sku';
    protected $goods_sku_spec_value = 'goods_sku_spec_value';

    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    public function queryGoodsList(int $gid)
    {
        //商品 + 规格
        $sql = <<<EOF
            SELECT * FROM `{$this->goods_spu}` p 
            LEFT JOIN `{$this->goods_spu_spec}` s 
            LEFT JOIN `{$this->goods_spec}` e 
            LEFT JOIN `{$this->goods_spec_value}` v
                ON p.`id`=s.`spu_id` 
                WHERE  p.`id`=? 
EOF;
        $list = $this->slave->select($sql);
        
        return $list;
    }
    
    public function 
}