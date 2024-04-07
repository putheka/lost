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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lost and Found</title>
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
                        <h3>Login</h3>
                    </div>
                    <div class="card-body">
                        <form id="login-form" method="post" action="userlogin.php">
                            <div class="form-group">
                                <label for="username">Email</label>
                                <input id="username" type="text" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group text-center mb-5">
                                <button class="btn btn-dark" type="submit">Login</button>
                            </div>
                        </form>
                        <div class="toggle-form" onclick="toggleForm()">Don't have an account? Register now.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function toggleForm() {
            window.location.href = "signup.php";
        }
    </script>

</body>

</html>
