<?php
namespace App\AppServices\Repositories\Address;

use App\AppServices\Models\AddressModel;

/**
 * address .
 *
 * User: sai
 * Date: 2018-12-19
 * Time: 22:03
 */
class AddressRepository
{
    protected $addressModel;

    public function __construct(AddressModel $addressModel)
    {
        $this->addressModel = $addressModel;
    }

    /**
     * get address row data by uid
     *
     * @param int $uid
     * @param int $limit
     *
     * @return mixed
     */
    public function getListByUid(int $uid, int $limit)
    {
        $res = $this->addressModel->getListByUid($uid, $limit);

        return $res;
    }

    /**
     * get only one address row data by uid
     *
     * @param int $uid
     *
     * @return mixed
     */
    public function getDefaultByUid(int $uid)
    {
        $row = $this->addressModel->getDefaultByUid($uid);

        return $row;
    }

    /**
     * add an address
     *
     * @param array $parameters
     *
     * @return int
     */
    public function add(array $parameters): int
    {
        $row = $this->getDefaultByUid($parameters['user_id']);

        //only one adress set default
        $parameters['selected'] = empty($row)?1:0;

        $id = $this->addressModel->add($parameters);

        return $id;
    }

    /**
     * Set default address
     *
     * @param int $id
     * @param int $uid
     */
    public function updateDefaultById(int $id, int $uid):bool
    {
        $bool = $this->addressModel->updateDefaultById($id, $uid);

        return $bool;
    }

    /**
     * Delete address by id and user_id
     *
     * @param int $id
     * @param int $uid
     *
     * @return bool
     */
    public function delById(int $id, int $uid):bool
    {
        $bool = $this->addressModel->delById($id, $uid);

        return $bool;
    }
}