<?php
namespace App\AppServices\Models;

use App\User;
use Illuminate\Support\Facades\DB;

/**
 * category model.
 *
 * User: liuxiaoquan
 * Date: 2018-12-03
 * Time: 12:08
 */
class CategoryModel
{
    protected $goods_categories = 'goods_categories';

    protected $master;
    protected $slave;

    public function __construct()
    {
        $this->master = DB::connection('mysql::write');
        $this->slave  = DB::connection('mysql::read');
    }

    /**
     * navigate list
     *
     * @return mixed
     */
    public function query()
    {
        $sql = <<<EOF
            select `id`,`type_id`,`category_name` from `{$this->goods_categories}` WHERE `display`=0
EOF;
        $data = $this->slave->select($sql);

        return $data;
    }

    public function queryCategoryById(int $cid):array
    {
        $sql = <<<EOF
            SELECT 
                `id`,`type_id`,`category_name`,`display` 
            FROM 
                `{$this->goods_categories}` 
            WHERE 
                `id`=?
EOF;
        $res = $this->slave->select($sql, [$cid]);

        return (array) array_pop($res);
    }

    /**
     * add category date only row
     *
     * @param int $type_id
     * @param string $category_name
     * @return mixed
     */
    public function add(int $type_id, string $category_name):bool
    {
        $sql = <<<EOF
            INSERT INTO `{$this->goods_categories}`(
              `type_id`,
              `category_name`,
              `created_at` 
            ) VALUE(
              ?,?,?
            )
EOF;
        return $this->master->insert($sql, [$type_id, $category_name, date('Y-m-d H:i:s',time())]);
    }

    /**
     * edit category data only row
     *
     * @param int $id
     * @param string $category_name
     * @return bool
     */
    public function edit(int $id, int $type_id, string $category_name):bool
    {
        $sql = <<<EOF
            UPDATE `{$this->goods_categories}` SET `type_id`=?,`category_name`=? WHERE `id`=? LIMIT 1
EOF;
        return $this->master->update($sql, [$type_id, $category_name, $id]);
    }

    /**
     * del category data only row
     *
     * @param int $id
     * @return bool
     */
    public function del(int $id):bool
    {
        $sql = <<<EOF
            UPDATE `{$this->goods_categories}` SET `display`=1 WHERE `id`=? LIMIT 1
EOF;
        return $this->master->update($sql, [$id]);
    }
}