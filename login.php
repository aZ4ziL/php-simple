<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-lg-6">
                <h1 class="mb-3">Register User</h1>
                <p>Not have a account. Please register <a href="/register.php">here</a></p>

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
                <form action="/db/login-handler.php" method="post">
                    <div class="form-group mb-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required />
                    </div>
                    <div class="form-group mb-2">
                        <label for="password2">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required />
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
</body>
</html>