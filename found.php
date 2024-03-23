<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import Bootstrap CSS-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
require("config.php");
require("session.php");
require("functions.php");
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Lost And Found</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if (is_admin()) {
                echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"admin.php\">ADMIN PANEL</a></li>";
            } ?>
            <li class="nav-item"><a class="nav-link" href="profile.php">PROFILE</a></li>
            <li class="nav-item"><a class="nav-link" href="logut.php">LOGOUT</a></li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">Enter Details About Found Item</div>
                <div class="card-body">
                    <form action="foundpost.php" method="post" enctype="multipart/form-data">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="cata">Category:</label>
                                <select class="form-control" id="cata" name="cata" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php gen_cat_list(); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="pincode">Pincode:</label>
                                <input type="number" class="form-control" id="pincode" name="pincode" required
                                       minlength="5" maxlength="6">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discription">Description:</label>
                            <textarea class="form-control" id="discription" name="discription" required
                                      minlength="10" maxlength="80"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="city">City/State:</label>
                            <input type="text" class="form-control" id="city" name="city" required minlength="4">
                        </div>
                        <div class="form-group">
                            <label for="street">Street/Locality:</label>
                            <input type="text" class="form-control" id="street" name="street" required minlength="4">
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="phone">Phone:</label>
                                <input type="number" class="form-control" id="phone" name="phone" required
                                       maxlength="10" minlength="10">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="date">Date:</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                        </div>
                        <label for="file-input" style="display: block; width: 100%; margin-bottom: 10px;">
                            <div class="preview-container" style="width: 100%; height: 300px; overflow: hidden;">
                                <img id="preview-image" class="img-fluid img-thumbnail"
                                     src="https://img.freepik.com/free-photo/white-cloud-with-download-icon-cloud-computing-technology-sign-symbol-3d-rendering_56104-1285.jpg?w=1380&t=st=1711097775~exp=1711098375~hmac=eb16db4733390ac5399d61cd49c9d4b0fb63b833b1e0d6ef68744793f4f1df0e"
                                     alt="User Preview" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="upload-icon">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </div>
                            <input type="file" class="form-control d-none" id="file-input" name="limage" required
                                   onchange="previewImage(event)" style="width: 100%;">
                        </label>

                        <script>
                            function previewImage(event) {
                                const fileInput = event.target;
                                const previewImage = document.getElementById('preview-image');

                                const file = fileInput.files[0];
                                const reader = new FileReader();

                                reader.onload = function (e) {
                                    previewImage.src = e.target.result;
                                };

                                reader.readAsDataURL(file);
                            }
                        </script>

                        <button type="submit" class="btn btn-primary btn-block">POST</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Import Bootstrap JS-->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
