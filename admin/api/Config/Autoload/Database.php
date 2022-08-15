<?php

ini_set('display_errors', 0);
error_reporting(0);

class Database {

    private $path = '';
    private $lastInsertedId;

    public function __construct() {
        $this->path = FileConstant::$loggerFilePath;
    }

    private function setDatabase($index) {

        switch ($index) {
            case '1':
                $this->db_host = 'localhost';
                $this->db_user = 'root';
                $this->db_pass = '';
                $this->db_name = 'crop2u';
                break;
            case '2':
                $this->db_host = 'localhost';
                $this->db_user = 'root';
                $this->db_pass = '';
                $this->db_name = 'crop2u';
                break;
        }
    }

    private function connect() {
        $this->con = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name) or die("MySql db Connnect Error");
        if (!$this->con) {
            die("Connection error: " . mysqli_connect_error());
        }
    }

    private function disconnect() {
        $this->lastInsertedId = mysqli_insert_id($this->con);
        mysqli_close($this->con);
    }

    protected function executeQuery($sql, $index = 1) {
        $this->setDatabase($index);
        $this->connect();
        if (Constant::$IS_LOGGER_ON == 1) {
            $this->loggQuery($sql);
        }
        $result = mysqli_query($this->con, $sql);
        $this->disconnect();
        return $result;
    }

    protected function insertAssoc($sqlArr, $tableName, $index = 1) {
        $fieldStr = "";
        $valueStr = "";

        foreach ($sqlArr as $key => $value):
            if ($fieldStr == ""):
                $fieldStr = $key . " = " . "'$value'";
            else:
                $fieldStr .= ", " . $key . " = " . "'$value'";
            endif;
        endforeach;
        $sql = "INSERT INTO " . $tableName . " SET $fieldStr ";
        if (Constant::$IS_LOGGER_ON == 1) {
            $this->loggQuery($sql);
        }
        $result = $this->executeQuery($sql);
        return $result;
    }

    protected function updateQuery($sqlArr, $tableName, $conditionArr, $index = 1) {
        $fieldStr = "";
        $condField = "";
        foreach ($sqlArr as $key => $value):
            if ($fieldStr == ""):
                $fieldStr = $key . " = " . "'$value'";
            else:
                $fieldStr .= ", " . $key . " = " . "'$value'";
            endif;
        endforeach;
        foreach ($conditionArr as $key => $value):
            if ($condField == ""):
                $condField = $key . " = " . "'$value'";
            else:
                $condField .= " AND " . $key . " = " . "'$value'";
            endif;
        endforeach;
        $sql = "UPDATE " . $tableName . " SET $fieldStr WHERE $condField";
        if (Constant::$IS_LOGGER_ON == 1) {
            $this->loggQuery($sql);
        }
        $result = $this->executeQuery($sql);
        return $result;
    }

    public function loggQuery($qry, $queryhasexecuted = 1) {
        try {
            $today = date("Y-m-d H:i:s");
            if ($queryhasexecuted == 0)
                $string = $today . "Could not execute query --->" . $qry . ";";
            else
                $string = $today . "Query Executed--->" . $qry . ";";
            file_put_contents($this->path, $string . PHP_EOL, FILE_APPEND);
        } catch (Exception $e) {
            //do nothing
        }
    }

    protected function lastInsertedId() {
        return $this->lastInsertedId;
    }
}

?>
