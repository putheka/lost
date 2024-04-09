<?php
session_start();
if (isset($_SESSION['login_user'])) {
    header("location:index.php");
}

if (isset($_GET['signup'])) {
    $x = $_GET['signup'];
    if ($x == 0)
        echo "<p id='sign' hidden>fail</p>";
    if ($x == 1)
        echo "<p id='sign' hidden>success</p>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Lost and Found</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .card {
            margin-top: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #1976d2;
            color: #fff;
            border-radius: 10px 10px 0 0;
            font-weight: bold;
        }

        input[type="submit"] {
            width: 100%;
            border-radius: 20px;
            background-color: #1976d2;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #1565c0;
        }

        input[type="file"] {
            display: none;
        }

        #preview-image {
            max-width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .preview-container {
            position: relative;
            border: 2px dashed #ccc;
            border-radius: 10px;
            overflow: hidden;
            background-color: #f9f9f9;
        }

        .preview-container label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            color: #757575;
            cursor: pointer;
        }

        .toggle-form {
            text-align: center;
            margin-top: 20px;
            color: #1976d2;
            cursor: pointer;
        }

        .toggle-form:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center bg-dark">
                        <h3>Sign Up</h3>
                    </div>
                    <div class="card-body">
                        <form id="signup-form" method="post" action="usersignup.php" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="fname">First Name</label>
                                <input id="fname" type="text" name="fname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="lname">Last Name</label>
                                <input id="lname" type="text" name="lname" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <p> Profile Image</p>
                                <label for="file-input" class="preview-container">
                
                                    <img id="preview-image" src="https://img.freepik.com/free-photo/white-cloud-with-download-icon-cloud-computing-technology-sign-symbol-3d-rendering_56104-1285.jpg?w=1380&t=st=1711097775~exp=1711098375~hmac=eb16db4733390ac5399d61cd49c9d4b0fb63b833b1e0d6ef68744793f4f1df0e" alt="User Preview">
                                   
                                    <input type="file" id="file-input" name="profile_image" accept="image/*" required onchange="previewImage(event)">
                                </label>
                            </div>

                            <!-- <div class="form-group">
                                <p> Profile Image</p>
                                <label for="file-input" class="preview-container">
                
                                    <img id="preview-image" src="https://t4.ftcdn.net/jpg/06/72/14/49/240_F_672144973_a4ZclBijuBlyWaqQDfXo7hFgK6U4fXJU.jpg" alt="User Preview">
                                   
                                    <input type="file" id="file-input" name="profile_image" accept="image/*" required onchange="previewImage(event)">
                                </label>
                            </div> -->
                            <div class="form-group text-center mb-5">
                                <button class="btn btn-dark" type="submit">Sign Up</button>
                            </div>
                        </form>
                        <div class="toggle-form" onclick="toggleForm()">Already have an account? Login here.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

        function toggleForm() {
            window.location.href = "login.php";
        }
    </script>

</body>

</html>
