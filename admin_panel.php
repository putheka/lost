<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
        }

        .user-list button {
            padding: 5px 10px;
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
    </style>
</head>

<body>
    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
    <a class="navbar-brand" href="#">Admin Area</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        
            <li class="nav-item"><a class="nav-link" href="Profile.php">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="catageory.php">Category</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="logut.php">Logout</a></li>
            
        </ul>
    </div>
    </div>
</nav>

    <div class="container">
        <h1 class="text-center mb-4">New User Sign Up</h1>
        <div class="user-list">
            <?php
            require("config.php");

            // Check if the user is authenticated as admin
            $authenticated_as_admin = true;

            if ($authenticated_as_admin) {
                // Fetch pending user accounts from the database
                $sql = "SELECT * FROM user WHERE is_active = 0";
                $result = mysqli_query($conn, $sql);

                // Display user information in the admin panel
                echo '<table class="table table-striped">
                        <thead>
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
                        echo '<img src="' . $row['profile_image'] . '" alt="Profile Image">';
                    } else {
                        echo 'No image available';
                    }

                    echo '</td>
                            <td>';

                    // Check if ID image URL is not empty
                    if (!empty($row['id_image'])) {
                        echo '<img src="' . $row['id_image'] . '" alt="ID Image">';
                    } else {
                        echo 'No image available';
                    }

                    echo '</td>
                            <td><button class="btn btn-primary" onclick="activateAccount(\'' . $row['email'] . '\')">Activate</button></td>
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
    </script>
</body>

</html>
