<?php session_start(); ?>
<?php require_once "db/connect.php"; ?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Register User</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    </head>
<body>

    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-lg-6">
                <h1 class="mb-3">Register User</h1>
                <p>Already have a account. Please login <a href="/login.php">here</a></p>
                <?php if (isset($_SESSION["error_type"])) { ?>
                <div class="alert alert-<?php echo $_SESSION["error_type"]; ?>">
                    <?php echo $_SESSION["error_msg"]; ?>

                    <?php 
                        session_unset();
                        session_destroy();
                    ?>
                </div>
                <?php } ?>

                <div id="alert"></div>
                <form action="" method="post">
                    <div class="form-group mb-2">
                        <label for="first_name">First name*</label>
                        <input type="text" class="form-control" name="first_name" id="first_name" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="last_name">Last name*</label>
                        <input type="text" class="form-control" name="last_name" id="last_name" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="email">Email*</label>
                        <input type="email" class="form-control" name="email" id="email" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="password1">Password*</label>
                        <input type="password" class="form-control" name="password1" id="password1" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="password2">Password confirmation*</label>
                        <input type="password" class="form-control" name="password2" id="password2" required />
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" name="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script>
        document.querySelector("#email").onkeyup = function() {
            $.ajax({
                url: "/db/check-email.php?email=" + this.value,
                type: "GET",
                success: function(response) {
                    if (response) {
                        $("#alert").addClass("alert").addClass("alert-danger").removeClass("alert-success");
                        $("#alert").text("This username already taken. Please use another email.")
                    } else {
                        $("#alert").addClass("alert").addClass("alert-success").removeClass("alert-danger");
                        $("#alert").text("Email can use")
                    }
                }
            })
        }
    </script>

</body>
</html>

<?php
    if (isset($_POST["submit"])) {
        # Method POST
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $email = $_POST["email"];
        $password1 = $_POST["password1"];
        $password2 = $_POST["password2"];

        if ($password1 != $password2) {
            $_SESSION["error_type"] = "danger";
            $_SESSION["error_msg"] = "The confirmation password is not the same.";
            header("Location: register.php");
        }

        $passwordHashing = password_hash($password1, PASSWORD_BCRYPT);

        // Insert into databases
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUE ('$firstName', '$lastName', '$email', '$passwordHashing')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION["error_type"] = "success";
            $_SESSION["error_msg"] = "Successfully to create a new user.";
            header("Location: login.php");
        } else {
            $error = mysqli_error($conn);
            $_SESSION["error_type"] = "danger";
            $_SESSION["error_msg"] = "Failed with: " . $error;
            header("Location: register.php");
        }
    }

    $conn->close();
?>