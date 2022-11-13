<?php
    session_start();
    require_once("connect.php");

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $_SESSION["error_type"] = "danger";
            $_SESSION["error_msg"] = "File is not an image.";
            header("Location: ../index.php");
        }
    }

    // check if file already exitst
    if (file_exists($target_file)) {
        $uploadOk = 0;
        $_SESSION["error_type"] = "danger";
        $_SESSION["error_msg"] = "Sorry, File already exists.";
        header("Location: ../index.php");
    }

    // check file size
    if ($_FILES["file"]["size"] > 5000000) {
        $uploadOk = 0;
        $_SESSION["error_type"] = "danger";
        $_SESSION["error_msg"] = "Sorry, your file is to large.";
        header("Location: ../index.php");
    }

    // Allow image only
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        $uploadOk = 0;
        $_SESSION["error_type"] = "danger";
        $_SESSION["error_msg"] = "Sorry, only JPG, PNG, JPEG format.";
        header("Location: ../index.php");
    }

    // Check $uploadOk is True
    if ($uploadOk == 0) {
        $_SESSION["error_type"] = "danger";
        $_SESSION["error_msg"] = "Sorry, your file is not uploaded.";
        header("Location: ../index.php");
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            $filename = "uploads/" . $_FILES["file"]["name"];
            $sql = "INSERT INTO files (url) VALUE ('$filename')";

            if ($conn->query($sql)) {
                $_SESSION["error_type"] = "success";
                $_SESSION["error_msg"] = "The file " . htmlspecialchars( basename( $_FILES["file"]["name"])) . " has been uploaded.";
                header("Location: ../index.php");
            }
        } else {
            $_SESSION["error_type"] = "danger";
            $_SESSION["error_msg"] = "Sorry, there was an error uploading your file.";
            header("Location: ../index.php");
        }
    }
?>