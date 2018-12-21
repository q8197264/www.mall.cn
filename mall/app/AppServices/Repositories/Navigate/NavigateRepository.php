<?php
namespace App\AppServices\Repositories\Navigate;

use App\AppServices\Repositories\AbstractRepository;
use App\AppServices\Models\AdminNavigateModel;
use App\AppServices\Caches\Redis\AdminNavigateCache;

/**
 * 分类导航仓库.
 *
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:53
 */
class NavigateRepository extends AbstractRepository
{
    protected $adminNavigateModel;
    protected $adminNavigateCache;

    public function __construct(AdminNavigateModel $adminNavigateModel, AdminNavigateCache $adminNavigateCache)
    {
        $this->adminNavigateModel = $adminNavigateModel;
        $this->adminNavigateCache = $adminNavigateCache;
    }

    /**
     * 查询后台分类导航
     *
     * @return array
     */
    public function query():array
    {
        //从缓存中获取分类导航数据
        $data = (array) $this->adminNavigateCache->getAdminNavigate();
        if (empty($data)) {

            //从DB获取分类导航数据
            $data = (array) $this->adminNavigateModel->query();

            //存入缓存
            empty($data) || $this->adminNavigateCache->setAdminNavigate($data);
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
    public function add(int $pid, string $cname) :bool
    {
        $exists = $this->adminNavigateModel->exists($pid, $cname);
        if (empty($exists)) {
            $b = $this->adminNavigateModel->add($pid, $cname);
            $b && $this->adminNavigateCache->delAdminNavigate();//删除缓存
        } else {
            $b = true;
        }

        return $b;
    }

    public function edit(int $cid, string $cname) :bool
    {
        //存在则不更新
        //不存在则更新
        $b = $this->adminNavigateyModel->update($cid, $cname);

        return $b;
    }

    public function del(int $cid):bool
    {
        $b = $this->adminNavigateModel->del($cid);

        return $b;
    }
}