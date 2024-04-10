<?php

// database details
$host = "localhost";
$username = "root";
$password = "";
$dbname = "assignment2";

// creating a connection
$con = mysqli_connect($host, $username, $password, $dbname);

// to ensure that the connection is made
if (!$con)
{
    die("Connection failed!" . mysqli_connect_error());
}

?>
