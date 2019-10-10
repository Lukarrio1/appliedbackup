<?php

class Database
{
    private $db = "applied";
    private $dbuser = "json";
    private $dbhost = "localhost";
    private $dbpassword = "Luk@rri01";

    public function connect()
    {
        $con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpassword, $this->db);
        if ($con == false) {
            exit(mysqli_connect_error());
        } else {
            return $con;
        }
    }
}
