<?php
session_start();
if (isset($_SESSION['login_user'])) {
    header("location:index.php");
}

if(isset($_GET['login'])) {
    $x = $_GET['login'];
    if ($x == 0)
        echo "<p id='log' hidden>fail</p>";
}
if(isset($_GET['signup'])){
    $x = $_GET['signup'];
    if ($x == 0)
        echo "<p id='sign' hidden>fail</p>";
    if($x == 1)
        echo "<p id='sign' hidden>success</p>";
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
            color: #333;
        }
        
        .tabs .tab a.active {
            color: #2196F3;
        }
        
        .card-title {
            font-weight: 500;
            color: #2196F3;
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
                            <button class="btn waves-effect waves-light blue" type="submit">Login</button>
                        </form>
                    </div>
                    <div id="signup" class="grey lighten-3">
                        <form id="signup-form" method="post" action="usersignup.php">
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
                            <button class="btn waves-effect waves-light blue" type="submit">Sign Up</button>
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
