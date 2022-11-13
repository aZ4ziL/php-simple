<?php session_start(); ?>
<?php require_once("db/connect.php"); unlink("uploads/Screenshot_20221109_183418.png"); ?>
<?php 
    if ($_SESSION["email"] == "") {
        $_SESSION["error_type"] = "danger";
        $_SESSION["error_msg"] = "Please login before accessing this page.";
        header("Location: login.php");
    }
?>

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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
      </ul>
      <a href="/logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
</nav>
    <!-- Navbar -->

    <div class="container">
        <div class="row">
            <h1>Logined as <?php echo $_SESSION["full_name"]; ?></h1>

            <div class="col-lg-12">
                <div class="card shadow h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4>Data</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">Add</button>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION["error_type"])) { ?>
                            <div class="alert alert-<?php echo $_SESSION["error_type"]; ?>">
                                <?php echo $_SESSION["error_msg"]; ?>

                                <?php 
                                    unset($_SESSION["error_type"], $_SESSION["error_msg"]);
                                ?>
                            </div>
                        <?php } ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Image</th>
                                        <th scope="col" colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $sql = "SELECT * FROM files";
                                        
                                        $result = $conn->query($sql);

                                        if ($result->num_rows > 0) {
                                            while($row = $result->fetch_assoc()) {
                                                echo '
                                                <tr>
                                                    <td id="' . $row["id"] . '">
                                                        <img src="' . $row["url"] . '" class="img-fluid" width="300">
                                                    </td>
                                                    <td>
                                                        <a id="editHandler" href="#" class="btn btn-sm btn-info" 
                                                            data-id="' . $row["id"] . '" data-url="' . $row["url"] . '"
                                                            >Edit</a>
                                                        <a href="/delete.php?id=' . $row["id"] . '" class="btn btn-sm btn-danger">Delete</a>
                                                    </td>
                                                </tr>
                                                ';
                                            }
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="addDataModal" aria-labelledby="#addDataModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="addDataModalLabel">Add Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/db/fileUpload.php" method="post" enctype="multipart/form-data">
                        <input type="file" class="form-control mb-2" name="file" id="file">
                        <button type="submit" class="btn btn-primary" name="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="editDataModal" aria-labelledby="#editDataModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fs-5" id="editDataModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/edit.php" id="formEdit" method="post" enctype="multipart/form-data">
                        <p>Already: <b><span id="old-image"></span></b></p>
                        <input type="hidden" name="id" id="file-id">
                        <input type="file" class="form-control mb-2" name="file" id="file">
                        <button type="submit" class="btn btn-primary" name="submit">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

    <script>
        $("a[id=editHandler]").on("click", function(e) {
            e.preventDefault();
            var id = $(this).data("id");
            var url = $(this).data("url");

            $("#formEdit #file-id").val(id);
            $("#editDataModalLabel").text("Edit data with id: " + id);
            $("#editDataModal").modal("show");
            $("#old-image").text(url);
        })
    </script>
</body>
</html>