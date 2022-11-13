<?php
    require_once("connect.php");

    if(isset($_GET["email"])) {
        $email = $_GET["email"];
        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        
        if ($num > 0) {
            echo true;
        } else {
            echo false;
        }
    }
?>