<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
           
        }

        .navbar-brand, .nav-link, .logout-btn {
            color: white !important;
            font-weight: 500;
        }

        .logout-btn:hover{
            color: black;
            background-color: red;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Ticket Sharing</a>
        <div class="ms-auto">
            <a class="btn  logout-btn" href="bushome.php">Logout</a>
        </div>
    </div>
    </nav>
</body>
</html>