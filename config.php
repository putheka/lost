<?php

$db_name='db_lostandfound';
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';

// Establish database connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $db_name);

// Check if the connection is successful
if (!$conn) {
    // If connection fails, display error message and terminate script
    die('Could not connect: ' . mysqli_connect_error());
}

// If the connection is successful, no need to explicitly select database
// mysqli_select_db() is not required in this case

// Optionally, you can echo a success message if the connection is established
echo "<p id='you' hidden>Success</p>";

// No need to close connection here as it will be automatically closed at the end of the script


// $conn = mysqli_connect($dbhost, $dbuser, $dbpass);

// if (!$conn) {
//     die('Could not connect: ' . mysqli_error());
//     mysqli_close($conn);
//     }

// $retval = mysqli_select_db($conn,$db_name);

// if ($retval) {
//     echo "<p id='you' hidden >sucess</p>";
// }

?> 