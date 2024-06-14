<?php
require("config.php");
require("session.php");
$user = $_SESSION['login_user'];
$sql = "SELECT `email`, `fname`, `lname`, `password`, `isadmin`, `posts`, `profile_image` FROM `user` WHERE `email`='$user'";
global $conn;
$retval = mysqli_query($conn, $sql);

// Check if query was successful and returned rows
if ($retval && mysqli_num_rows($retval) > 0) {
    $row = mysqli_fetch_array($retval);
    $email = $row['email'];
    $fname = $row['fname'];
    $lname = $row['lname'];
    $profileImage = $row['profile_image'];
} else {
    // Handle the case when no user data is found
    echo "User not found or an error occurred.";
    exit; // Stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = md5($_POST['password']);
    $new_email = $_POST['new_email'];
    $new_password = md5($_POST['new_password']);

    // Check if a new profile image is uploaded
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $fileName = $_FILES['profile_image']['name'];
        $fileTmpName = $_FILES['profile_image']['tmp_name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileError = $_FILES['profile_image']['error'];
        $fileType = $_FILES['profile_image']['type'];

        // Debugging statements
        echo "File uploaded: " . $fileName . "<br>";
        echo "Temp file: " . $fileTmpName . "<br>";
        echo "File size: " . $fileSize . "<br>";
        echo "File error: " . $fileError . "<br>";
        echo "File type: " . $fileType . "<br>";

        // Get file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Allowed file extensions
        $allowedExtensions = array("jpg", "jpeg", "png");

        // Check if the uploaded file is a valid image
        if (in_array($fileExt, $allowedExtensions)) {
            // Generate a unique name for the uploaded image
            $newFileName = uniqid('', true) . "." . $fileExt;

            // Upload the image to the server
            $uploadPath = "profile_images/" . $newFileName;
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                // Update the profile image path in the database
                $sql = "UPDATE `user` SET `profile_image`='$uploadPath' WHERE `email`='$user'";
                mysqli_query($conn, $sql);

                // Remove the old profile image if it exists and it's not the default image
                if ($profileImage && $profileImage !== 'default-profile-image.png') {
                    unlink($profileImage);
                }
            } else {
                echo "Error: There was an error uploading the file.";
            }
        } else {
            echo "Error: Only JPG, JPEG, and PNG files are allowed.";
        }
    }

    // Update profile details
    $sql = "UPDATE `user` SET `fname`='$fname', `lname`='$lname' WHERE `email`='$user'";
    mysqli_query($conn, $sql);

    // Update password if new password is provided
    if (!empty($new_password)) {
        $sql = "UPDATE `user` SET `password`='$new_password' WHERE `email`='$user'";
        mysqli_query($conn, $sql);
    }

    // Update email if new email is provided
    if (!empty($new_email)) {
        $sql = "UPDATE `user` SET `email`='$new_email' WHERE `email`='$user'";
        mysqli_query($conn, $sql);
        $_SESSION['login_user'] = $new_email; // Update session with new email
    }
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fff;
        }

        .bg-color {
            background: #f9f8f8;
        }

        .align-card-center {
            margin-top: 15%;
        }

        .profile-image-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            padding-top: 15%;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.9);
        }

       
        .profile-image-modal-content {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
        }

  
        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8;
        }

        .profile-button {
            background: #BA68C8;
            box-shadow: none;
            border: none;
        }

        .profile-button:hover {
            background: #F9F9F9;
        }

        .profile-button:focus {
            background: #F9F9F9;
            box-shadow: none;
        }

        .profile-button:active {
            box-shadow: none;
        }

        .back:hover {
            color: #F9F9F9;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 15%;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            margin: auto;
            display: block;
            width: 100%;
            height: 100%;
            max-width: 700px;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-content,
        #caption {
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        @keyframes zoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }
    </style>
</head>

<body>

    <div class="container rounded bg-color  align-card-center">
        <div class="row">
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <div class="profile-img-container">
                        <?php
                        if (!empty($profileImage)) {
                            echo '<img id="profile-image" src="' . $profileImage . '" alt="Profile Image" class="rounded-circle mt-5" width="220" height="200">';
                        } else {
                            echo '<img id="profile-image" src="default-profile-image.png" alt="Profile Image" class="rounded-circle mt-5" width="90">';
                        }
                        ?>
                    </div>
                    <span class="font-weight-bold mt-3"><?php echo $fname . ' ' . $lname; ?></span>
                    <span class="text-black-50"><?php echo $email; ?></span>
                </div>
            </div>
            <div class="col-md-8">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-row align-items-center back">
                            <a href="profile.php">Back To Profile</a>
                        </div>
                        <h6 class="text-right">Edit Profile</h6>
                    </div>
                    <form method="post" action="edituser.php" enctype="multipart/form-data">
                        <div class="row mt-2">
                            <div class="col-md-6"><input type="text" class="form-control" placeholder="First Name" name="fname" value="<?php echo $fname; ?>"></div>
                            <div class="col-md-6"><input type="text" class="form-control" placeholder="Last Name" name="lname" value="<?php echo $lname; ?>"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><input type="email" class="form-control" placeholder="New Email" name="new_email" value="<?php echo $email; ?>"></div>
                            <div class="col-md-6"><input type="password" class="form-control" placeholder="Enter New Password" name="new_password"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><input type="password" class="form-control" placeholder="Enter Current Password To change Password" name="password"></div>
                        </div>
                        <div class="mt-5 text-right"><button class="btn btn-warning " type="submit" name="action">Save Profile</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="profile-image-modal" class="profile-image-modal">
        <span class="close">&times;</span>
        <img class="profile-image-modal-content" id="img01">
        <div id="caption"></div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById('profile-image-modal');

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById('profile-image');
        var modalImg = document.getElementById('img01');
        var captionText = document.getElementById('caption');
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }
    </script>

</body>

</html>