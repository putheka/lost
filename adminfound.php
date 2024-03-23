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
    <title>Admin Found</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        nav {
            background-color: #37474f;
            padding: 10px 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }

        nav .brand-logo {
            font-size: 1.8rem;
            text-transform: uppercase;
        }

        nav ul li {
            margin-right: 15px;
        }

        .container {
            margin-top: 20px;
        }

        .card-panel {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .card-panel-title {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-action {
            text-transform: uppercase;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            background-color: #546e7a !important;
        }

        .responsive-img {
            max-width: 100%;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #eeeeee;
            text-transform: uppercase;
            font-weight: bold;
        }

        tbody tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-wrapper blue-grey darken-3">
        <a href="#" class="brand-logo">Admin Found</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a class="btn btn-action" href="index.php">Home</a></li>
            <li><a class="btn btn-action" href="logut.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col s12 m12 l3">
            <div class="card-panel blue-grey darken-2">
                <div class="card-content white-text">
                    <span class="card-title">Total User's</span>
                    <?php echo "<p>$tu</p>" ?>
                    <span><a href="admin.php" class=" btn">VIEW</a></span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l3">
            <div class="card-panel blue-grey darken-2">
                <div class="card-content white-text">
                    <span class="card-title">  Lost post's</span>
                    <?php echo "<p>$tl</p>" ?>
                    <span><a href="adminlost.php" class="btn">VIEW</a></span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l3">
            <div class="card-panel blue-grey darken-2">
                <div class="card-content white-text">
                    <span class="card-title"> Found post's</span>
                    <?php echo "<p>$tf</p>" ?>
                    <span><a href="adminfound.php" class=" disabled btn">VIEW</a></span>
                </div>
            </div>
        </div>

        <div class="col s12 m12 l3">
            <div class="card-panel blue-grey darken-2">
                <div class="card-content white-text">
                    <span class="card-title">Drafted posts</span>
                    <?php echo "<p>$td</p>" ?>
                    <span><a href="admindraft.php" class=" btn">VIEW</a></span>
                </div>
            </div>
        </div>
    </div><!--main bar-->

    <div class="row">
        <div class="col s12">
            <div class="white-text blue-grey darken-1 xx z-depth-1 card-panel" style="border-radius: 5px;">
                <table class="centered responsive-table">
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
                    <?php
                    get_post_list("found");
                    ?>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    </body>
    </html>