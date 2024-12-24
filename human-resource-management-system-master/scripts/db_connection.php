<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hrm";

$conn = new mysqli($servername, $username, $password, $dbname);

// check the connection
if ($conn->connect_error) {
    die("Connection Failed due to " . $conn->connect_error);
} // else, the connection established.
