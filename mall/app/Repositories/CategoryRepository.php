<?php
namespace App\Repositories;

use App\Models\AdminCategoryModel;
use App\Caches\Redis\AdminCategoryCache;

/**
 * 分类导航仓库.
 *
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:53
 */
class CategoryRepository extends AbstractRepository
{
    protected $adminCategoryModel;
    protected $adminCategoryCache;

    public function __construct(AdminCategoryModel $adminCategoryModel, AdminCategoryCache $adminCategoryCache)
    {
        $this->adminCategoryModel = $adminCategoryModel;
        $this->adminCategoryCache = $adminCategoryCache;
    }

    /**
     * 查询后台分类导航
     *
     * @return array
     */
    public function queryAdminCategory():array
    {
        //从缓存中获取分类导航数据
        $data = (array) $this->adminCategoryCache->getCategory();
        if (empty($data)) {

            //从DB获取分类导航数据
            $data = (array) $this->adminCategoryModel->queryAdminCategory();

            //存入缓存
            empty($data) || $this->adminCategoryCache->setCategory($data);
        }

        return $data;
    }

    /**
     * 添加后台导航栏目
     *
     * @param int    $cid
     * @param string $cname
     *
     * @return mixed
     */
    public function addAdminCategory(int $pid, string $cname) :bool
    {
        $exists = $this->adminCategoryModel->existsCategory($pid, $cname);
        if (empty($exists)) {
            $b = $this->adminCategoryModel->addAdminCategory($pid, $cname);
            $b && $this->adminCategoryCache->delCategory();//删除缓存
        } else {
            $b = true;
        }

        return $b;
    }

    public function editAdminCategory(int $cid, string $cname) :bool
    {
        //存在则不更新
        //不存在则更新
        $b = $this->adminCategoryModel->updateAdminCategory($cid, $cname);

        return $b;
    }

    public function delAdminCategory(int $cid):bool
    {
        $b = $this->adminCategoryModel->delAdminCategory($cid);

        return $b;
    }
}