<?php

require_once("/var/www/utility-bills/php/models/Address.php");

class AddressRepository
{
    private $db;
    private $userid;

    private $records = [];
    private $loaded = false;

    public $actionDataMessage;

    public function __construct(DatabaseV2 $db, $userid)
    {
        $this->db = $db;
        $this->userid = $userid;
    }

    public function getRecordById($id)
    {
        if (!array_key_exists($id, $this->records)) {
            $sql = "
                SELECT a.`id`, a.`created`, a.`updated`, a.`street`, if(isnull(b.`address_id`),'No','Yes') AS `favorite`, ifnull(c.`role`,'Owner') AS `role`
                FROM address a
                    LEFT OUTER JOIN address_favorite b
                        ON a.`id` = b.`address_id`
                        AND b.`userid` = ?
                    LEFT OUTER JOIN address_share c
                        ON a.`id` = c.`address_id`
                        AND c.`userid` = ?
                WHERE a.`id` = ? 
                    AND (
                        a.`userid` = ?
                        OR a.`id` IN (
                            SELECT `address_id`
                            FROM address_share
                            WHERE `userid` = ?
                        )
                    )
            ";

            $result = $this->db->query($sql, [
                $this->userid,
                $this->userid,
                $id,
                $this->userid,
                $this->userid
            ], "iiiii");

            if ($result) {
                $rec = Address::fromDatabase($result->fetch_array(MYSQLI_ASSOC));
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
            SELECT a.`id`, a.`created`, a.`updated`, a.`street`, if(isnull(b.`address_id`),'No','Yes') AS `favorite`, ifnull(c.`role`,'Owner') AS `role`
            FROM address a
                LEFT OUTER JOIN address_favorite b
                    ON a.`id` = b.`address_id`
                    AND b.`userid` = ?
                LEFT OUTER JOIN address_share c
                    ON a.`id` = c.`address_id`
                    AND c.`userid` = ?
            WHERE a.`userid` = ?
                OR a.`id` IN (
                    SELECT `address_id`
                    FROM address_share
                    WHERE `userid` = ?
                )
            ORDER BY `favorite` DESC, `street`
        ";

        $result = $this->db->query($sql, [
            $this->userid,
            $this->userid,
            $this->userid,
            $this->userid
        ], "iiii");

        $this->loaded = true;
        $this->records = [];
        foreach ($result->fetch_all(MYSQLI_ASSOC) as $rec) {
            $this->records[$rec['id']] = Address::fromDatabase($rec);
        }
        return $this->records;
    }

    public function insertRecord(Address $rec)
    {
        $this->actionDataMessage = "Failed to insert Address";

        if (empty($rec->street())) {
            $this->actionDataMessage = "Street is required to insert Address";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO address (`street`,`userid`)
            VALUES (?,?)
        ";

        $result = $this->db->query($sql, [
            $rec->street(),
            $this->userid
        ], "si");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Street Inserted";
            $this->db->commit();
            return $result;
        }
        $this->db->rollback();
        return 0;
    }

    public function updateRecord(Address $rec)
    {
        $this->actionDataMessage = "Failed to update Address";

        if (empty($rec->street())) {
            $this->actionDataMessage = "Street is required to update Address";
            return 0;
        }

        $this->db->beginTransaction();

        $sql = "
            UPDATE address 
            SET `street` = ?
            WHERE `id` = ? 
            AND `userid` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->street(),
            $rec->id(),
            $this->userid
        ], "sii");

        if ($result !== false) {
            if ($result !== 1) {
                $this->actionDataMessage = "Address Unchanged";
                return 2;
            }
            $this->actionDataMessage = "Address Updated";
            $this->db->commit();
            return 1;
        }

        $this->db->rollback();
        return false;
    }

    public function deleteRecord(Address $rec)
    {
        $this->actionDataMessage = "Failed to delete Address";

        $this->db->beginTransaction();

        $sql = "
            DELETE a, b, c, d, e
            FROM address a
                LEFT OUTER JOIN bill_type b ON a.`id` = b.`address_id`
                LEFT OUTER JOIN address_favorite c ON a.`id` = c.`address_id`
                LEFT OUTER JOIN address_share d ON a.`id` = d.`address_id`
                LEFT OUTER JOIN bill e ON a.`id` = e.`address_id`
            WHERE a.`id` = ? 
            AND a.`userid` = ?
        ";

        $result = $this->db->query($sql, [
            $rec->id(),
            $this->userid
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Address Deleted";
            $this->db->commit();
            return 1;
        }
        $this->db->rollback();
        return 0;
    }

    //

    public function setFavorite($id)
    {
        $this->actionDataMessage = "Failed to Add Favorite Address";

        $this->db->beginTransaction();

        $sql = "
            INSERT INTO address_favorite (`address_id`, `userid`)
            VALUES (?,?)
        ";

        $result = $this->db->query($sql, [
            $id,
            $this->userid
        ], "ii");

        if ($result === true) {
            $this->actionDataMessage = "Added Favorite Address";
            $this->db->commit();
            return true;
        }

        $this->db->rollback();
        return false;
    }

    public function removeFavorite($id)
    {
        $this->actionDataMessage = "Failed to Remove Favorite Address";

        $this->db->beginTransaction();

        $sql = "
            DELETE FROM address_favorite
            WHERE `address_id` = ? 
            AND `userid` = ?
        ";

        $result = $this->db->query($sql, [
            $id,
            $this->userid
        ], "ii");

        if (is_int($result) && $result > 0) {
            $this->actionDataMessage = "Removed Favorite Address";
            $this->db->commit();
            return true;
        }

        $this->db->rollback();
        return false;
    }
}
