<?php

require_once("/var/www/utility-bills/php/DataAccess/DatabaseException.php");

class DatabaseV2
{
    private $conn;

    public function __construct($env = null)
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        if (!isset($env))
            $env = parse_ini_file(__DIR__ . '/.env');

        try {
            $this->conn = new mysqli($env['DB_HOST'], $env["DB_USER"], $env["DB_PASS"], $env["DB_NAME"]);
        } catch (mysqli_sql_exception $e) {
            throw new DatabaseException("Database connection failed: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function query($sql, $params = [], $types = "")
    {
        try {
            $normalize = trim(preg_replace('/\s\s+/', ' ', $sql));

            // error_log("Query: " . $normalize, 0);

            if (empty($params)) {
                $result = $this->conn->query($normalize);
                return $result;
            }

            $stmt = $this->conn->prepare($normalize);
            if ($stmt === false) {
                throw new DatabaseException("Failed to prepare statement for query: $normalize");
            }

            if (!empty($types)) {
                $stmt->bind_param($types, ...$params);
            }

            $stmt->execute();

            // for select, return result set
            if (stripos($normalize, "SELECT") === 0) {
                return $stmt->get_result();
            }

            // for update, return affected rows
            if (stripos($normalize, "UPDATE") === 0 || stripos($normalize, "DELETE") === 0) {
                return $stmt->affected_rows;
            }

            // for update, return insert id or TRUE if no id
            if (stripos($normalize, "INSERT") === 0) {
                return $this->conn->insert_id === 0 ? true : $this->conn->insert_id;
            }

            // unknown
            return "IDK";
        } catch (mysqli_sql_exception $e) {
            throw new DatabaseException("Query failed: " . $e->getMessage(), $e->getCode(), $e, $normalize);
        }
    }

    public function beginTransaction()
    {
        try {
            $this->conn->begin_transaction();
        } catch (mysqli_sql_exception $e) {
            throw new DatabaseException("Failed to start transaction" . $e->getMessage(), $e->getCode(), $e);
        }
    }
    public function commit()
    {
        try {
            $this->conn->commit();
        } catch (mysqli_sql_exception $e) {
            throw new DatabaseException("Failed to commit transaction" . $e->getMessage(), $e->getCode(), $e);
        }
    }
    public function rollback()
    {
        try {
            $this->conn->rollback();
        } catch (mysqli_sql_exception $e) {
            throw new DatabaseException("Failed to rollback transaction" . $e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function close()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
