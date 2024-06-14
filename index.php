<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost And Found</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


</head>

<body class="grey darken-1">
    <?php
    require("config.php");
    require("functions.php");
    session_start();
    if (!(isset($_SESSION['login_user']))) {
        header("location:login.php");
    }
    $user = $_SESSION['login_user'];
    ?>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Lost And Found</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if (is_admin()) {
                        echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"admin.php\">Admin Panel</a></li>";
                    } ?>
                    <li class='nav-item'><a class="nav-link" href="lost.php">Lost Post</a></li>
                    <li class='nav-item'><a class="nav-link" href="found.php">Found Post</a></li>
                    <li class='nav-item'><a class="nav-link" href="profile.php">Profile</a></li>
                    <li class='nav-item'><a class="nav-link" href="logout.php">Logout</a></li>

                </ul </div>
            </div>
    </nav>

    <!-- Main Content -->
    <!-- Main Content -->
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="jumbotron text-center">
                <h1 class="display-4">Welcome to Lost And Found</h1>
                <p class="lead">Explore the Lost and Found platform to post and search for lost items.</p>
                <hr class="my-4">
                <p>Whether you've lost something valuable or found an item, we're here to help you connect with the right people.</p>
                <a class="btn btn-primary btn-lg mx-2" href="lost.php" role="button">Report Lost Item</a>
                <a class="btn btn-secondary btn-lg mx-2" href="found.php" role="button">Report Found Item</a>
            </div>
        </div>
    </div>

    <div class="row text-center mb-5">
        <div class="col-md-6">
            <div class="card">
                <img src="https://img.freepik.com/free-vector/detective-following-footprints-concept-illustration_114360-15386.jpg?t=st=1713427505~exp=1713431105~hmac=196b46acccc0361bf4cd9f591db896634e7e3db2c4f3d88f394d91156f6ea268&w=1060" class="card-img-top" alt="Lost Items">
                <div class="card-body">
                    <h5 class="card-title">View All Lost Posts</h5>
                    <p class="card-text">Explore all lost items reported by users.</p>
                    <a href="view_all_lost_items.php" class="btn btn-primary">View Lost Items</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <img src="https://img.freepik.com/free-vector/house-moving-concept-with-men_23-2148639608.jpg?t=st=1713428287~exp=1713431887~hmac=aba52b9e8d87aafad2c798454ee72e52e42dd689b4535445cac35f80211b4f28&w=1060" class="card-img-top" alt="Found Items">
                <div class="card-body">
                    <h5 class="card-title">View All Found Posts</h5>
                    <p class="card-text">Browse through all found items reported by users.</p>
                    <a href="view_all_found_items.php" class="btn btn-primary">View Found Items</a>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>