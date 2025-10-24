<?php

require_once("/var/www/utility-bills/php/models/Bill.php");

class BillRepository
{
    private $db;
    private $address_id;
    private $bill_type_id;

    private $records = [];
    private $loaded = false;

    public $actionDataMessage;

    public function __construct(DatabaseV2 $db, $address_id, $bill_type_id)
    {
        $this->db = $db;
        $this->address_id = $address_id;
        $this->bill_type_id = $bill_type_id;
    }

    public function getRecordById($id)
    {
        if (!array_key_exists($id, $this->records)) {
            $sql = "
                SELECT a.`id`, a.`created`, a.`updated`, a.`bill_date`, a.`from_date`, a.`to_date`, a.`unit`, a.`price`
                FROM bill a
                WHERE a.`address_id` = ?
                    AND a.`bill_type_id` = ?
                    AND a.`id` = ?
            ";

            $result = $this->db->query($sql, [
                $this->address_id,
                $this->bill_type_id,
                $id
            ], "iii");

            if ($result) {
                $rec = Bill::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
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
            SELECT a.`id`, a.`created`, a.`updated`, a.`bill_date`, a.`from_date`, a.`to_date`, a.`unit`, a.`price`
            FROM bill a
            WHERE a.`address_id` = ?
                AND a.`bill_type_id` = ?
            ORDER BY a.`bill_date` DESC
        ";

        $result = $this->db->query($sql, [
            $this->address_id,
            $this->bill_type_id
        ], "ii");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = Bill::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(Bill $rec)
    {
        $this->actionDataMessage = "Failed to insert Bill";

        if (empty($rec->bill_date()) || empty($rec->from_date()) || empty($rec->to_date()) || empty($rec->unit()) || empty($rec->price())) {
            $this->actionDataMessage = "Bill Date, From Date, To Date, Unit, and Price are required to insert Bill";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO bill (`address_id`,`bill_type_id`,`bill_date`,`from_date`,`to_date`,`unit`,`price`)
            VALUES (?,?,?,?,?,?,?)
        ";

        $result = $this->db->query($sql, [
            $this->address_id,
            $this->bill_type_id,
            $rec->bill_date(),
            $rec->from_date(),
            $rec->to_date(),
            $rec->unit(),
            $rec->price()
        ], "iisssdd");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Bill Inserted";
            $this->db->commit();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    public function updateRecord(Bill $rec)
    {
        $this->actionDataMessage = "Failed to update Bill";

        if (empty($rec->bill_date()) || empty($rec->from_date()) || empty($rec->to_date()) || empty($rec->unit()) || empty($rec->price())) {
            $this->actionDataMessage = "Bill Date, From Date, To Date, Unit, and Price are required to update Bill";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            UPDATE bill
            SET `bill_date` = ?,
                `from_date` = ?,
                `to_date` = ?,
                `unit` = ?,
                `price` = ?
            WHERE `id` = ? 
                AND `address_id` = ?
                AND `bill_type_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->bill_date(),
            $rec->from_date(),
            $rec->to_date(),
            $rec->unit(),
            $rec->price(),
            $rec->id(),
            $this->address_id,
            $this->bill_type_id
        ], "sssddiii");

        if ($result !== false) {
            if ($result !== 1) {
                $this->actionDataMessage = "Bill Unchanged";
                return 2;
            }
            $this->actionDataMessage = "Bill Updated";
            $this->db->commit();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function deleteRecord(Bill $rec)
    {
        $this->actionDataMessage = "Failed to delete Bill";

        $this->db->beginTransaction();

        $sql = "
            DELETE FROM bill
            WHERE `id` = ? 
                AND `address_id` = ?
                AND `bill_type_id` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->address_id,
            $this->bill_type_id
        ], "iii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Bill Deleted";
            $this->db->commit();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }
}
