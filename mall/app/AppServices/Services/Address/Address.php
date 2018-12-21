<?php
namespace App\AppServices\Services\Address;

/**
 * address.
 *
 * User: sai
 * Date: 2018-12-19
 * Time: 21:10
 */
class Address extends AbstractAddress
{
    public function initialize(){}

    /**
     * get address list with user
     *
     * @param int $uid
     * @param int $offset
     * @param int $limit
     *
     * @return mixed
     */
    public function findListByUid(int $uid, int $limit)
    {
        $res = $this->getAddressRepository()->getListByUid($uid, $limit);

        return $res;
    }

    /**
     * get default address by uid
     *
     * @param int $uid
     *
     * @return mixed
     */
    public function findDefaultByUid(int $uid)
    {
        $res = $this->getAddressRepository()->getDefaultByUid($uid);

        return $res;
    }

    /**
     * add an address with uid
     *
     * @param array $parameters
     *
     * @return int
     */
    public function add(array $parameters):int
    {
        $id = $this->getAddressRepository()->add($parameters);

        return $id;
    }

    /**
     * Set default address
     *
     * @param int $id
     * @param int $uid
     *
     * @return bool
     */
    public function setDefault(int $id, int $uid):bool
    {
        $bool = $this->getAddressRepository()->updateDefaultById($id, $uid);

        return $bool;
    }

    /**
     * modify user by id
     */
    public function modify(array $data) :bool
    {
        $bool = $this->getAddressRepository()->updateById($data);

        return $bool;
    }

    /**
     * delete address by id
     */
    public function remove(int $id, int $user_id)
    {
        $bool = $this->getAddressRepository()->delById($id, $user_id);

        return $bool;
    }
}