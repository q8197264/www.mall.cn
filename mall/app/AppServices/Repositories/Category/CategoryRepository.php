<?php
namespace App\AppServices\Repositories\Category;

use App\AppServices\Models\CategoryModel;
use App\AppServices\Caches\Redis\AdminCategoryCache;
use App\AppServices\Repositories\AbstractRepository;

/**
 * category repo.
 *
 * User: sai
 * Date: 2018-12-11
 * Time: 16:56
 */
class CategoryRepository extends AbstractRepository
{
    private $categoryModel;
    private $adminCategoryCache;

    public function __construct(CategoryModel $categoryModel, AdminCategoryCache $adminCategoryCache)
    {
        $this->adminCategoryCache = $adminCategoryCache;
        $this->categoryModel      = $categoryModel;
    }

    /**
     * category
     *
     * @return mixed
     */
    public function show()
    {
        $data = $this->categoryModel->query();

        return $data;
    }

    /**
     * add category row data
     *
     * @param int $type_id
     * @param string $category_name
     *
     * @return bool
     */
    public function add(int $type_id, string $category_name):bool
    {
        return $this->categoryModel->add($type_id, $category_name);
    }

    /**
     * del category row data
     *
     * @param int $id
     *
     * @return bool
     */
    public function del(int $id):bool
    {
        return $this->categoryModel->del($id);
    }

    /**
     * edit category row data
     *
     * @param int $id
     * @param int $tid
     * @param string $category_name
     *
     * @return bool
     */
    public function edit(int $id, int $tid, string $category_name):bool
    {
        return $this->categoryModel->edit($id, $tid, $category_name);
    }
}