
<?php
    require ("session.php");
    require ("config.php");
    require ("functions.php");
    auth_admin();

    mysqli_query($conn,"SET @p0='0'");
    mysqli_query($conn,"CALL `userCount`(@p0)");
    $proce=mysqli_fetch_array(mysqli_query($conn,"SELECT @p0 AS `counts`"));
    $tu=$proce['counts'];

    //$tu=t_count('user');
    $tl=tp_count('lthings');
    $tf=tp_count('fthings');
    $td=draft_post_count();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Area</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        nav {
            background-color: #37474f;
            padding: 10px 20px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }
        nav .brand-logo {
            font-size: 1.8rem;
            text-transform: uppercase;
        }
        nav ul li {
            margin-right: 15px;
        }
        .container {
            margin-top: 20px;
        }
        .card-panel {
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }
        .card-panel-title {
            font-size: 1.4rem;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .btn-action {
            text-transform: uppercase;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            background-color: #546e7a !important;
        }
        .responsive-img {
            max-width: 100%;
            height: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #eeeeee;
            text-transform: uppercase;
            font-weight: bold;
        }
       
    </style>
</head>
<body>



<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
    <a class="navbar-brand" href="#">Admin Area</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link" href="admin_panel.php">User Panding</a></li>
            <li class="nav-item"><a class="nav-link" href="Profile.php">Profile</a></li>
            <li class="nav-item"><a class="nav-link" href="catageory.php">Category</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="logut.php">Logout</a></li>
            
        </ul>
    </div>
    </div>
</nav>
<div class="container">
<div class="row">
        <div class="col s12 m12 l3">
            <div class="card-panel blue-grey darken-2">
                <div class="card-content white-text">
                    <span class="card-title">Total User's</span>
                    <?php echo "<p>$tu</p>" ?>
                    <span><a href="admin.php" class="disabled btn">VIEW</a></span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l3">
            <div class="card-panel blue-grey darken-2">
                <div class="card-content white-text">
                    <span class="card-title">  Lost post's</span>
                    <?php echo "<p>$tl</p>" ?>
                    <span><a href="adminlost.php" class=" btn">VIEW</a></span>
                </div>
            </div>
        </div>
        <div class="col s12 m12 l3">
            <div class="card-panel blue-grey darken-2">
                <div class="card-content white-text">
                    <span class="card-title"> Found post's</span>
                    <?php echo "<p>$tf</p>" ?>
                    <span><a href="adminfound.php" class="btn">VIEW</a></span>
                </div>
            </div>
        </div>

        <div class="col s12 m12 l3">
            <div class="card-panel blue-grey darken-2">
                <div class="card-content white-text">
                    <span class="card-title">Drafted posts</span>
                    <?php echo "<p>$td</p>" ?>
                    <span><a href="admindraft.php" class=" btn">VIEW</a></span>
                </div>
            </div>
        </div>
        
    </div>

    <div class="row">
        <div class="col s12">
            <div class="card-panel blue-grey darken-2 white-text">
                
                <table>
                    <thead>
                        <tr>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Total Posts</th>
                            <th>Delete User</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php get_user_list(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>

