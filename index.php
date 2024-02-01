<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="icon" type="jpeg" href="to-do-icon.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">To-Do List!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About Us</a>
                </li>
                <li> <a class="nav-link" href="#">Contact Us</a></li>
            </ul>
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<div class="container">
    <?php
    $insert = false;
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $database);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST["title"];
        $description = $_POST["description"];

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "INSERT INTO `to-do-list` (`title`, `description`) VALUES ('$title', '$description')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $insert = true;
            }
        }
    }
    ?>
    <?php
    if ($insert) {
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
          <strong>Success!</strong> The Task has been Added.
          <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
    }
    ?>

    <div class="form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="container my-3">
                <div class="mb-3">
                    <label for="title" class="form-label"> <h4>Title</h4> </label>
                    <input type="text" class="form-control" id="title" placeholder="Add Title Here" name="title"
                           aria-describedby="emailHelp">
                </div>
                <h4>Description</h4>

                <div class="form-floating my-3">
                    <textarea class="form-control" placeholder="Description!!!" name="description"
                              id="description"></textarea>
                    <label for="floatingTextarea"> Add Description</label>
                </div>
                <button class="my-2 btn btn-primary" type="submit">Add Notes</button>
            </div>
        </form>
    </div>

    <div class="container my-5">
        <h3>Displaying Your Task</h3>
        <table class="table" id="myTable">
            <thead>
            <tr>
                <th scope="col">S.No</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM `to-do-list`";
            $result = mysqli_query($conn, $sql);
            $Sno = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <th scope='row'>" . $Sno . "</th>
                        <td>" . $row['title'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td><a href='/edit'>Edit</a> / <a href='/del'>Delete</a></td>
                      </tr>";
                $Sno++;
            }
          
            ?>
          
            </tbody>
        </table>
        <hr>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
</body>
</html>
