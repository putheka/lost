<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin: 50px auto;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <img class="mt-0" src="https://img.freepik.com/free-psd/3d-transparent-hourglass_23-2148938928.jpg?t=st=1712944347~exp=1712947947~hmac=d225fb47c2d296b4a14c11b3cec3390bd95044bba98c62cb4401a31478d9e80d&w=740" class="card-img-top mx-auto mt-4" alt="Pending Approval Image">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">Your Account is Pending Approval</h1>
                <p class="card-text text-center">Your account is awaiting approval from the administrator. Please wait until your account is activated.</p>
                <p class="card-text text-center">For any inquiries, you can contact us at:</p>
                <ul class="list-unstyled">
                    <li class="text-center">Gmail: lostandfound@gmail.com</li>
                    <li class="text-center">Telegram: @lostandfound</li>
                    <li class="text-center">Facebook: Lost and Found</li>

                </ul>
                <div class="text-center">
                    <button type="button" class="btn btn-primary " onclick="toggleForm()">Go to Login Page</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (jQuery, Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>

        function toggleForm() {
                window.location.href = "login.php";
            }
    </script>
</body>
</html>
