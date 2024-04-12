<?php

// session_start();
// require("config.php");
// require ("functions.php");

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = mysqli_real_escape_string($conn, $_POST['username']);
//     $password=md5(mysqli_real_escape_string($conn, $_POST['password']));

//     $sql = "SELECT * FROM user WHERE email = '$email' and password='$password' ";
//     $retval=mysqli_query($conn,$sql);

//     $row = mysqli_fetch_array($retval,MYSQLI_ASSOC);

//     $count = mysqli_num_rows($retval);
//     if($count == 1) {
//         global  $email;
//         $_SESSION['login_user'] = $email;
//         mysqli_commit($conn);

//         if(is_admin()){

//             header("location:admin.php");
//         }
//         else
//             header("location: index.php");
//     }else {
//         header("location:login.php?login=0");
//     }
// }else{
//     header("location:login.php?login=x");
// }

session_start();
require("config.php");
require("functions.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['username']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        if ($row['is_active'] == 1) {
            $_SESSION['login_user'] = $email;
            if (is_admin()) {
                header("location: admin.php");
            } else {
                header("location: index.php");
            }
        } else {
            // Account not activated, redirect to a page informing the user
            header("location: pending_approval.php");
        }
    } else {
        // Invalid credentials, redirect to login page with error message
        header("location: login.php?login=0");
    }
} else {
    // Redirect to login page if accessed directly
    header("location: login.php?login=x");
}


?>