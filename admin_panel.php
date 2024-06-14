<?php
    require("session.php");
    require("config.php");
    require("functions.php");
    auth_admin();

    mysqli_query($conn, "SET @p0='0'");
    mysqli_query($conn, "CALL `userCount`(@p0)");
    $proce = mysqli_fetch_array(mysqli_query($conn, "SELECT @p0 AS `counts`"));
    $tu = $proce['counts'];

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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
            overflow-y: auto;
            z-index: 999;
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

        .container {
            margin-top: 50px;
        }

        .user-list table {
            width: 100%;
        }

        .user-list th,
        .user-list td {
            padding: 10px;
            text-align: center;
        }

        .user-list th {
            background-color: #f8f9fa;
        }

        .user-list td img {
            max-width: 100px;
            height: auto;
            cursor: pointer;
        }

        .user-list button {
            padding: 5px 10px;
        }

        .modal-dialog img {
            width: 100%;
        }
    </style>
</head>

<body>
    
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Admin Area</h3>
    </div>
    <ul class="sidebar-menu">
        <li><a href="admin_panel.php" class="text-primary disabled"><i class="fas fa-users"></i> User Pending (<?php echo $up; ?>)</a></li>
        <li><a href="Profile.php"><i class="fas fa-user"></i> Profile</a></li>
        <li><a href="catageory.php"><i class="fas fa-list"></i> Category</a></li>
        <li><a href="admin.php"><i class="fas fa-user"></i> Total Users (<?php echo $tu; ?>)</a></li>
        <li><a href="adminlost.php"><i class="fas fa-th-list"></i> Lost Posts (<?php echo $tl; ?>)</a></li>
        <li><a href="adminfound.php"><i class="fas fa-check"></i> Found Posts (<?php echo $tf; ?>)</a></li>
        <li><a href="admindraft.php"><i class="fas fa-file-alt"></i> Drafted Posts (<?php echo $td; ?>)</a></li>
        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<div class="content" id="content">
    <div class="container">
        <h1 class="text-center mb-4">New User Sign Up</h1>
        <div class="card">
            <div class="card-body">
                <div class="user-list table-responsive">
                    <?php
                    require("config.php");

                    // Check if the user is authenticated as admin
                    $authenticated_as_admin = true;

                    if ($authenticated_as_admin) {
                        // Fetch pending user accounts from the database
                        $sql = "SELECT * FROM user WHERE is_active = 0";
                        $result = mysqli_query($conn, $sql);

                        // Display user information in the admin panel
                        echo '<table class="table table-bordered table-hover table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Email</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Profile Image</th>
                                        <th>ID Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>
                                    <td>' . $row['email'] . '</td>
                                    <td>' . $row['fname'] . '</td>
                                    <td>' . $row['lname'] . '</td>
                                    <td>';

                            // Check if profile image URL is not empty
                            if (!empty($row['profile_image'])) {
                                echo '<img src="' . $row['profile_image'] . '" alt="Profile Image" onclick="showImageModal(this.src)">';
                            } else {
                                echo 'No image available';
                            }

                            echo '</td>
                                    <td>';

                            // Check if ID image URL is not empty
                            if (!empty($row['id_image'])) {
                                echo '<img src="' . $row['id_image'] . '" alt="ID Image" onclick="showImageModal(this.src)">';
                            } else {
                                echo 'No image available';
                            }

                            echo '</td>
                                    <td><button class="btn btn-primary btn-sm" onclick="activateAccount(\'' . $row['email'] . '\')">Activate</button></td>
                                </tr>';
                        }

                        echo '</tbody></table>';
                    } else {
                        // Redirect to login page if not authenticated as admin
                        header("location: login.php");
                        exit();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for displaying full screen image -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image View</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    function activateAccount(email) {
        console.log("Email:", email)
        // Send an AJAX request to update the user's activation status
        $.ajax({
            type: "POST",
            url: "activate_account.php",
            data: {
                email: email
            },
            success: function(response) {
                // Reload the page to reflect the updated data
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    }

    function showImageModal(src) {
        $('#modalImage').attr('src', src);
        $('#imageModal').modal('show');
    }
</script>
</body>

</html>
