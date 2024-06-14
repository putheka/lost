<?php

require("config.php");
require("session.php");
require("functions.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];
    global $conn;
    if ($type == "lost") {
        $sql = "SELECT `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate`,`draft` FROM `lthings` WHERE `id`=$id";
    } else {
        $sql = "SELECT `discription`,`cat_ref`, `adressid`, `pincode`, `uemail`, `imgid`, `postdate` ,`draft` FROM `fthings` WHERE `id`=$id";
    }
    $row = mysqli_fetch_array(mysqli_query($conn, $sql));

    $user = get_user($row['uemail']);
    $email = $row['uemail'];
    $cat = get_catname($row['cat_ref']);
    $phone = get_phone($row['adressid']);
    $pdate = $row['postdate'];
    $add = get_full_add($row['adressid']);
    $pincode = $row['pincode'];
    $disc = $row['discription'];
    $imgurl = get_imgurl($row['imgid'], $type);

} else {
    //header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost And Found</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Lightbox2 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            color: #333;
        }

        .navbar-brand {
            font-size: 1.5rem;
            color: #fff;
        }

        .post-container {
            margin-top: 20px;
        }

        .post-image {
            border-radius: 10px;
            overflow: hidden;
        }

        .post-image img {
            width: 100%;
            height: 96%;
            display: block;
        }

        .post-details {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .post-details h5 {
            margin-top: 0;
            font-weight: 600;
            color: #333;
        }

        .post-details p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn-container .btn {
            margin-right: 10px;
        }

        .card {
            border: none;
        }

        .card-header {
            background-color: #343b41;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .card-body p {
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">Lost And Found</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <?php if (is_admin()) : ?>
                    <li class="nav-item"><a href="admin.php" class="nav-link">Admin Panel</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="profile.php" class="nav-link">Profile</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container post-container">
        <div class="row">
            <div class="col-md-6">
                <div class="post-image">
                    <a href="<?php echo $imgurl; ?>" data-lightbox="post-image" data-title="Post Image">
                        <img src="<?php echo $imgurl; ?>" alt="Post Image" class="img-fluid">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="post-details card">
                    <div class="card-header">
                        Post Details
                    </div>
                    <div class="card-body">
                        <p><strong>Posted by:</strong> <?php echo $user; ?></p>
                        <p><strong>Email:</strong> <?php echo $email; ?></p>
                        <p><strong>Category:</strong> <?php echo $cat; ?></p>
                        <p><strong>Phone:</strong> <?php echo $phone; ?></p>
                        <p><strong>Date:</strong> <?php echo $pdate; ?></p>
                        <p><strong>Address:</strong> <?php echo "$add - $pincode"; ?></p>
                        <p><strong>Description:</strong> <?php echo $disc; ?></p>
                        <div class="btn-container">
                            <a href="mailto:<?php echo $email; ?>" class="btn btn-primary"><i class="fas fa-envelope"></i> Contact</a>
                            <?php if (is_admin()) : ?>
                            <a href="deletepost.php?id=<?php echo $id; ?>&type=<?php echo $type; ?>" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
</body>

</html>
