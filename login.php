<?php
session_start();
if (isset($_SESSION['login_user'])) {
    header("location:index.php");
}

if (isset($_GET['login'])) {
    $x = $_GET['login'];
    if ($x == 0)
        echo "<p id='log' hidden>fail</p>";
}
if (isset($_GET['signup'])) {
    $x = $_GET['signup'];
    if ($x == 0)
        echo "<p id='sign' hidden>fail</p>";
    if ($x == 1)
        echo "<p id='sign' hidden>success</p>";
}
// Check if the signup parameter is present and indicates success
if (isset($_GET['signup']) && $_GET['signup'] === 'success') {
    echo '<script>alert("Sign up successful! You can now login.");</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost and Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .card {
            margin-top: 50px;
        }

        .tabs {
            background-color: #e0e0e0;
        }

        .tabs .tab a {
            color: #455a64;
        }

        .tabs .tab a.active {
            color: #455a64;
        }

        .card-title {
            font-weight: 500;
            color: #455a64;
        }

        input[type="submit"] {
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2 l6 offset-l3">
                <div class="card">
                    <div class="card-content blue-text">
                        <span class="card-title">Lost and Found Things Management</span>
                        <ul class="tabs tabs-fixed-width">
                            <li class="tab"><a href="#login" class="active">Login</a></li>
                            <li class="tab"><a href="#signup">Sign Up</a></li>
                        </ul>
                        <div id="login" class="grey lighten-3">
                            <form id="login-form" method="post" action="userlogin.php">
                                <div class="input-field">
                                    <input id="username" type="text" name="username" required>
                                    <label for="username">Email</label>
                                </div>
                                <div class="input-field">
                                    <input id="password" type="password" name="password" required>
                                    <label for="password">Password</label>
                                </div>
                                <div class="text-align: center mb-5">
                                    <button class="btn waves-effect waves-light justify-content-center" type="submit">Login </button>
                                </div>
                            </form>
                        </div>

                        <div id="signup" class="grey lighten-3">
                            <form id="signup-form" method="post" action="usersignup.php" enctype="multipart/form-data">
                                <div class="input-field">
                                    <input id="email" type="email" name="email" required>
                                    <label for="email">Email</label>
                                </div>
                                <div class="input-field">
                                    <input id="fname" type="text" name="fname" required>
                                    <label for="fname">First Name</label>
                                </div>
                                <div class="input-field">
                                    <input id="lname" type="text" name="lname" required>
                                    <label for="lname">Last Name</label>
                                </div>
                                <div class="input-field">
                                    <input id="password" type="password" name="password" required>
                                    <label for="password">Password</label>
                                </div>
                                <label for="file-input" style="display: block; width: 100%; margin-bottom: 10px;">
                                    <div class="preview-container" style="width: 100%; height: 300px; overflow: hidden; position: relative;">
                                        <!-- Preview Image -->
                                        <label for="profile-image">Profile Image</label>
                                        <img id="preview-image" class="img-fluid img-thumbnail" src="https://img.freepik.com/free-photo/white-cloud-with-download-icon-cloud-computing-technology-sign-symbol-3d-rendering_56104-1285.jpg?w=1380&t=st=1711097775~exp=1711098375~hmac=eb16db4733390ac5399d61cd49c9d4b0fb63b833b1e0d6ef68744793f4f1df0e" alt="User Preview" style="width: 100%; height: 80%; object-fit: cover;">
                                        
                                    </div>
                                    <!-- Input for File -->
                                    <input type="file" class="form-control d-none" id="file-input" name="profile_image" accept="image/*" required onchange="previewImage(event)" style="width: 100%; display: none;">
                                </label>


                                <script>
                                    function previewImage(event) {
                                        const fileInput = event.target;
                                        const previewImage = document.getElementById('preview-image');

                                        const file = fileInput.files[0];
                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            previewImage.src = e.target.result;
                                        };

                                        reader.readAsDataURL(file);
                                    }
                                </script>

                                <div class="text-align: center mb-5">
                                    <button class="btn btn-success justify-content-center" type="submit">Sign Up</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tabs = document.querySelectorAll('.tabs');
            M.Tabs.init(tabs);
        });
    </script>
</body>

</html>