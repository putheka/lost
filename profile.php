<?php
require("config.php");
require("functions.php");
session_start();
if (!(isset($_SESSION['login_user']))) {
    header("location:login.php");
}
$user = $_SESSION['login_user'];
$name = get_user($user);
$sql = "SELECT  `posts` FROM `user` WHERE `email`='$user'";
$row = mysqli_fetch_array(mysqli_query($conn, $sql));
$post = $row['posts'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="css/profile.css"> <!-- Your custom CSS file -->
</head>
<body>
    <nav>
        <div class="nav-wrapper blue-grey darken-3">
            <a href="#" class="brand-logo center">Lost And Found</a>
            <ul id="nav-mobile" class="right">
                <?php if (is_admin()) : ?>
                    <li><a href="admin.php" class="btn white-text">Admin Panel</a></li>
                <?php endif; ?>
                <li><a href="index.php" class="btn white-text">Home</a></li>
                <li><a href="logout.php" class="btn white-text">Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container ">
        <div class="row">
            <div class="col s12 ">
                <div class="card blue-grey darken-3 z-depth-3 broder-white">
                    <div class="card-content white-text">
                        <span class="card-title">User Profile</span>
                        <div class="divider"></div>
                        <div class="profile-info">
                            <p>Name: <?php echo $name; ?></p>
                            <p>Email: <?php echo $user; ?></p>
                            <p>Total Posts: <?php echo $post; ?></p>
                            <a href="edituser.php" class="waves-effect waves-light btn">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div class="card blue-grey darken-3 z-depth-3">
                    <div class="card-content white-text">
                        <span class="card-title">Posts</span>
                        <div class="divider"></div>
                        <table class="white-text highlight responsive-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Category</th>
                                    <th>Post Date</th>
                                    <th>Details</th>
                                    <th>Draft</th>
                                    <th>Search</th>
                                </tr>
                            </thead>
                            <tbody>

        <tbody style="text-transform: capitalize;" >
        <?php
        $sql = "SELECT `id` FROM `lthings` WHERE `uemail`='$user'";
        $retval = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
            $id=$row['id'];
            get_post($id, 'lost');
        }
        $sql = "SELECT `id` FROM `fthings` WHERE `uemail`='$user'";
        $retval = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
            $id=$row['id'];
            get_post($id, 'found');
        }
        ?>
        </tbody>
    </table>


</div>
</div>

</body>

</html>