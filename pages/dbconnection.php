<?php
function dbconnect()
{
    try {
        $host = "localhost";
        $username = "root";
        $pass = "";
        $dbname = "fitcore";
        $con = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $pass);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $con;
    } catch (PDOException $e) {
        return $e->getMessage();
    }
}
