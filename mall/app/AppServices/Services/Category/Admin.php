<?php
namespace App\AppServices\Services\Category;

/**
 * category admin.
 *
 * User: sai
 * Date: 2018-12-11
 * Time: 16:44
 */
class Admin extends AbstractCategory
{
    public function initialize(){}

    public function show():array
    {
        $data = $this->getCategoryRepository()->show();

        //DB rows conversion to archive array
        $data = $this->objectToArray($data);
        $data = $this->arrayRecursiveArchive($data);

        return $data;
    }

    public function add(int $tid, string $cname):bool
    {
        return $this->getCategoryRepository()->add($tid, $cname);
    }

    public function edit(int $id, int $tid, string $cname):bool
    {
        return $this->getCategoryRepository()->edit($id, $tid, $cname);
    }

    public function del(int $id):bool
    {
        return $this->getCategoryRepository()->del($id);
    }
}