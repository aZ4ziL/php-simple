<?php 
    $host = "localhost";
    $user = "root";
    $pass = "rafi213fajri";
    $db = "belajar_php";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        die("Connection failed:" . $conn->connect_error);
    }
?>