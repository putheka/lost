<?php
require("config.php");
require("session.php");
$user = $_SESSION['login_user'];
$sql = "SELECT `email`, `fname`, `lname`, `password`, `isadmin`, `posts`, `profile_image` FROM `user` WHERE `email`='$user'";
global $conn;
$retval = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($retval);
$email = $row['email'];
$fname = $row['fname'];
$lname = $row['lname'];
$profileImage = $row['profile_image'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $pasword = md5($_POST['password']);

    // Check if a new profile image is uploaded
    if ($_FILES['profile_image']['name']) {
        // Debugging statements
        echo "File uploaded: " . $_FILES['profile_image']['name'] . "<br>";
        echo "Temp file: " . $_FILES['profile_image']['tmp_name'] . "<br>";
        echo "File size: " . $_FILES['profile_image']['size'] . "<br>";
        echo "File error: " . $_FILES['profile_image']['error'] . "<br>";
        echo "File type: " . $_FILES['profile_image']['type'] . "<br>";

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
            move_uploaded_file($fileTmpName, $uploadPath);

            // Update the profile image path in the database
            $sql = "UPDATE `user` SET `profile_image`='$uploadPath' WHERE `email`='$user'";
            mysqli_query($conn, $sql);

            // Remove the old profile image if it exists and it's not the default image
            if ($profileImage && $profileImage !== 'default-profile-image.png') {
                unlink($profileImage);
            }

            // Update the profile details
            $sql = "UPDATE `user` SET `fname`='$fname',`lname`='$lname',`password`='$pasword' WHERE `email`='$user'";
            mysqli_query($conn, $sql);
            header("location:logut.php");
        } else {
            echo "Error: Only JPG, JPEG, and PNG files are allowed.";
        }
    } else {
        // Update profile details without changing the profile image
        $sql = "UPDATE `user` SET `fname`='$fname',`lname`='$lname',`password`='$pasword' WHERE `email`='$user'";
        mysqli_query($conn, $sql);
        header("location:logut.php");
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

        .profile-img-container {
            width: 150px;
            height: 150px;
            overflow: hidden;
            border-radius: 50%;
            margin: 0 auto 20px;
        }

        .profile-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        input[type="file"] {
            display: none;
        }

        .upload-btn {
            display: block;
            width: 100%;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>

<body class="grey darken-2">

    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card-panel white">
                    <h4 class="center-align">Update User Detail</h4>
                    <form method="post" action="edituser.php" enctype="multipart/form-data">
                        <div class="profile-img-container">
                            <?php
                            // Display current profile image
                            $profileImageQuery = "SELECT profile_image FROM user WHERE email='$user'";
                            $profileImageResult = mysqli_query($conn, $profileImageQuery);
                            if ($profileImageResult && mysqli_num_rows($profileImageResult) > 0) {
                                $row = mysqli_fetch_assoc($profileImageResult);
                                $profileImagePath = $row['profile_image'];
                                echo '<img src="' . $profileImagePath . '" alt="Profile Image">';
                            } else {
                                echo '<img src="default-profile-image.png" alt="Profile Image">';
                            }
                            ?>
                        </div>
                        <div class="file-field input-field">
    <div class="btn">
        <span>Choose Image</span>
        <input type="file" name="profile_image" id="profile_image" accept="image/*">
    </div>
    <div class="file-path-wrapper">
        <input class="file-path validate" type="text" placeholder="Upload profile image">
    </div>
</div>



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
                        <button class="btn-large waves-effect waves-light success" type="submit" name="action">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var elems = document.querySelectorAll('.file-field');
        var instances = M.FileField.init(elems);
    });
</script>

</body>

</html>