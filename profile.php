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

$tu = t_count('user');
$tl = tp_count('lthings');
$tf = tp_count('fthings');
$td = draft_post_count();
$up = pending_account_count();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        ul li {
            margin-right: 15px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .sidebar {
            background-color: #343a40;
            color: #ffffff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 20px;
            transition: width 0.3s;
            overflow-y: auto;
            /* Allow vertical scrolling */
            z-index: 999;
            /* Ensure sidebar is above content */
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid #454d55;
        }

        .sidebar-menu li:last-child {
            border-bottom: none;
        }

        .sidebar-menu li a {
            display: block;
            padding: 15px 20px;
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .sidebar-menu li a:hover {
            background-color: #454d55;
        }

        .content {
            padding: 20px;
            margin-left: 250px;
            transition: margin-left 0.3s;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            /* Added margin-top to separate content from header */
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: none;
        }

        .table-responsive {
            overflow-x: auto;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }

            .sidebar {
                width: 0;
            }

            .sidebar.collapsed {
                width: 80px;
            }

            .sidebar.collapsed .sidebar-menu li a {
                padding: 15px;
                text-align: center;
            }

            .sidebar.collapsed .sidebar-header {
                display: none;
            }
        }
    </style>
</head>

<body>

    <?php if (!is_admin()) : ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Admin Area</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ml-auto">
                        <li class='nav-item'><a class="nav-link" href="index.php">Home</a></li>
                        <li class='nav-item'><a class="nav-link" href="lost.php">Lost Post</a></li>
                        <li class='nav-item'><a class="nav-link" href="found.php">Found Post</a></li>
                        <li class='nav-item disable'><a class="nav-link" href="profile.php">Profile</a></li>
                        <li class='nav-item'><a class="nav-link" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <?php if (is_admin()) : ?>
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <h3>Admin Area</h3>
            </div>
            <ul class="sidebar-menu">
                <li><a href="admin_panel.php"><i class="fas fa-users"></i> User Pending (<?php echo $tu; ?>)</a></li>
                <li><a href="Profile.php" class="text-primary disabled"><i class="fas fa-user"></i> Profile</a></li>
                <li><a href="catageory.php"><i class="fas fa-list"></i> Category</a></li>
                <li><a href="admin.php"><i class="fas fa-user"></i> Total Users (<?php echo $tu; ?>)</a></li>
                <li><a href="adminlost.php"><i class="fas fa-th-list"></i> Lost Posts (<?php echo $tl; ?>)</a></li>
                <li><a href="adminfound.php"><i class="fas fa-check"></i> Found Posts (<?php echo $tf; ?>)</a></li>
                <li><a href="admindraft.php"><i class="fas fa-file-alt"></i> Drafted Posts (<?php echo $td; ?>)</a></li>
                <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    <?php endif; ?>

    <div class="container mt-5">
    <div class="row justify-content-center"> 
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
                        <h3> <?php echo $name; ?> <i class="fas fa-check-circle text-success"></i></h3>
                       
                        <h5> <?php echo $user; ?></h5>
                        <p>Total Posts: <?php echo $post; ?></p>
                        <a href="edituser.php" class="btn btn-warning">Edit Profile Information</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Posts Table Column -->
    <div class="row mt-5"> <!-- Add mt-5 to create space between the two columns -->
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