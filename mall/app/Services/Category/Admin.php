<?php
namespace App\Services\Category;

/**
 * 后台分类导航.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:42
 */
class Admin extends AbstractCategory
{
    protected function initialize(){}

    /**
     * 查询分类导航列表
     *
     * @return array
     */
    public function showCategory():array
    {
        //获取分类导航数据
        $data = static::$categoryRespository->queryAdminCategory();

        //对象转为数组
        $data = $this->objectToArray($data);

        //把数组元素分类归档
        //      $data = $this->arrayRecursiveArchive($data, 0);
        $data = $this->generateTree($data);

        return $data;
    }

    /**
     * 添加分类
     *
     * @param int    $cid
     * @param string $cname
     *
     * @return mixed
     */
    public function addCategory(int $pid, string $cname):bool
    {
        return static::$categoryRespository->addAdminCategory($pid, $cname);
    }

    /**
     * 更新分类
     *
     * @param int    $cid
     * @param string $cname
     *
     * @return mixed
     */
    public function editCategory(int $cid, string $cname):bool
    {
        return static::$categoryRespository->editAdminCategory($cid, $cname);
    }

    /**
     * 删除分类
     *
     * @param int $cid
     *
     * @return mixed
     */
    public function delCategory(int $cid)
    {
        return static::$categoryRespository->delAdminCategory($cid);
    }
}