<?php
defined('CORE_PATH') or exit('no access');

class Database
{
    protected static $instance = null;
    private $dbh;
    private $response;

    public function __construct()
    {
        try {
            $this->dbh = new PDO(DSN, USER, PASS);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->response = $this->createTable();
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();

        }
    }

    /**
     *Automatically create a table if it's not exist yet
     */
    public function createTable()
    {
        $table = TABLE;
        $sql = "CREATE table $table (
                UserfullName VARCHAR(60) NOT NULL,
                UserbirthDate INT,
                Useremail VARCHAR(50),
                Usermessage VARCHAR(100),
                time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY
                )";
        try {
            $table = $this->dbh->prepare("DESCRIBE " . TABLE);
            //do we have an existing table
            if ($table->execute()) {
                return true;
            }
        } catch (PDOException $e) {
            //if we don't have a table, try to create
            try {
                $this->dbh->exec($sql);
                return true;
            } catch (PDOException $e) {
                echo $e->getMessage();
                return false;
            }
        }


    }

    public function select($table, $query = null, $select = '*')
    {
        //if table exist
        if ($this->response) {
            if ($query) {
                $statement = $this->dbh->prepare("SELECT $select FROM $table $query");
            } else {
                $statement = $this->dbh->prepare("SELECT $select FROM $table");
            }

            try {
                if ($statement->execute()) {
                    return $statement->fetchAll();
                }
            } catch (PDOException $e) {
                echo $e->getMessage();

            }
        }
        return 0;
    }

    public function insert($table, $set)
    {
        //if table exist
        if ($this->response) {
            $newSet = (array)$set;
            $params = $this->params($newSet);
            $statement = $this->dbh->prepare(" INSERT INTO $table VALUES ($params, CURRENT_TIMESTAMP, ID) ");
            try {
                if ($statement->execute($newSet)) {
                    return $statement->rowCount();
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
        return false;
    }

    private function params($arr)
    {
        return implode(', ', array_map(function ($string) {
            return "'$string'";
        }, array_values($arr)));
    }
}