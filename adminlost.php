<?php
    require("session.php");
    require("config.php");
    require("functions.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
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
            overflow-y: auto; /* Allow vertical scrolling */
            z-index: 999; /* Ensure sidebar is above content */
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
            margin-top: 20px; /* Added margin-top to separate content from header */
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
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Admin Area</h3>
    </div>
    <ul class="sidebar-menu">
        <li><a href="admin_panel.php"><i class="fas fa-users"></i> User Pending (<?php echo $tu; ?>)</a></li>
        <li><a href="Profile.php"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="catageory.php"><i class="fas fa-list"></i> Category</a></li>
        <li><a href="admin.php"><i class="fas fa-user"></i> Total Users (<?php echo $tu; ?>)</a></li>
        <li><a href="adminlost.php"class="text-primary disabled"><i class="fas fa-th-list"></i> Lost Posts (<?php echo $tl; ?>)</a></li>
        <li><a href="adminfound.php"><i class="fas fa-check"></i> Found Posts (<?php echo $tf; ?>)</a></li>
        <li><a href="admindraft.php"><i class="fas fa-file-alt"></i> Drafted Posts (<?php echo $td; ?>)</a></li>
        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="content" id="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Total Users
                    </div>
                    <div class="card-body">
                        <h3><?php echo $tu; ?></h3>
                        <a href="admin.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Lost Posts
                    </div>
                    <div class="card-body">
                        <h3><?php echo $tl; ?></h3>
                        <a href="adminlost.php" class="btn btn-primary disabled">View</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Found Posts
                    </div>
                    <div class="card-body">
                        <h3><?php echo $tf; ?></h3>
                        <a href="adminfound.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Drafted Posts
                    </div>
                    <div class="card-body">
                        <h3><?php echo $td; ?></h3>
                        <a href="admindraft.php" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Lost Posts List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="bg-dark text-white">
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('collapsed');
        });
    });
</script>
</body>
</html>
