<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Bootstrap CSS -->
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
    </style>
</head>

<body>
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
                            <td><img src="' . $row['profile_image'] . '" alt="Profile Image"></td>
                            <td><img src="' . $row['id_image'] . '" alt="ID Image"></td>
                            <td><button class="btn btn-primary" onclick="activateAccount(' . $row['id'] . ')">Activate</button></td>
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
        function activateAccount(userId) {
            // Send an AJAX request to update the user's activation status
            $.ajax({
                type: "POST",
                url: "activate_account.php",
                data: {
                    userId: userId
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
