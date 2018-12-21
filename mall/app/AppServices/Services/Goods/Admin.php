<?php
namespace App\AppServices\Services\Goods;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-12-10
 * Time: 16:39
 */
class Admin extends AbstractGoods
{
    protected function initialize()
    {
        // TODO: Implement initialize() method.
    }

    /**
     *  TODO: 未使用
     * get goods info
     *
     * @param int $gid
     *
     * @return array
     */
    public function show(int $gid):array
    {
        return $this->getGoodsRespository()->queryGoodsById($gid);
    }

    /**
     * get goods base info list
     *
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function list(int $offset, int $limit):array
    {
        return $this->getGoodsRespository()->queryGoodsList($offset, $limit);
        
    }

    /**
     * get designate goods info
     *
     * @param int $gid
     *
     * @return array
     */
    public function info(int $gid):array
    {
        $res   = $this->getGoodsRespository()->queryGoodsSpuById($gid);
        $specs = $this->getGoodsRespository()->queryGoodsSpecById($gid);
        if (!empty($specs)) {
            $spec_value_ids = array_column($specs, 'spec_value_id');
            $sku = $this->getGoodsRespository()->queryGoodsSkuById($gid, $spec_value_ids);
            //$ids = array_intersect($spec_value_ids, array_column($sku, 'spec_value_id'));
            foreach ($sku as $u) {
                $spec_value_ids = explode(',', $u->spec_value_id);
                foreach ($specs as $spec) {
                    if ( in_array($spec->spec_value_id, $spec_value_ids) ) {
                        $res['sku'][$u->sku_id]['sku_id']  = $u->sku_id;
                        $res['sku'][$u->sku_id]['sku_name']= $u->sku_name;
                        $res['sku'][$u->sku_id]['price']   = $u->price;
                        $res['sku'][$u->sku_id]['sku_no']  = $u->sku_no;
                        $res['sku'][$u->sku_id]['stock']   = $u->stock;
                        $res['sku'][$u->sku_id]['shop_id'] = $u->shop_id;
                        $res['sku'][$u->sku_id]['images']  = $u->images;
                        $res['sku'][$u->sku_id]['status']  = $u->status;
                        $res['sku'][$u->sku_id]['spec'][]  = $spec;
                    }
                }
            }
        }

        return $res;
    }

    /**
     * get brand name
     *
     * @param int $brand_id
     *
     * @return mixed
     */
    public function getBrandName(int $brand_id)
    {
        $brand = $this->getGoodsRespository()->queryGoodsBrandById($brand_id);

        return $brand;
    }

    /**
     * add goods info
     *
     * @param array $data
     *
     * @return bool
     */
    public function add(array $data):bool
    {
        foreach ($data['spec'] as $v) {
//            'spec'
        }
//        exit;
        $data['spu_no'] = str_pad(str_shuffle('ABCDEFG'){0},4,0).rand(0,9);
        return $this->getGoodsRespository()->addGoodsWith($data);
    }

    /**
     * TODO: 未完待续
     *
     * @param int    $id
     * @param string $gname
     * @param float  $low_price
     * @param int    $cid
     * @param int    $bid
     *
     * @return bool
     */
    public function edit(int $id, string $gname, float $low_price, int $cid, int $bid):bool
    {
        return $this->getGoodsRespository()->editGoodsWith($id, $gname, $low_price, $cid, $bid);
    }
}