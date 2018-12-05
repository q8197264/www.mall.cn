<?php
namespace App\Services\Category;

use Illuminate\Container\Container as App;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 11:50
 */
abstract class AbstractCategory
{
    public static $categoryRespository;

    final function __construct(App $app)
    {
        if (empty(static::$categoryRespository)) {
            static::$categoryRespository = $app->make('App\Repositories\CategoryRepository');
        }

        $this->initialize();
    }

    abstract protected function initialize();

    /**
     * 转化对象类型为数组类型
     * 注：只适合二维数组
     *
     * @param array $data
     *
     * @return array
     */
    protected function objectToArray(array $data)
    {
        //把对象转为数组
        $data = array_map(function ($v) {return (array)$v;}, $data);

        //把数组列cid转为key
        $data = array_column($data, null, 'cid');

        return $data;
    }

    /**
     * 递归实现无限极分类
     *
     * 缺点：由于递归有次数限制，且内存会叠加，只适合少量数据
     * 优点：简单，代码量少
     * @param $data         分类导航数据
     * @param $pid          分类id
     *
     * @return array
     */
    protected function arrayRecursiveArchive(array $data, int $pid)
    {
        $arr = array();
        foreach ($data as $v) {
            if (isset($v->pid) && $v->pid == $pid) {
                if (isset($v->cid)) {
                    $v['son'] = $this->arrayRecursiveArchive($data, $v->cid);
                }
                $arr[] =$v;
            }
        }

        return $arr;
    }

    /**
     * 引用实现无限极分类
     *
     * 缺点：不易理解
     * 优点：适合处理大量数据，推荐使用
     *
     * @param $data         分类导航数据
     *
     * @return array
     */
    protected function generateTree(array $data)
    {
        $tree = array();
        foreach($data as $item){
            if (isset($data[$item['pid']])) {
                $data[$item['pid']]['son'][] = &$data[$item['cid']];
            } else {
                $tree[] = &$data[$item['cid']];
            }
        }

        return $tree;
    }
}