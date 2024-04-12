<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
    $userId = $_POST['userId'];

    // Update the user's activation status in the database
    $sql = "SELECT id, email, fname, lname, profile_image, id_image FROM user WHERE is_active = 0";

    if (mysqli_query($conn, $sql)) {
        // Return a success response
        echo "success";
    } else {
        // Return an error response
        echo "error";
    }
} else {
    // Return an error response if userId parameter is not provided
    echo "error";
}
?>
