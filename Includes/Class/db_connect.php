<?php

class DatabaseConnection {

    public $conn = null;


    // developer parameters
    private $servername = "localhost";
    private $username = "root";
    private $db_name = "kamssa";
    private $password = "";

    // production parameters
    // private $servername = "localhost";
    // private $username = "u832900566_kamss";
    // private $db_name = "u832900566_root";
    // private $password = "Aurora1!";


    function __construct () {
        //initialize db connection
        $this->connectToDb();
    }

    private function connectToDb () {
        try {
            $this->conn = new PDO ("mysql:host={$this->servername};dbname={$this->db_name}", $this->username, $this->password);
            //set the pdo error mode to execption
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Failed" . $e->getMessage();
        }
    }


}
















?>