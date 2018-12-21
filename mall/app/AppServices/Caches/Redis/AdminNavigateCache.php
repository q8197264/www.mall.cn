<?php
namespace App\AppServices\Caches\Redis;

use Illuminate\Support\Facades\Redis;

/**
 * Created by PhpStorm.
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 13:31
 */
class AdminNavigateCache
{
    const KEY = 'admin:category';
    const DATABASE = 0;

    public function getAdminNavigate()
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
    public function setAdminNavigate(array $data)
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
    public function delAdminNavigate()
    {
        $b = Redis::del(self::KEY);
        
        return $b;
    }
}