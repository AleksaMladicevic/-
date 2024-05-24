<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - My Recipes</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/Bgimage1.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5); /* Ovo podešava providnost. Menjaj vrednost za više ili manje providnosti */
            z-index: 1;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9); /* Providna bela pozadina */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            z-index: 2;
        }
        header {
            background-color: rgba(0, 123, 255, 0.9); /* Providna plava pozadina */
            color: #fff;
            padding: 15px 0;
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
        }
        header h1 {
            margin: 0;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        h2 {
            color: #333;
        }
        p {
            margin: 20px 0;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Welcome to My Recipes</h2>
        <?php if (isset($_SESSION["user"])) { ?>
            <p>Hello, <?php echo $_SESSION["user"]; ?>! <a href="logout.php" class="button">Logout</a></p>
        <?php } else { ?>
            <p><a href="login.php" class="button">Login</a> or <a href="register.php" class="button">Register</a></p>
        <?php } ?>
    </div>
</body>
</html>
