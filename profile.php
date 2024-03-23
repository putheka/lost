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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Lost And Found</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <?php if (is_admin()) {
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"admin.php\">ADMIN PANEL</a></li>";
                } ?>
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="logut.php">LOGOUT</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- Profile Information Column -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        User Profile
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <?php
                            // Retrieve profile image path from the database
                            $profileImageQuery = "SELECT profile_image FROM user WHERE email='$user'";
                            $profileImageResult = mysqli_query($conn, $profileImageQuery);
                            if ($profileImageResult && mysqli_num_rows($profileImageResult) > 0) {
                                $row = mysqli_fetch_assoc($profileImageResult);
                                $profileImagePath = $row['profile_image'];

                                // Display the profile image
                                echo '<img src="' . $profileImagePath . '" alt="Profile Image" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">';
                            } else {
                                // Display a default profile image if no image is found
                                echo '<img src="default-profile-image.png" alt="Profile Image" class="img-fluid rounded-circle" style="width: 150px; height: 150px;">';
                            }
                            ?>
                        </div>
                        <div class="text-center">
                            <p>Name: <?php echo $name; ?></p>
                            <p>Email: <?php echo $user; ?></p>
                            <p>Total Posts: <?php echo $post; ?></p>
                            <a href="edituser.php" class="btn btn-warning">Edit Profile</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Posts Table Column -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Posts
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-white">
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
                                    <?php
                                    // Fetch and display user's posts
                                    $sql = "SELECT `id` FROM `lthings` WHERE `uemail`='$user'";
                                    $retval = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
                                        $id = $row['id'];
                                        get_post($id, 'lost');
                                    }
                                    $sql = "SELECT `id` FROM `fthings` WHERE `uemail`='$user'";
                                    $retval = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
                                        $id = $row['id'];
                                        get_post($id, 'found');
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


</body>

</html>