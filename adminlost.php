<?php
    require ("session.php");
    require ("config.php");
    require ("functions.php");
    auth_admin();

    $tu = t_count('user');
    $tl = tp_count('lthings');
    $tf = tp_count('fthings');
    $td = draft_post_count();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Lost</title>
   
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Admin lost</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="admin_panel.php">User Pending</a></li>
                <li class="nav-item"><a class="nav-link" href="Profile.php">Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="catageory.php">Category</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="logut.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text"><?php echo $tu; ?></p>
                    <a href="admin.php" class="btn btn-light">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Lost Posts</h5>
                    <p class="card-text"><?php echo $tl; ?></p>
                    <a href="adminlost.php" class="btn btn-light disabled">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Found Posts</h5>
                    <p class="card-text"><?php echo $tf; ?></p>
                    <a href="adminfound.php" class="btn btn-light">View</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title">Drafted Posts</h5>
                    <p class="card-text"><?php echo $td; ?></p>
                    <a href="admindraft.php" class="btn btn-light">View</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body bg-dark">
                    <h5 class="card-title text-white">Lost Posts List</h5>
                    <table class="table text-white">
                        <thead>
                            <tr>
                                <th>Post ID</th>
                                <th>User</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Know More</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php get_post_list("lost"); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
