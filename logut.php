//<?php
/**
 * Created by PhpStorm.
 * User: nishan
 * Date: 03-10-2017
 * Time: 11:00 PM
 */

// require ("config.php");
// session_start();
// mysqli_commit($con);
// session_destroy();
// header("location:login.php");
// ?>

<?php


require("config.php");
session_start();

// Assuming your connection variable is $conn (or $con)
if ($conn) {
    mysqli_commit($conn);
}

session_destroy();
header("location:login.php");
?>
