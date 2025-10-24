<?php

require_once("/var/www/utility-bills/php/models/BillType.php");

class BillTypeRepository
{
    private $db;
    private $address_id;

    private $records = [];
    private $loaded = false;

    public $actionDataMessage;

    public function __construct(DatabaseV2 $db, $address_id)
    {
        $this->db = $db;
        $this->address_id = $address_id;
    }

    public function getRecordById($id)
    {
        if (!array_key_exists($id, $this->records)) {
            $sql = "
                SELECT a.`id`, a.`created`, a.`updated`, a.`name`, a.`unit`, a.`precision`
                FROM bill_type a
                WHERE a.`address_id` = ?
                    AND a.`id` = ?
            ";

            $result = $this->db->query($sql, [
                $this->address_id,
                $id
            ], "ii");

            if ($result) {
                $rec = BillType::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
                $this->records[$id] = $rec;
            } else {
                $this->records[$id] = null;
            }
        }
        return $this->records[$id];
    }

    public function getRecords()
    {
        if ($this->loaded) {
            $recs = [];
            foreach ($this->records as $key => $rec) {
                if ($rec->id() > 0)
                    $recs[$key] = $rec;
            }
            return $recs;
        }

        $sql = "
            SELECT a.`id`, a.`created`, a.`updated`, a.`name`, a.`unit`, a.`precision`
            FROM bill_type a
            WHERE a.`address_id` = ?
            ORDER BY a.`name`
        ";

        $result = $this->db->query($sql, [
            $this->address_id
        ], "i");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = BillType::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(BillType $rec)
    {
        $this->actionDataMessage = "Failed to insert Bill Type";

        if (empty($rec->name()) || empty($rec->unit())) {
            $this->actionDataMessage = "Name and Unit are required to insert Bill Type";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO bill_type (`address_id`,`name`,`unit`,`precision`)
            VALUES (?,?,?,?)
        ";

        $result = $this->db->query($sql, [
            $this->address_id,
            $rec->name(),
            $rec->unit(),
            $rec->precision()
        ], "issi");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Bill Type Inserted";
            $this->db->commit();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    public function updateRecord(BillType $rec)
    {
        $this->actionDataMessage = "Failed to update Bill Type";

        if (empty($rec->name()) || empty($rec->unit())) {
            $this->actionDataMessage = "Name and Unit are required to update Bill Type";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            UPDATE bill_type
            SET `name` = ?,
                `unit` = ?,
                `precision` = ? 
            WHERE `id` = ? 
            AND `address_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->name(),
            $rec->unit(),
            $rec->precision(),
            $rec->id(),
            $this->address_id
        ], "ssiii");

        if ($result !== false) {
            if ($result !== 1) {
                $this->actionDataMessage = "Bill Type Unchanged";
                return 2;
            }
            $this->actionDataMessage = "Bill Type Updated";
            $this->db->commit();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function deleteRecord(BillType $rec)
    {
        $this->actionDataMessage = "Failed to delete Bill Type";

        $this->db->beginTransaction();
        
        $sql = "
            DELETE FROM bill_type 
            WHERE `id` = ? 
            AND `address_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->address_id
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Bill Type Deleted";
            $this->db->commit();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }
}
