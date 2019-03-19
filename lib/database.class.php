<?php

require_once 'config/databse.php';

class database
{
    private $conn = null;
    private $username = 'root';
    private $password = '';
    private $host = 'localhost';
    private $db_name = 'contactsdb';

    function __construct()
    {
        //singaltn
        if (empty($this->conn)) {
            $this->conn = $this->connect();
            //if table not exist create table
              $sql = "CREATE TABLE IF NOT EXISTS `contacts` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `first_name` varchar(30) DEFAULT NULL,
                  `last_name` varchar(30) DEFAULT NULL,
                  `age` int(2) DEFAULT NULL,
                  `email` varchar(30) DEFAULT NULL,
                  `gender` enum('m','f') DEFAULT NULL,
                  `phone` varchar(20) NOT NULL,
                  `created_date` datetime DEFAULT NULL,
                  `updated_date` datetime DEFAULT NULL,
                  PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8
              ";
            $this->conn->exec($sql);

        }


    }

    public function connect()
    {
        try {
            $conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }
    public function getConnection(){
        return  $this->conn;
    }

}