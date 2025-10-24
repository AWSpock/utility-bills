<?php
require_once("/var/www/utility-bills/php/DataAccess/Database.php");
require_once("/var/www/utility-bills/php/DataAccess/Repositories/AddressRepository.php");
require_once("/var/www/utility-bills/php/DataAccess/Repositories/BillTypeRepository.php");
require_once("/var/www/utility-bills/php/DataAccess/Repositories/BillRepository.php");

class DataAccess
{
    private $db;
    private $addressRepository = [];
    private $BillTypeRepository = [];
    private $BillRepository = [];

    public function __construct(mysqli $db = null)
    {
        $this->db = $db ?? new DatabaseV2();
    }

    public function addresses($userid)
    {
        if (!array_key_exists($userid, $this->addressRepository)) {
            $this->addressRepository[$userid] = new AddressRepository($this->db, $userid);
        }
        return $this->addressRepository[$userid];
    }

    public function bill_types($address_id)
    {
        if (!array_key_exists($address_id, $this->BillTypeRepository)) {
            $this->BillTypeRepository[$address_id] = new BillTypeRepository($this->db, $address_id);
        }
        return $this->BillTypeRepository[$address_id];
    }

    public function bills($address_id, $bill_type_id)
    {
        if (!array_key_exists($address_id . "-" . $bill_type_id, $this->BillRepository)) {
            $this->BillRepository[$bill_type_id] = new BillRepository($this->db, $address_id, $bill_type_id);
        }
        return $this->BillRepository[$bill_type_id];
    }

    //

    public function beginTransaction()
    {
        $this->db->beginTransaction();
    }
    public function commit()
    {
        $this->db->commit();
    }
    public function rollback()
    {
        $this->db->rollback();
    }
    public function close()
    {
        $this->db->close();
    }
    public function getDb()
    {
        return $this->db;
    }
}
