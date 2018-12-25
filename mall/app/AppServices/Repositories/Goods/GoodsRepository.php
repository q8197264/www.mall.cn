<?php
namespace App\AppServices\Repositories\Goods;

use App\AppServices\Models\CategoryModel;
use App\AppServices\Models\GoodsModel;

/**
 * 商品数据模型.
 * User: liuxiaoquan
 * Date: 2018-12-10
 * Time: 17:46
 */
class GoodsRepository
{
    protected $goodsModel;
    protected $categoryModel;

    public function __construct(GoodsModel $goodsModel, CategoryModel $categoryModel)
    {
        $this->goodsModel    = $goodsModel;
        $this->categoryModel = $categoryModel;
    }

    /**
     * TODO: 获取指定商品base信息 (未完成 )
     * get designated goods info
     *
     * @param int $gid
     *
     * @return array
     */
//    public function queryGoodsById(int $gid):array
//    {
//        $res = $this->goodsModel->queryGoodsSpuById($gid);
//        $res['spec'] = $this->goodsModel->queryGoodsSpecById($gid);
//        $spec_value_ids = array_column($res['spec'], 'spec_value_id');
//        $sku = $this->goodsModel->queryGoodsSkuById($gid, $spec_value_ids);
//
//        return $res;
//    }

    /**
     * get designate goods spu
     *
     * @param int $gid
     *
     * @return array
     */
    public function queryGoodsSpuById(int $gid):array
    {
        $res = $this->goodsModel->queryGoodsSpuById($gid);
        if (!empty($res)) {
            $res['brand_name'] = $this->goodsModel->queryGoodsBrandById($res['brand_id']);
            $category = $this->categoryModel->queryCategoryById($res['category_id']);
            $res['category_name'] = $category['category_name'];
        }

        return $res;
    }

    /**
     * get designate goods spec
     *
     * @param int $gid
     *
     * @return array
     */
    public function queryGoodsSpecById(int $gid):array
    {
        $res = $this->goodsModel->queryGoodsSpecById($gid);

        return $res;
    }

    /**
     * get designate goods sku
     *
     * @param int   $gid
     * @param array $spec_value_ids
     *
     * @return mixed
     */
    public function queryGoodsSkuById(int $gid, array $spec_value_ids)
    {
        $sku = $this->goodsModel->queryGoodsSkuById($gid, $spec_value_ids);

        return $sku;
    }

    /**
     *   get goods brand name
     *
     * @param int $brand_id
     *
     * @return mixed
     */
    public function queryGoodsBrandById(int $brand_id):string
    {
        $brand = $this->goodsModel->queryGoodsBrandById($brand_id);

        return $brand;
    }

    /**
     * get goods list with base info
     *
     * @param int $offset
     * @param int $limit
     *
     * @return array
     */
    public function queryGoodslist(int $offset, int $limit): array
    {
        $list = $this->goodsModel->queryGoodsList($offset, $limit);
        foreach ($list as $k=>$row) {
            $list[$k]->brand_name  = $this->goodsModel->queryGoodsBrandById($row->brand_id);
            $list[$k]->shop_name   = $this->goodsModel->queryGoodsShopById($row->shop_id)['shop_name'];
        }

        return $list;
    }

    /**
     * add goods
     *
     * @param array $data
     *
     * @return bool
     */
    public function addGoodsWith(array $data):bool
    {
        return $this->goodsModel->addGoodsWith($data);
    }

    /**
     * TODO: 更新商品信息 (未完待续)
     *
     * @param int    $id
     * @param string $gname
     * @param float  $low_price
     * @param int    $cid
     * @param int    $bid
     *
     * @return bool
     */
    public function editGoodsWith(int $id, string $gname, float $low_price, int $cid, int $bid):bool
    {
        $this->goodsModel->editGoodsWith($id, $gname, $low_price, $cid, $bid);

        return false;
    }
}