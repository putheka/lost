<?php
require("session.php");
require("config.php");
require("functions.php");
auth_admin();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    global $conn;
    if (isset($_POST['catref'])) {
        $catref = $_POST['catref'];
        if ($catref != "0") {
            // Check if there are any associated records in fthings table
            $check_sql = "SELECT * FROM fthings WHERE cat_ref = $catref";
            $result = mysqli_query($conn, $check_sql);
            if (mysqli_num_rows($result) > 0) {
                echo "<script>alert('Cannot delete category because it has associated records in fthings table.')</script>";
            } else {
                // Delete the category if no associated records found
                $sql = "DELETE FROM catagoery WHERE cid = $catref";
                mysqli_query($conn, $sql);
                echo "<script>alert('Category is deleted.')</script>";
            }
        }
    }
    if (isset($_POST['cat'])) {
        $cat = $_POST['cat'];
        $sql = "INSERT INTO `catagoery`(`cname`) VALUES ('$cat')";
        mysqli_query($conn, $sql);
        echo "<script>alert('New category is added.')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Area (Flown Things)</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,700,900|Roboto+Condensed:400,300,700" rel="stylesheet">
    <link rel="stylesheet" href="css/postreport.css">
    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
        }
        .form-wrapper {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333333;
        }
        .input-field input[type=text]:focus {
            border-bottom: 1px solid #1976D2;
            box-shadow: 0 1px 0 0 #1976D2;
        }
        .input-field input[type=text]:focus + label {
            color: #1976D2 !important;
        }
        .btn {
            border-radius: 20px;
            margin-top: 20px;
        }
        .btn-large {
            font-weight: 700;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
    <a class="navbar-brand" href="#">Admin Area</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        
            <li class="nav-item"><a class="nav-link" href="admin.php">Admin Panel</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            
            
        </ul>
    </div>
    </div>
</nav>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div class="form-wrapper bg-light p-4">
                <h4 class="form-title">Choose Category to Delete</h4>
                <form action="catageory.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <select class="form-control" name="catref" required>
                            <option value="" disabled selected>Select Category</option>
                            <?php gen_cat_list(); ?>
                        </select>
                    </div>
                    <button class="btn btn-large btn-danger" type="submit" name="action">Delete</button>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-wrapper bg-light p-4">
                <h4 class="form-title">Enter Category to Add</h4>
                <form action="catageory.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <input id="cat" type="text" class="form-control" name="cat" minlength="5" maxlength="10" required>
                    </div>
                    <button class="btn btn-large btn-success" type="submit" name="action">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


