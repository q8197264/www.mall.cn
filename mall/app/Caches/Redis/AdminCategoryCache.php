<?php
namespace App\Caches\Redis;

use Illuminate\Support\Facades\Redis;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 13:31
 */
class AdminCategoryCache
{
    const KEY = 'admin:category';
    const DATABASE = 0;

    public function getCategory()
    {
        $data = Redis::get(self::KEY);
        $data = json_decode($data);

        return $data;
    }

    /**
     * hash
     * field1 field2 field3
     * value1 value2 value3
     *
     * @param array $data
     *
     * @return bool
     */
    public function setCategory(array $data)
    {
        $data = json_encode($data);
        $b = Redis::set(self::KEY, $data);

        return $b->getPayload();
    }

    /**
     * del
     *
     * @return mixed
     */
    public function delCategory()
    {
        $b = Redis::del(self::KEY);
        
        return $b;
    }
}