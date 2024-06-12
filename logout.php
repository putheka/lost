//<?php

// require ("config.php");
// session_start();
// mysqli_commit($con);
// session_destroy();
// header("location:login.php");
// ?>

<?php


require("config.php");
session_start();

// Assuming  connection variable is $conn (or $con)
if ($conn) {
    mysqli_commit($conn);
}

session_destroy();
header("location:login.php");
?>
