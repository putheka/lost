<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost And Found</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        /* Add your custom CSS styles here */
    </style>
</head>
<body class="grey darken-1">
<?php
require("config.php");
require("functions.php");
session_start();
if (!(isset($_SESSION['login_user']))) {
    header("location:login.php");
}
$user = $_SESSION['login_user'];
?>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Lost And Found</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if (is_admin()) {
                echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"admin.php\">ADMIN PANEL</a></li>";
            } ?>
            <li class="nav-item"><a class="nav-link" href="lost.php">Lost Post</a></li>
            <li class="nav-item"><a class="nav-link" href="found.php">Found Post</a></li>
            <li class="nav-item"><a class="nav-link" href="profile.php">PROFILE</a></li>
            <li class="nav-item"><a class="nav-link" href="logut.php">LOGOUT</a></li>
        </ul>
    </div>
</nav>

<!-- Main Content -->
<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body bg-dark text-white">
                    <h5 class="card-title">ADD DETAIL ABOUT LOST ITEM</h5>
                    <a href="lost.php" class="btn btn-primary">ADD POST</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body bg-dark text-white">
                    <h5 class="card-title">ADD DETAIL ABOUT FOUND ITEM</h5>
                    <a href="found.php" class="btn btn-primary">ADD POST</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
