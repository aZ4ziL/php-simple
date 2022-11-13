<?php session_start(); require_once "connect.php"; ?>

<?php 
    if (isset($_POST["submit"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "SELECT * FROM users WHERE email='$email'";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_array();

            if (password_verify($password, $row["password"])) {
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["last_name"] = $row["last_name"];
                $_SESSION["full_name"] = $row["first_name"] . " " . $row["last_name"];
                $_SESSION["email"] = $row["email"];
                header("Location: ../index.php");
            }else {
                $_SESSION["error_type"] = "danger";
                $_SESSION["error_msg"] = "Username or password is incorrect.";
                header("Location: login.php");
            }
        }
    }
?>