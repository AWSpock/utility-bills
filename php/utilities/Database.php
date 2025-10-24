<?php

include_once("/var/www/utility-bills/php/utilities/Pager.php");

class Database
{
    protected $connection = null;
    public $query;
    public $types;
    public $params;
    protected $env;

    public function __construct($env)
    {
        $this->env = $env;
        $this->connection = new mysqli($env['DB_HOST'], $env["DB_USER"], $env["DB_PASS"], $env["DB_NAME"]);

        if (mysqli_connect_errno()) {
            throw new Exception("Could not connect to database.");
        }
    }

    public function closeDbConnection()
    {
        $this->connection->close();
    }

    public function prepareStatement($query)
    {
        $normalize = trim(preg_replace('/\s\s+/', ' ', $query));
        $stmt = $this->connection->prepare($normalize);
        if ($stmt === false) {
            error_log("Unable to do prepared statement: " . $normalize . "; " . $this->connection->error, 0);
            throw new Exception("Database operation failed");
        }
        return $stmt;
    }
    public function runStatement($stmt)
    {
        try {
            $stmt->execute();
            if (!empty($this->connection->error)) {
                error_log("Database->executeStatement() Failed: " . $this->connection->error, 0);
                error_log("stmt: " . json_encode($stmt), 0);
                throw new Exception("Database operation failed");
            }
            return $stmt;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } catch (Error $e) {
            throw new Error($e->getMessage());
        }
    }
    public function returnInsertID()
    {
        return $this->connection->insert_id;
    }
}
