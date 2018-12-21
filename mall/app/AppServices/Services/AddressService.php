<?php
namespace App\AppServices\Services;

use App\AppServices\Services\Address\admin;
use App\AppServices\Services\Address\Address;

/**
 * Address manager.
 * User: sai
 * Date: 2018-12-19
 * Time: 21:29
 */
class AddressService
{
    protected $admin;
    protected $address;

    public function __construct(Admin $admin, Address $address)
    {
        $this->admin   = $admin;
        $this->address = $address;
    }

    /**
     * get address list with uid
     *
     * @param int $uid
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
    public function findListByUid(int $uid, int $limit=5)
    {
        $res = $this->address->findListByUid($uid, $limit);

        return $res;
    }

    /**
     * get only one default address row data by uid
     *
     * @param int $uid
     *
     * @return mixed
     */
    public function findDefaultByUid(int $uid=0)
    {
        $res = $this->address->findDefaultByUid($uid);

        return $res;
    }

    /**
     * add address row data range user_id
     *
     * @param int    $user_id
     * @param string $username
     */
    public function add(array $parameters=[]):int
    {
        $sort = array_flip([
            'user_id',
            'name',
            'tel',
            'phone',
            'province',
            'city',
            'district',
            'address',
        ]);
        $parameters = array_merge(array_intersect_key($sort,$parameters),$parameters);
        $id = $this->address->add($parameters);

        return $id;
    }

    /**
     * edit address info
     *
     * @param array $data
     */
    public function edit(array $data)
    {
        $bool = $this->address->modify($data);

        return $bool;
    }

    /**
     * delete address by id
     *
     * @param int $id
     * @param int $user_id
     *
     * @return bool
     */
    public function del(int $id, int $user_id):bool
    {
        $bool = $this->address->remove($id, $user_id);

        return $bool;
    }

    /**
     * Set default address
     *
     * @param int $id
     * @param int $user_id
     *
     * @return bool
     */
    public function setDefault(int $id, int $user_id):bool
    {
        $bool = $this->address->setDefault($id, $user_id);

        return $bool;
    }
}