<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost And Found</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body class="bg-dark text-white">

<?php
require("config.php");
require("functions.php");
session_start();
if (!(isset($_SESSION['login_user']))) {
    header("location:login.php");
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $user = $_SESSION['login_user'];
    $type = $_GET['type'];
    $cat = $_GET['cat'];
    $pdate = $_GET['pdate'];
} else {
    header("location:profile.php");
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Lost And Found</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (is_admin()) {
                    echo "<li class='nav-item'><a href=\"admin.php\" class=\"nav-link text-white\">ADMIN PANEL</a></li>";
                } ?>
                <li class='nav-item'><a href="profile.php" class="nav-link text-white">PROFILE</a></li>
                <li class='nav-item'><a href="logout.php" class="nav-link text-white">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <?php
    if ($type == "lost")
        $xtype = "found";
    if ($type == "found")
        $xtype = "lost";
    ?>
    <div class="card bg-secondary text-white">
        <div class="card-body">
            <h5 class="card-title text-center">Results matching with <?php echo $xtype; ?> items</h5>
            <div class="table-responsive">
                <table class="table table-dark table-striped table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Posted By</th>
                        <th scope="col">Category</th>
                        <th scope="col">Description</th>
                        <th scope="col">Post Date</th>
                        <th scope="col">Know More</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($type == 'found') {
                        $sql = "SELECT `id` FROM `lthings` WHERE `cat_ref`=$cat and `uemail` not in('$user')";
                        $retval = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($retval) == 0) {
                            echo "<tr><td colspan='6'>No result</td></tr>";
                        }
                        while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
                            $id = $row['id'];
                            get_search_post($id, 'lost');
                        }
                    }
                    if ($type == 'lost') {
                        $sql = "SELECT `id` FROM `fthings` WHERE `cat_ref`=$cat and `uemail` not in('$user')";
                        $retval = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($retval) == 0) {
                            echo "<tr><td colspan='6'>No result</td></tr>";
                        }
                        while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
                            $id = $row['id'];
                            get_search_post($id, 'found');
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
