<?php
    session_start();
    require "db/connect.php";

    $id = $_GET["id"];

    // Delete in server file
    $sql = "SELECT * FROM files where id='$id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        unlink($row["url"]);
    }

    // Delete in database

    $sql = "DELETE FROM files WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION["error_type"] = "success";
        $_SESSION["error_msg"] = "Record deleted successfully.";
        header("Location: index.php");
    } else {
        $_SESSION["error_type"] = "danger";
        $_SESSION["error_msg"] = "Error deleting record: " . $conn->error;
        header("Location: index.php");
    }

    $conn->close();
?>