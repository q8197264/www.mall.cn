<?php
namespace App\AppServices\Services\Navigate;

/**
 * 后台分类导航.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:42
 */
class Admin extends AbstractNavigate
{
    protected function initialize(){}

    /**
     * 查询分类导航列表
     *
     * @return array
     */
    public function show():array
    {
        //获取分类导航数据
        $data = static::$navigateRepository->query();

        //对象转为数组
        $data = $this->objectToArray($data);

        //把数组元素分类归档
        //$data = $this->arrayRecursiveArchive($data, 0);
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
    public function add(int $pid, string $cname):bool
    {
        return static::$navigateRepository->add($pid, $cname);
    }

    /**
     * 更新分类
     *
     * @param int    $cid
     * @param string $cname
     *
     * @return mixed
     */
    public function edit(int $cid, string $cname):bool
    {
        return static::$navigateRepository->edit($cid, $cname);
    }

    /**
     * 删除分类
     *
     * @param int $cid
     *
     * @return mixed
     */
    public function del(int $cid):bool
    {
        return static::$navigateRepository->del($cid);
    }
}