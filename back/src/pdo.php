<?php 

$host = "pgsql_desafio";
$db = "applicationphp";
$user = "root";
$pw = "root";

class DB {
    public function __construct($host, $db, $user, $pw) {
        $this->host = $host;
        $this->db = $db;
        $this->user = $user;
        $this->pw = $pw;
    }

    public function connect() {
        return new PDO("pgsql:host=$this->host;dbname=$this->db", $this->user, $this->pw);
    }
}

$myDB = new DB($host, $db, $user, $pw);
$myDB = $myDB->connect();

define('myDB', $myDB);