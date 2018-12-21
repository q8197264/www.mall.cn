<?php
namespace App\AppServices\Services\Category;

use Illuminate\Container\Container as App;

/**
 * goods category.
 *
 * User: sai
 * Date: 2018-12-11
 * Time: 16:43
 */
abstract class AbstractCategory
{
    protected static $categoryRepository;

    public function __construct(App $app)
    {
        if (empty(static::getCategoryRepository())) {
            static::$categoryRepository = $app->make('App\AppServices\Repositories\Category\CategoryRepository');
        }

        $this->initialize();
    }

    abstract protected function initialize();

    protected static function getCategoryRepository()
    {
        return static::$categoryRepository;
    }


    /**
     * 转化对象类型为数组类型
     * 注：只适合二维数组
     *
     * @param array $data
     *
     * @return array
     */
    protected function objectToArray(array $data):array
    {
        //把对象转为数组
        $data = array_map(function ($v) {return (array)$v;}, $data);

        //把数组列cid转为key
        $data = array_column($data, null, 'id');

        return $data;
    }

    /**
     * Recursive from array to archive
     *
     * @param array $data
     * @param int $type_id
     *
     * @return array
     */
    public function arrayRecursiveArchive(array $data, int $type_id=0, int $level=0):array
    {
        $res = [];
        foreach($data as $v) {
            if ($v['type_id'] == $type_id) {
                $v['placeholder'] = $level;
                isset($v['id']) && ($v['son'] = $this->arrayRecursiveArchive($data, $v['id'], $level+1));
                $res[] = $v;
            }
        }

        return $res;
    }
}