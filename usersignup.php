<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

    // Handle profile image upload
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["profile_image"]["name"])) . " has been uploaded.";
            // Insert user data into the database
            $sql = "INSERT INTO user (email, fname, lname, password, profile_image) VALUES ('$email', '$fname', '$lname', '$password', '$target_file')";
            mysqli_query($conn, $sql);

            // Redirect to login page with success status
            header("location: login.php?signup=success");
            exit(); // Ensure that script execution stops after redirection
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
