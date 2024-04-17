<?php
require("config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['password']));

    // Handle profile image upload
    $target_dir = "upload/profile_images/";
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
            // Profile image uploaded successfully

            // Handle ID image upload
            $id_target_dir = "upload/id_images/";
            $id_target_file = $id_target_dir . basename($_FILES["id_image"]["name"]);
            $id_uploadOk = 1;
            $id_imageFileType = strtolower(pathinfo($id_target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $id_check = getimagesize($_FILES["id_image"]["tmp_name"]);
            if ($id_check !== false) {
                $id_uploadOk = 1;
            } else {
                echo "ID File is not an image.";
                $id_uploadOk = 0;
            }

            // Check file size
            if ($_FILES["id_image"]["size"] > 500000) {
                echo "Sorry, your ID file is too large.";
                $id_uploadOk = 0;
            }

            // Allow certain file formats
            if ($id_imageFileType != "jpg" && $id_imageFileType != "png" && $id_imageFileType != "jpeg"
                && $id_imageFileType != "gif") {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed for ID.";
                $id_uploadOk = 0;
            }

            // Check if $id_uploadOk is set to 0 by an error
            if ($id_uploadOk == 0) {
                echo "Sorry, your ID file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["id_image"]["tmp_name"], $id_target_file)) {
                    // ID image uploaded successfully

                    // Insert user data into the database with is_active set to 0
                    $sql = "INSERT INTO user (email, fname, lname, password, profile_image, id_image, is_active) VALUES ('$email', '$fname', '$lname', '$password', '$target_file', '$id_target_file', 0)";
                    mysqli_query($conn, $sql);

                    // Redirect to pending page with success status
                    header("location: pending_approval.php?signup=success");
                    exit(); // Ensure that script execution stops after redirection
                } else {
                    echo "Sorry, there was an error uploading your ID file.";
                }
            }
        } else {
            echo "Sorry, there was an error uploading your profile image.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Admin Approval</title>
   
</head>
<body>
    <h1>Admin Approval Required</h1>
    <p>Your account has been successfully created. However, it requires approval from an administrator before you can log in. Please wait for admin approval.</p>
</body>
</html>
