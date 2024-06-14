<?php
require("session.php");
require("config.php");
require("functions.php");
auth_admin();

mysqli_query($conn, "SET @p0='0'");
mysqli_query($conn, "CALL `userCount`(@p0)");
$proce = mysqli_fetch_array(mysqli_query($conn, "SELECT @p0 AS `counts`"));
$tu = $proce['counts'];

//$tu=t_count('user');
$tl = tp_count('lthings');
$tf = tp_count('fthings');
$td = draft_post_count();


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
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,700,900|Roboto+Condensed:400,300,700" 
    rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        <li><a href="catageory.php" class="text-primary disabled"><i class="fas fa-list"></i> Category</a></li>
        <li><a href="admin.php"><i class="fas fa-user"></i> Total Users (<?php echo $tu; ?>)</a></li>
        <li><a href="adminlost.php"><i class="fas fa-th-list"></i> Lost Posts (<?php echo $tl; ?>)</a></li>
        <li><a href="adminfound.php"><i class="fas fa-check"></i> Found Posts (<?php echo $tf; ?>)</a></li>
        <li><a href="admindraft.php"><i class="fas fa-file-alt"></i> Drafted Posts (<?php echo $td; ?>)</a></li>
        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>
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


