
<body class=" grey darken-2">
<?php
require("config.php");
require ("session.php");
$user=$_SESSION['login_user'];
$sql="SELECT `email`, `fname`, `lname`, `password`, `isadmin`, `posts` FROM `user` WHERE `email`='$user'";
global $conn;
$retval=mysqli_query($conn,$sql);
$row=mysqli_fetch_array($retval);
$email=$row['email'];
$fname=$row['fname'];
$lname=$row['lname'];

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $pasword = md5($_POST['password']);
    $sql = "UPDATE `user` SET `fname`='$fname',`lname`='$lname',`password`='$pasword' WHERE `email`='$user'";
    mysqli_query($conn, $sql);
    header("location:logut.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Detail</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .container {
            margin-top: 50px;
        }
        .card-panel {
            padding: 20px;
        }
        .btn-large {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card-panel white">
                    <h4 class="center-align">Update User Detail</h4>
                    <form method="post" action="edituser.php">
                        <div class="input-field">
                            <input id="email" type="email" name="email" value="<?php echo $email; ?>" disabled>
                            <label for="email" class="active">Email</label>
                        </div>
                        <div class="input-field">
                            <input id="fname" type="text" name="fname" value="<?php echo $fname; ?>" required>
                            <label for="fname" class="active">First Name</label>
                        </div>
                        <div class="input-field">
                            <input id="lname" type="text" name="lname" value="<?php echo $lname; ?>" required>
                            <label for="lname" class="active">Last Name</label>
                        </div>
                        <div class="input-field">
                            <input id="password" type="password" name="password" required>
                            <label for="password" class="active">Password</label>
                        </div>
                        <button class="btn-large waves-effect waves-light blue" type="submit" name="action">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
