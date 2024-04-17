<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Update the user's activation status in the database
    $sql = "UPDATE user SET is_active = 1 WHERE email = '$email'";
    if (mysqli_query($conn, $sql)) {
        // Return a success response
        $message = "success";
        echo "<script type='text/javascript'>alert('$message');</script>";
        // echo "success";
    } else {
        // Return an error response along with the SQL error message
        echo "error: " . mysqli_error($conn);
    }
} else {
    // Return an error response if email parameter is not provided
    echo "error: Email parameter not provided";
}
