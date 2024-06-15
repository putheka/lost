<?php
require("config.php");
require("functions.php");
session_start();
if (!(isset($_SESSION['login_user']))) {
    header("location:login.php");
}
$user = $_SESSION['login_user'];

// Fetch search parameters
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';
$location = isset($_GET['location']) ? $_GET['location'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Lost Items</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .form-control, .btn {
            border-radius: 10px;
        }
        .form-control:focus, .btn:focus {
            box-shadow: none;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
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
                    echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"admin.php\">Admin Panel</a></li>";
                } ?>
                <li class='nav-item'><a class="nav-link" href="index.php">Home</a></li>
                <li class='nav-item'><a class="nav-link" href="lost.php">Lost Post</a></li>
                <li class='nav-item'><a class="nav-link" href="found.php">Found Post</a></li>
                <li class='nav-item'><a class="nav-link" href="profile.php">PROFILE</a></li>
                <li class='nav-item'><a class="nav-link" href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
    <h1 class="mb-4 text-center">All Lost Items</h1>
    
    <!-- Search Form -->
    <form method="GET" action="view_all_lost_items.php" class="mb-4">
        <div class="form-row justify-content-center">
            <div class="form-group col-md-3 ">
                <input type="text" class="form-control" name="keyword" placeholder="Keyword" value="<?php echo htmlspecialchars($keyword); ?>">
            </div>
            <div class="form-group col-md-3">
                <select class="form-control" name="category">
                    <option value="" disabled selected>Select Category</option>
                    <?php gen_cat_list(); ?>
                </select>
            </div>
            <div class="form-group col-md-3">
                <input type="date" class="form-control" name="date" value="<?php echo htmlspecialchars($date); ?>">
            </div>
           
            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-primary btn-block">Search</button>
            </div>
        </div>
    </form>

    <div class="row">
        <?php echo get_lost_item_cards($keyword, $category, $date, $location); ?>
    </div>
</div>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
