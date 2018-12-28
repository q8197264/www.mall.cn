<?php

namespace App\AppServices\Models;

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
                       ^                ^
                       |1:n             |1:n
                goods_spu_spec        goods_sku
                (商品规格关系表)        (库存表sku )
                       |n:1               ^
                       v                  |1:n
                    goods_spec       goods_sku_spec_value
                    (商品规格表)   (spu_id, spec_value_id关系表)
                   颜色/尺寸/内存            |
                       ^                   |n:1
                       |1:n                v
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
    //商品
    protected $goods_spu        = 'goods_spu';

    protected $goods_brand      = 'goods_brand';
    protected $shop_info        = 'shop_info';

    //商品规格
    protected $goods_spu_spec   = 'goods_spu_spec';
    protected $goods_spec       = 'goods_spec';
    protected $goods_spec_value = 'goods_spec_value';

    //商品库存
    protected $goods_sku            = 'goods_sku';
    protected $goods_sku_spec_value = 'goods_sku_spec_value';

    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    /**
     * get all goods list
     * id goods_name goods_no band_name 「price stock」 sale status/上架
     * spu brand
     *
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function queryGoodsList(int $offset, int $limit):array
    {
        $sql = <<<EOF
            SELECT
                p.`id`,
                p.`goods_name`,
                p.`category_id`,
                p.`spu_no`,
                p.`low_price`,
                p.`brand_id`,
                k.`status`,
                k.`price`,
                k.`shop_id`,
                k.`stock`,
                k.`images`   
            FROM
                `goods_sku` k
                INNER JOIN `goods_spu` p ON k.`spu_id` = p.`id` 
            WHERE
                k.`id` >= ( SELECT id FROM `goods_sku` WHERE `status`=0 ORDER BY id LIMIT ?, 1 )
                LIMIT ?
EOF;

        $list = $this->slave->select($sql, [$offset, $limit]);

        return $list;
    }

    /**
     * get designate goods info
     *
     * @param int $gid
     *
     * @return array
     */
    public function queryGoodsById(int $gid):array
    {
        $sql = <<<EOF
            SELECT
                p.`id`,
                p.`goods_name`,
                p.`category_id`,
                p.`spu_no`,
                p.`low_price`,
                s.`spec_name`,
                s.`spec_no`,
                sv.`spec_value`,
                u.`sku_name`,
                u.`sku_no`,
                u.`price`,
                u.`stock`,
                u.`shop_id`,
                u.`images`,
                u.`status` 
            FROM
                `goods_spu` p
                LEFT JOIN `goods_spu_spec` pe ON p.`id` = pe.`spu_id`
                LEFT JOIN `goods_spec` s ON pe.`spec_id` = s.`id`
                LEFT JOIN `goods_spec_value` sv ON pe.`spec_id` = sv.`spec_id`
                LEFT JOIN `goods_sku` u ON u.`spu_id` = p.`id`
                LEFT JOIN `goods_sku_spec_value` usv ON u.`id` = usv.`sku_id`
            WHERE p.`id`=?
EOF;
        $data = $this->slave->select($sql, [$gid]);

        return $data;
    }

    /**
     * get goods
     *
     * @param int $gid
     *
     * @return array
     */
    public function queryGoodsSpuById(int $gid):array
    {
        $sql = <<<EOF
            SELECT
                p.`id`,
                p.`goods_name`,
                p.`category_id`,
                p.`spu_no`,
                p.`low_price` ,
                p.`brand_id` 
            FROM `{$this->goods_spu}` p
            WHERE p.`id`=? 
            LIMIT 1
EOF;
        $info = $this->slave->select($sql, [$gid]);

        return (array) array_pop($info);
    }

    /**
     * get designate goods spec
     *
     * @param int $gid      spu_id 商品
     *
     * @return array        商品规格如：选择颜色 选择尺码 型号 内存等
     */
    public function queryGoodsSpecById(int $gid):array
    {
        $sql = <<<EOF
            SELECT 
                s.`id` spec_id,
                s.`spec_name`,
                s.`spec_no`,
                sv.`id` spec_value_id,
                sv.`spec_value` 
            FROM `{$this->goods_spec}` s
            LEFT JOIN `{$this->goods_spu_spec}` ss ON ss.`spec_id` = s.`id`
            LEFT JOIN `{$this->goods_spec_value}` sv ON ss.`spec_id` = sv.`spec_id`
            WHERE ss.`spu_id`=?
EOF;
        $spec = $this->slave->select($sql, [$gid]);

        return $spec;
    }

    /**
     * get designate goods sku
     *
     * @param int   $gid
     * @param array $ids        spec_value_id
     *
     * @return mixed
     */
    public function queryGoodsSkuById(int $gid, array $spec_value_ids)
    {
        $placeholder = trim(str_repeat('?,',count($spec_value_ids)),',');
        $sql = <<<EOF
            SELECT
                u.`id` `sku_id`,
                group_concat(usv.`spec_value_id`) as `spec_value_id`,
                u.`id` as sku_id,
                u.`spu_id`,
                u.`sku_name`,
                u.`sku_no`,
                u.`price`,
                u.`stock`,
                u.`shop_id`,
                u.`images`,
                u.`status` 
            FROM
                `goods_sku` u
                LEFT JOIN `goods_sku_spec_value` usv ON u.`id` = usv.`sku_id` 
            WHERE
                usv.`spec_value_id` IN ( {$placeholder} ) 
                AND u.`spu_id` =?
            GROUP BY u.`id`
EOF;
        array_push($spec_value_ids, $gid);
        $rows = $this->slave->select($sql, $spec_value_ids);

        return $rows;
    }

    /**
     * get goods sku only one row
     *
     * @param int $sku_id
     * @param int $spu_id
     * @param int $shop_id
     *
     * @return array
     */
    public function getSkuById(int $sku_id, int $spu_id, int $shop_id):array
    {
        $sql = <<<EOF
            SELECT
                `sku_name`,
                `price`,
                `stock`,
                `images` 
            FROM
                `goods_sku` 
            WHERE
                `id` =? 
                AND `spu_id` =? 
                AND `shop_id` =?
EOF;
        $row = $this->slave->select($sql, [$sku_id, $spu_id, $shop_id]);

        return (array) array_pop($row);
    }

    /**
     * get goods spec and spec_value by sku_id
     *
     * @param int $sku_id
     *
     * @return mixed
     */
    public function getSpecBySkuid(array $sku_ids)
    {
        $placeholder = trim(str_repeat(',?', count($sku_ids)), ',');
        $sql = <<<EOF
            SELECT
                spv.`sku_id`,
                p.`spec_no`,
                p.`spec_name`,
                pv.`spec_value` 
            FROM
                `{$this->goods_sku_spec_value}` spv
                INNER JOIN `{$this->goods_spec_value}` pv ON spv.`spec_value_id` = pv.`id` 
                INNER JOIN `{$this->goods_spec}` p ON pv.`spec_id` = p.`id` 
                  AND spv.`sku_id` IN ($placeholder)
EOF;
        $res = $this->slave->select($sql, $sku_ids);

        return $res;
    }

    public function save(){}

    /**
     * Get shop name
     *
     * @param int $shop_id
     *
     * @return array
     */
    public function queryGoodsShopById(int $shop_id) :array
    {
        $sql = <<<EOF
            SELECT `shop_name` FROM `{$this->shop_info}` WHERE `id`=? LIMIT 1
EOF;
        $row = $this->slave->select($sql, [$shop_id]);

        return (array) array_pop($row);
    }

    /**
     *
     * @param int $brand_id
     *
     * @return mixed
     */
    public function queryGoodsBrandById(int $brand_id):string
    {
        $sql = <<<EOF
            SELECT 
              `brand_name` 
            FROM `{$this->goods_brand}`
            WHERE `id`=? 
            LIMIT 1
EOF;
        $res = $this->slave->select($sql,[$brand_id]);

        $brand_name = empty($res)?'其它':array_pop($res)->brand_name;
        return $brand_name;
    }

    /**
     * 添加商品
     *
     * @param array $data
     *
     * @return bool
     */
    public function addGoodsWith(array $data): bool
    {
        $sku_id = $this->master->transaction(function () use ($data) {
            $spu_id = $this->master->table($this->goods_spu)->insertGetId([
                'spu_no'      => $data['spu_no'],
                'goods_name'  => $data['goods_name'],
                'description' => $data['description'],
                'low_price'   => $data['low_price'],
                'category_id' => $data['category_id'],
                'brand_id'    => $data['brand_id']
            ]);
            foreach ($data['spec'] as $v) {
                $this->master->table($this->goods_spu_spec)->insert([
                    'spu_id'  => $spu_id,
                    'spec_id' => $v
                ]);
            }
            $sku_id = $this->master->table($this->goods_sku)->insertGetId([
                'sku_name'  => $data['sku_name'],//$data['goods_name']
                'price'     => $data['low_price'],
                'stock'     => $data['stock'],
                'shop_id'   => $data['shop_id'],
                'spu_id'    => $spu_id,
                'images'    => ''
            ]);
            foreach ($data['spec_value'] as $v) {
                $this->master->table($this->goods_sku_spec_value)->insertGetId([
                    'sku_id' => $sku_id,
                    'spec_value_id'=>$v
                ]);
            }
            return $sku_id;
        }, 5);

        return empty($sku_id) ? false : true;
    }

    /**
     * TODO: 未完待续
     */
    public function editGoodsWith()
    {
        DB::transaction(function () {
            $this->updateSpu();
            $this->updateSpec();
            $this->updateSku();
        });
    }

    public function updateSpu(int $id, string $gname, float $low_price, int $cid, int $bid): bool
    {

        $sql = <<<EOF
            UPDATE `{$this->goods_spu}` 
            SET 
                `goods_name`=?,
                `low_price`=?,
                `category_id`=?,
                `brand_id`=?,
                `updated_at`=? 
            WHERE 
                `id`=? 
                LIMIT 1
EOF;
        return $this->master->update($sql, [$gname, $low_price, $cid, $bid, date('Y-m-d H:i:s', time()), $id]);
    }

    public function updateSpec()
    {
    }

    public function updateSku()
    {
    }
}